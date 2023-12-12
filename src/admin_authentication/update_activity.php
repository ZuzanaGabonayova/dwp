<?php
session_start();

// Function to update last activity time
function updateLastActivityTime() {
    $_SESSION['last_activity_time'] = time(); // Update the last activity time to the current time
}

// Call the function to update last activity time
updateLastActivityTime();
?>
