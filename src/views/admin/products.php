<?php

require_once '../../admin_authentication/loggedin.php';

// Call the function to update last activity time
updateLastActivityTime();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin</title>
    <link rel="stylesheet" href="../../../assets/css/output.css">
</head>
<body>
    <div>
        <?php

        $content = __DIR__ . '/../../components/admin/products_list.php';
        include_once __DIR__ . '/../../layouts/backend.php';


        ?>
    </div>

    <script src="../../../assets/js/admin_inactivity.js"></script>
</body>
</html>