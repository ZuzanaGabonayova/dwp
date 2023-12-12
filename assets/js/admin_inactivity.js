document.addEventListener("DOMContentLoaded", function() {
    let inactivityTime = 30000; // 30 seconds in milliseconds
    let timeout;

    function setActivity() {
        clearTimeout(timeout);
        timeout = setTimeout(logoutUser, inactivityTime);
    }

    function logoutUser() {
        console.log("Logging out user due to inactivity...");
        // AJAX call to update the server's last activity time using a separate PHP script
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "/dwp/src/admin_authentication/update_activity.php", true); // Update_activity.php should handle only updating the last activity time
                
        xhr.send();
        
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log("Activity updated successfully.");
            } else if (this.readyState === 4 && this.status !== 200) {
                console.log("Error updating activity:", this.status, this.statusText);
            }
        };
    }

    // Event listeners to detect user activity
    document.addEventListener("mousemove", setActivity);
    document.addEventListener("mousedown", setActivity);
    document.addEventListener("keypress", setActivity);

    setActivity(); // Set initial activity on page load
});
