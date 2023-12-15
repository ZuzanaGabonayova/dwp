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
    <title>Shoes Webshop - Home</title>
    <link rel="stylesheet" href="/assets/css/output.css">
    <meta name="description" content="Discover the latest trends in footwear at our Shoes Webshop. Explore our wide range of high-quality shoes for men, women, and kids. Shop now for the best deals.">
    <script src="https://www.google.com/recaptcha/api.js?render=6LepMS8pAAAAAJPGIRlkaEZr7EdRB1yVdYaXCWnp" async defer></script>
</head>
<body>
    <div>

        <?php

        $content = __DIR__ . '/src/components/frontend/home_content_wrapper.php';
        include_once __DIR__ . '/src/layouts/frontend.php';

        ?>

    </div>
   <script src="/assets/js/recaptcha.js"></script>
</body>
</html>