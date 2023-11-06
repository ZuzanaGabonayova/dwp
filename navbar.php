<?php
session_start(); // Start the session or resume an existing one
$cartItemCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
<nav class="bg-gray-800 p-3 text-white">
    <div class="container mx-auto flex items-center justify-between">
        <a href="/" class="text-xl font-bold">My Shop</a>
        <div class="flex gap-6">
            <a href="news.php">News</a>
            <a href="visitor_product_page.php">Products</a>
        </div>
        <div>
            <a href="view_cart.php" class="relative inline-block">
                <i class="fas fa-shopping-cart"></i>
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                    <?php echo $cartItemCount; ?>
                </span>
            </a>
        </div>
    </div>
</nav>

<!-- Your page content goes here -->

</body>
</html>
