<?php
$hostname = 'zuzanagabonayova.eu';
$username = 'zuzanagabonayova_euwebshopdb';
$password = 'dwp2023';
$database = 'zuzanagabonayova_euwebshopdb';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
