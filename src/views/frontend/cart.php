<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../../config/db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../../../assets/css/output.css">
</head>

<body class="">

    <?php

        $content = __DIR__ . '/../../components/frontend/cart.php';
        include_once __DIR__ . '../../../layouts/frontend.php';

    ?>    

</body>

</html>