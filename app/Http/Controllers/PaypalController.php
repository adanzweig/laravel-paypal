<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaypalController extends Controller
{
    // Define class-level private variables
    private $clientId;
    private $appSecret;
    private $baseURL;

    // Constructor initializes the environment variables
    public function __construct()
    {
        $this->clientId = env('PAYPAL_CLIENT_ID', '');  // Get PayPal client ID from .env
        $this->appSecret = env('PAYPAL_APP_SECRET', '');  // Get PayPal app secret from .env
        $this->baseURL = env('PAYPAL_MODE') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';  // Determine if we are using PayPal sandbox or production
    }

    // Function to display the PayPal payment form (Blade view)
    public function showPaypalForm()
    {
        return view('paypal');
    }

    // Function to initiate a new PayPal order
    public function createOrder(Request $request)
    {
        $accessToken = $this->generateAccessToken();  // Get access token for PayPal API authentication
        $url = "{$this->baseURL}/v2/checkout/orders";  // Endpoint URL for creating an order

        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => '100.00'
                    ]
                ]
            ]
        ]));

        // Execute cURL session and close it
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the JSON response
        $order = json_decode($response, true);

        // Loop through the order links to find the "approve" link
        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                // Return the approve link
                return response()->json(['url' => $link['href']]);
            }
        }

        // If "approve" link is not found, return an error
        return response()->json(['error' => 'Approve link not found'], 500);
    }

    // Function to get the access token for PayPal API authentication
    private function generateAccessToken()
    {
        // Encode client ID and app secret for basic authentication
        $auth = base64_encode($this->clientId . ':' . $this->appSecret);

        // Endpoint URL for getting the access token
        $url = "{$this->baseURL}/v1/oauth2/token";

        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $auth
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');

        // Execute cURL session and close it
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        // Return the access token
        return $data['access_token'];
    }
}
