<?php

use App\Http\Controllers\PaypalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/paypal',[PaypalController::class,'showPaypalForm'])->name('paypal.form');
Route::post('/create-paypal-order',[PaypalController::class,'createOrder'])->name('create-paypal-order');
Route::get('/', function () {
    return view('welcome');
});
