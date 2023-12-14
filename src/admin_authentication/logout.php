<?php
session_start();

require_once __DIR__ . '../../utils/url_helpers.php';



// Unset all of the session variables
$_SESSION = array();

// If the session was set with a cookie, invalidate the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect the user to the login page after logout
header("Location: " . baseUrl() . "src/views/admin/admin_login.php");
exit();
?>