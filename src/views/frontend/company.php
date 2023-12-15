<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
session_start();

require_once __DIR__ . '../../../utils/url_helpers.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company</title>
    <link rel="stylesheet" href="../../../assets/css/output.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LepMS8pAAAAAJPGIRlkaEZr7EdRB1yVdYaXCWnp" async defer></script>
</head>
<body>
    <div>
        <?php

        $content = __DIR__ . '/../../components/frontend/company.php';
        include_once __DIR__ . '../../../layouts/frontend.php';

        ?>
    </div>
    <script src="<?php echo baseUrl() ?>assets/js/recaptcha.js"></script>
</body>
</html>