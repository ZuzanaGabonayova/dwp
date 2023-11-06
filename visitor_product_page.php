<?php
require 'db.php';         // Make sure this path is correct
require 'crud_operations.php'; // Make sure this path is correct

// Get the list of products
$products = readProducts();
?>
<?php
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <div class="flex justify-between items-center pb-6">
        <div>
            <a class="text-xl text-blue" href="view_cart.php">Cart</a>
            <h2 class="text-4xl font-semibold">Products</h2>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid md:grid-cols-3 gap-6">
        <?php if ($products): ?>
            <?php while ($product = $products->fetch_assoc()): ?>
                <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white">
                    <img class="w-full" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2"><?php echo htmlspecialchars($product['name']); ?></div>
                        <p class="text-gray-700 text-base">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>
                    </div>
                    <div class="px-6 pt-4 pb-2">
                        <span class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></span>
                        <!-- Add to Cart Button -->
                        <form action="add_to_cart.php" method="post" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
