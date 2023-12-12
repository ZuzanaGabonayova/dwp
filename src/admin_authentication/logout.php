<?php
session_start();

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
header("Location: ../views/admin/admin_login.php");
exit();
?>
