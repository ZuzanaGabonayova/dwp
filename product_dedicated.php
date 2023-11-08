<?php
// Include CRUD operations file
require 'crud_operations.php';

// Assume $productID is provided to query the product
$productID = 8; // Example product ID

// Fetch product data
$product = readProduct($productID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Tailwind CSS Link -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <?php if ($product): ?>
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/2 px-4 mb-8">
                    <img class="w-full h-auto rounded shadow" src="<?php echo htmlspecialchars($product['ProductMainImage']); ?>" alt="Product Image">
                </div>
                <div class="w-full md:w-1/2 px-4 mb-8">
                    <h2 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($product['Model']); ?></h2>
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($product['Description']); ?></p>
                    <p class="text-gray-700 mb-4"><strong>Price:</strong> $<?php echo htmlspecialchars($product['Price']); ?></p>
                    <p class="text-gray-700 mb-4"><strong>Color:</strong> <?php echo htmlspecialchars($product['Color']); ?></p>
                    <p class="text-gray-700 mb-4"><strong>Size:</strong> <?php echo htmlspecialchars($product['Size']); ?></p>
                    <p class="text-gray-700 mb-4"><strong>Stock Quantity:</strong> <?php echo htmlspecialchars($product['StockQuantity']); ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
