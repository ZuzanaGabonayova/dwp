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
    <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:max-w-7xl  lg:gap-x-8 lg:px-8">
        <?php if ($product): ?>
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <div class="aspect-square rounded-lg ">
                    <img src="<?= htmlspecialchars($product['ProductMainImage']) ?>" alt="Product Image" class="h-full w-full object-cover object-center">
                </div>
                <div class="px-8 mt-20 lg:mt-0 sm:px:0 sm:mt-16 ">
                    <h1 class="text-3xl font-bold mb-2 tracking-tight"><?= htmlspecialchars($product['Model']) ?></h1>
                    <p><?= nl2br(htmlspecialchars($product['Description'])) ?></p>
                    <p class="font-bold mt-3">Price: $<?= htmlspecialchars($product['Price']) ?></p>
                    <p class="mt-3">Colors: <?= htmlspecialchars(implode(", ", $productColors)) ?></p>
                    <div class="mt-10">
                        <div class="grid grid-cols-3 gap-4 sm:grid-cols-6 lg:grid-cols-3">
                            <div <?= htmlspecialchars(implode(", ", $productSizes)) ?> class="group relative flex items-center justify-center rounded-md border border-[#F39200] py-3 px-4 text-sm font-medium uppercase sm:py-6 cursor-pointer bg-white text-gray-900 shadow-sm undefined">

                            </div>
                            <p class="mt-1">Sizes: <?= htmlspecialchars(implode(", ", $productSizes)) ?></p>
                        </div>
                    </div>
                    <p class="mt-1">Category: <?= htmlspecialchars($categoryName) ?></p>
                    <p class="mt-1">Brand: <?= htmlspecialchars($brandName) ?></p>
                    <p class="mt-1">Posted by: <?= htmlspecialchars($authorName) ?></p>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center">Product not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
