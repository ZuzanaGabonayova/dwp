<?php
use Dotenv\Dotenv;

require_once __DIR__ . '../../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable('/home/master/applications/squkanhyqf/public_html'); 
$dotenv->load();

$stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'] ?? null;
?>