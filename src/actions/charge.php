<?php
require_once '../../vendor/autoload.php';

$stripeApiKey = 'sk_test_51OLzujFbfnG6W3PmYVxQjpVTvRsZIdU57Oh2y0aRxUh41w25U1rXfmQJloKZAtP87V8QNFvA42qRfcOqemnZlc8V00QoO83yh4';
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
