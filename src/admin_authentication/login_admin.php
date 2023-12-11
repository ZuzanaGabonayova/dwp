<?php
session_start();

require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve hashed password from the database based on the entered username
    $sql = "SELECT Password FROM Admin WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password'];

        // Compare entered password with the hashed password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_username'] = $username;
            // Redirect to admin dashboard
            header("Location: ../views/admin.php");
            exit();
        } else {
            echo "Invalid username or password!";
        }
    } else {
        echo "Admin user does not exist!";
    }
}

$conn->close();
?>
