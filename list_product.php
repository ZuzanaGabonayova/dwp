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
        <?php
            // Assume $products is an array of product data you've fetched from your database
            foreach ($products as $product) {
                // Extract product sizes and colors
                $sizes = explode(',', $product['Sizes']);
                $colors = explode(',', $product['Colors']);

                echo "<div class='max-w-sm rounded overflow-hidden shadow-lg bg-white'>";
                echo "<img class='w-full' src='assets/images" . htmlspecialchars($product['ProductMainImage']) . "' alt='" . htmlspecialchars($product['Model']) . "'>";
                echo "<div class='px-6 py-4'>";
                echo "<div class='font-bold text-xl mb-2'>" . htmlspecialchars($product['Model']) . "</div>";
                echo "<p class='text-gray-700 text-base'>" . htmlspecialchars($product['Description']) . "</p>";
                echo "<p class='text-gray-900 text-base font-bold'>Price: $" . htmlspecialchars($product['Price']) . "</p>";
                echo "</div>";
                echo "<div class='px-6 pt-4 pb-2'>";
                
                // Sizes
                foreach ($sizes as $size) {
                    echo "<span class='inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2'>Size: " . htmlspecialchars($size) . "</span>";
                }
                // Colors
                foreach ($colors as $color) {
                    echo "<span class='inline-block bg-" . htmlspecialchars($color) . "-200 rounded-full px-3 py-1 text-sm font-semibold text-" . htmlspecialchars($color) . "-700 mr-2 mb-2'>" . htmlspecialchars($color) . "</span>";
                }
                
                echo "</div>";
                echo "</div>";
            }
        ?>
    </div>
</div>

</body>
</html>
