# Laravel PayPal Integration using cURL

This project demonstrates a simple integration of PayPal into a Laravel application using PHP's cURL functions.

## Prerequisites

- PHP >= 8.1
- Laravel >= 10.10
- A PayPal Developer account for client ID and secret
- cURL enabled in your PHP configuration

## Setup

1. **Clone the Repository**
   
   ```bash
   git clone https://github.com/adanzweig/laravel-paypal.git
   cd laravel-paypal
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

3. **Environment Variables**

   Rename `.env.example` to `.env` and configure the following variables:

   ```env
   PAYPAL_CLIENT_ID=<Your_PayPal_Client_ID>
   PAYPAL_APP_SECRET=<Your_PayPal_App_Secret>
   PAYPAL_MODE=sandbox # or production
   ```

4. **Generate App Key**

   ```bash
   php artisan key:generate
   ```

5. **Run the Application**

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser.

## Usage

1. Navigate to `/paypal` to see the PayPal payment form.
2. Click on the payment button to initiate a PayPal order.

## Features

- **Generate PayPal Access Token**: Before making any transaction, an access token is generated for authentication.
  
- **Create PayPal Order**: Initiates a new order with a specified amount.

- **Approve PayPal Order**: Once the order is created, you'll be redirected to PayPal's approval link.

## Note

This is a basic integration and might require additional features like error handling, capturing payments, processing refunds, etc., for a production-ready application.

## Contributing

Contributions are welcome. Feel free to open a pull request with improvements.

## License

This project is open-sourced software licensed under the MIT license.
