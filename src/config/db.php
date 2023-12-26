<?php
use Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable('/home/master/applications/squkanhyqf/public_html'); // Adjusted path to load .env from two directories back
$dotenv->load();

$servername = $_ENV['DB_HOST'] ?? null;
$username = $_ENV['DB_USER'] ?? null;
$password = $_ENV['DB_PASS'] ?? null;
$dbname = $_ENV['DB_NAME'] ?? null;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>