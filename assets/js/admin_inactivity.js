document.addEventListener("DOMContentLoaded", function() {
    let inactivityTime = 30000; // 30 seconds in milliseconds
    let timeout;

    function setActivity() {
        clearTimeout(timeout);
        timeout = setTimeout(logoutUser, inactivityTime);
    }

    function logoutUser() {
        // AJAX call to update the server's last activity time using a separate PHP script
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "/src/admin_authentication/update_activity.php", true); // Update_activity.php should handle only updating the last activity time
        xhr.send();
    }

    // Event listeners to detect user activity
    document.addEventListener("mousemove", setActivity);
    document.addEventListener("mousedown", setActivity);
    document.addEventListener("keypress", setActivity);

    setActivity(); // Set initial activity on page load
});
