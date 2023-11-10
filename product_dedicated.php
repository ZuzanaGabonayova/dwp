<?php
require 'db.php'; // Include the database configuration
require 'crud_operations.php';

// Include all your provided functions here

if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $product = readProduct($productID, $conn);
    $productColors = getProductColors($productID, $conn);
    $productSizes = getProductSizes($productID, $conn);
    $categoryName = getCategoryName($product['CategoryID'], $conn);
    $brandName = getBrandName($product['BrandID'], $conn);
    $authorName = getAuthorName($product['AdminID'], $conn); // Adjust as per your table structure
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-4">
        <?php if ($product): ?>
            <div class="max-w-xl mx-auto bg-white p-5 rounded shadow">
                <h2 class="text-2xl font-bold mb-2"><?= htmlspecialchars($product['Model']) ?></h2>
                <img src="<?= htmlspecialchars($product['ProductMainImage']) ?>" alt="Product Image" class="w-full h-64 object-cover mb-3">
                <p><?= nl2br(htmlspecialchars($product['Description'])) ?></p>
                <p class="font-bold mt-3">Price: $<?= htmlspecialchars($product['Price']) ?></p>
                <p class="mt-3">Colors: <?= htmlspecialchars(implode(", ", $productColors)) ?></p>
                <p class="mt-1">Sizes: <?= htmlspecialchars(implode(", ", $productSizes)) ?></p>
                <p class="mt-1">Category: <?= htmlspecialchars($categoryName) ?></p>
                <p class="mt-1">Brand: <?= htmlspecialchars($brandName) ?></p>
                <p class="mt-1">Posted by: <?= htmlspecialchars($authorName) ?></p>
            </div>
        <?php else: ?>
            <p class="text-center">Product not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
