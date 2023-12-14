<?php
use Dotenv\Dotenv;

require_once __DIR__ . '../../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable('/home/master/applications/phqmbyaurd/public_html'); // Adjusted path to load .env from two directories back
$dotenv->load();

$stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'] ?? null;
?>