<?php
session_start();

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
        echo json_encode(["status" => "logged_out"]); // Signal that the user is logged out
        exit();
    } else {
        // Update last activity time as the user is active
        updateLastActivityTime();
        echo json_encode(["status" => "active"]); // Signal that the user is active
        exit();
    }
}

// Call the function to update last activity time and check for session timeout
checkSessionTimeout();
?>