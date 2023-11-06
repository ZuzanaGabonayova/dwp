<?php

require 'db.php'; // Include the database connection
require 'crud_operations.php'; // Include the CRUD operations

// Attempt to fetch all products
$products = readProducts();

// Function to get the base URL of the script
function baseUrl() {
    // Normally you would make this dynamic or configured, but for localhost it's simple
    return 'http://localhost/dwp/';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-6">Product List</h2>

    <a href="<?php echo baseUrl(); ?>product_form.php" class="mb-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Add Product
    </a>

    <table class="table-auto w-full mb-6">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Description</th>
                <th class="py-3 px-6 text-center">Price</th>
                <th class="py-3 px-6 text-center">Image</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap"><?php echo htmlspecialchars($product['name']); ?></td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($product['description']); ?></td>
                        <td class="py-3 px-6 text-center"><?php echo htmlspecialchars($product['price']); ?></td>
                        <td class="py-3 px-6 text-center">
                            <img src="<?php echo baseUrl() . htmlspecialchars($product['image']); ?>" class="w-16 h-16 rounded" alt="Product Image">
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="<?php echo baseUrl(); ?>product_form.php?id=<?php echo $product['id']; ?>" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Edit</a>
                            <a href="<?php echo baseUrl(); ?>delete_product.php?id=<?php echo $product['id']; ?>" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="py-3 px-6 text-center">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
