<?php
session_start();

// Check if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../views/admin/admin_login.php"); // Redirect to the admin login page
    exit();
}

?>