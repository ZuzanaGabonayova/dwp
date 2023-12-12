document.addEventListener("DOMContentLoaded", function() {
    let inactivityTime = 600000; // 600 seconds in milliseconds (10 minutes)
    let timeout;

    function setActivity() {
        clearTimeout(timeout);
        timeout = setTimeout(logoutUser, inactivityTime);
    }

    function logoutUser() {
        console.log("Logging out user due to inactivity...");
        // AJAX call to update the server's last activity time using a separate PHP script
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../../admin_authentication/update_activity.php", true); // Update_activity.php should handle only updating the last activity time
        console.log(xhr);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === "logged_out") {
                            // Redirect or perform any other action upon logout
                            console.log("User logged out due to inactivity.");
                            // Redirect user to the logout page
                            window.location.href = "../../admin_authentication/logout.php";
                        } else {
                            console.log("Unexpected response:", response);
                        }
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                } else {
                    console.error("Error updating activity:", xhr.status, xhr.statusText);
                }
            }
        };
        xhr.send();
    }

    // Event listeners to detect user activity
    document.addEventListener("mousemove", setActivity);
    document.addEventListener("mousedown", setActivity);
    document.addEventListener("keypress", setActivity);

    setActivity(); // Set initial activity on page load
});
