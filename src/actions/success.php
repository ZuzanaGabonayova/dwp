<?php
if (!empty($_GET['tid'] && !empty($_GET['product']))) {
    $GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);

    $tid = $GET['tid'];
    $product = $GET['product'];
} else {
    header('Location:../../views/checkout.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you</title>
</head>

<body>
    <div class="container mt-4">
        <h2>Thank you for purchasing <?php echo $product; ?></h2>
        <hr>
        <p>Your transaction ID is <?php echo $tid; ?></p>
        <p>Check your email for more info</p>
        <p><a href="../../views/checkout.php" class="btn btn-light mt-2">Go Back</a></p>
    </div>

</body>

</html>