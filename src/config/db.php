<?php
$servername = "142.93.169.155";
$username = "phqmbyaurd"; // default XAMPP username
$password = "5hw7pJkTr2"; // default XAMPP password
$dbname = "phqmbyaurd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>