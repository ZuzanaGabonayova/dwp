<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'shoes_shop';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
