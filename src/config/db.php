<?php
$servername = "142.93.169.155";
$username = "phqmbyaurd"; 
$password = "5hw7pJkTr2"; 
$dbname = "phqmbyaurd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>