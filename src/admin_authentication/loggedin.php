<?php
session_start();

require_once __DIR__ . '../../utils/url_helpers.php';

// Function to update last activity time
function updateLastActivityTime() {
    $_SESSION['last_activity_time'] = time(); // Update the last activity time to the current time
}

// Function to check for session timeout and log out if needed
function checkSessionTimeout() {
    $timeout = 600; // 600 seconds - 10 minutes

    if (isset($_SESSION['last_activity_time']) && (time() - $_SESSION['last_activity_time']) > $timeout) {
        // If the difference between current time and last activity time exceeds the timeout, logout
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header("Location: " . baseUrl() . "src/views/admin/admin_login.php"); // Redirect to the login page
        exit();
    } else {
        // Update last activity time as the user is active
        updateLastActivityTime();
    }
}

// Call the function to update last activity time
updateLastActivityTime();

// Call the function to check for session timeout
checkSessionTimeout();

// Check if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: " . baseUrl() . "src/views/admin/admin_login.php"); // Redirect to the admin login page
    exit();
}

?>