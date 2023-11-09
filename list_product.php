<?php 
require 'db.php'; // Include the database
require 'crud_operations.php'; // Include the CRUD operations

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-8">Product Listing</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($products as $product): ?>
            <?php
                // Extract product sizes and colors
                $sizes = explode(',', $product['Sizes']);
                $colors = explode(',', $product['Colors']);
            ?>
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white">
                <img class="w-full" src="/path/to/images/<?= htmlspecialchars($product['ProductMainImage']) ?>" alt="<?= htmlspecialchars($product['Model']) ?>">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2"><?= htmlspecialchars($product['Model']) ?></div>
                    <p class="text-gray-700 text-base"><?= htmlspecialchars($product['Description']) ?></p>
                    <p class="text-gray-900 text-base font-bold">Price: $<?= htmlspecialchars($product['Price']) ?></p>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <?php foreach ($sizes as $size): ?>
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Size: <?= htmlspecialchars($size) ?></span>
                    <?php endforeach; ?>
                    <?php foreach ($colors as $color): ?>
                        <!-- Example color class name, replace 'blue' with actual color logic -->
                        <span class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2 mb-2"><?= htmlspecialchars($color) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>

