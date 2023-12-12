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
    <title>Company</title>
    <link rel="stylesheet" href="../../../assets/css/output.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fade-in {
            animation: fadeIn 1s;
        }
    </style>
   
</head>
<body>
    <div>
        <?php

        $content = __DIR__ . '/../../components/frontend/company.php';
        include_once __DIR__ . '../../../layouts/frontend.php';

        ?>
    </div>
</body>
</html>