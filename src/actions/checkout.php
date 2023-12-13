<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../../vendor/autoload.php';
require_once '../config/secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
session_start();

$YOUR_DOMAIN = 'https://zuzanagabonayova.eu/';

// Retrieve cart items from session
$cartItems = $_SESSION["shopping_cart"] ?? [];

// Prepare line items for Stripe Checkout
$line_items = array_map(function ($item) {
    return [
        'price' => $item['stripe_price_id'], 
        'quantity' => $item['item_quantity'],
    ];
}, $cartItems);

// Create the Checkout Session
$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => $line_items,
    'phone_number_collection' => ['enabled' => true],
    'mode' => 'payment',
    'shipping_address_collection' => ['allowed_countries' => ['DK']],
    'success_url' => $YOUR_DOMAIN . 'src/views/frontend/success.html',
    'cancel_url' => $YOUR_DOMAIN . 'src/views/frontend/cancel.html',
]);

// Redirect to Stripe Checkout
header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
