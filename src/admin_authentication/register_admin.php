<?php

require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password']; 

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert admin details into the database
    $sql = "INSERT INTO Admin (FirstName, LastName, Email, Username, Password)
    VALUES ('$firstname', '$lastname', '$email', '$username', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Admin registered successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
