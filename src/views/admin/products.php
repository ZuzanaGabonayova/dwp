<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

        $content = __DIR__ . '/../../components/admin/products_list.php';
        include_once __DIR__ . '/../../layouts/backend.php';


        ?>
    </div>
</body>
</html>