<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kids Category</title>
    <link rel="stylesheet" href="../../../assets/css/output.css">
</head>
<body>
    <div>
        <?php

        $content = __DIR__ . '/../../components/frontend/products_category_kids.php';
        include_once __DIR__ . '../../../layouts/frontend.php';

        ?>
    </div>
</body>
</html>