<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../admin_authentication/loggedin.php';

// Call the function to update last activity time
updateLastActivityTime();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body>
    <div>
        <?php

        $content = '../../components/dashboard.php';
        include_once '../../layouts/backend.php';

        ?>
    </div>

    <script src="../../../assets/js/admin_inactivity.js"></script>
</body>
</html>