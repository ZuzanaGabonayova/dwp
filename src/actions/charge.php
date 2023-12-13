<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../vendor/autoload.php';

$stripeApiKey = 'sk_test_51OM4z2J10R2MRSEdRY8R4JkH25vSIbM6uvC9zc1aF2gZlFXYeNofe5d1ziQuZVGm7TrxToiM903bOUZg4pmULUJX00lv0N4y7d';
\Stripe\Stripe::setApiKey($stripeApiKey);

//sanitize post array (filter the bad info)

$_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$token = $_POST['stripeToken'];

//create customer in stripe
$customer = \Stripe\Customer::create(array(
    "email" => $email,
    "source" => $token
));

//charge customer
$charge = \Stripe\Charge::create(array(
    "amount" => 5000,
    "currency" => "DKK",
    "description" => "nike dunks 5467R",
    "customer" => $customer->id
));

//redirect to success
header('Location: ../../src/actions/success.php?tid=' . $charge->id . '&product=' . $charge->description);
