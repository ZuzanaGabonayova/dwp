<?php

require 'crud_operations.php'; // Make sure this points to the correct path where your crud_operations.php file is
require 'upload.php'; // Make sure this points to the correct path where your upload.php file is

// Initialize variables for all fields
$product = [
    'ProductID' => '', 
    'ProductNumber' => '', 
    'Model' => '', 
    'Color' => '', 
    'Size' => '', 
    'Description' => '', 
    'Price' => '', 
    'StockQuantity' => '', 
    'ProductMainImage' => '', 
    'CategoryID' => '', 
    'BrandID' => '', 
    'CreatedAt' => '', 
    'EditedAt' => '', 
    'AdminID' => ''
];

// Check if we're editing an existing product
if (isset($_GET['ProductID'])) {
    // Retrieve the product details from the database
    $productDetails = readProduct($_GET['ProductID']);
    if ($productDetails) {
        $product = array_merge($product, $productDetails);
    }
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assign POST data to variables, assuming you have form fields for all of them
    $productNumber = $_POST['ProductNumber'];
    $model = $_POST['Model'];
    $color = $_POST['Color'];
    $size = $_POST['Size'];
    $description = $_POST['Description'];
    $price = $_POST['Price'];
    $stockQuantity = $_POST['StockQuantity'];
    // ... other fields
    $categoryID = $_POST['CategoryID'];
    $brandID = $_POST['BrandID'];
    $adminID = $_POST['AdminID']; // This should probably come from session or auth context

    $imagePath = $product['ProductMainImage']; // Default to the current image

    // Handle file upload
    if (isset($_FILES['ProductMainImage']) && $_FILES['ProductMainImage']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadResult = uploadFile($_FILES['ProductMainImage']);
        if (isset($uploadResult['error'])) {
            // Handle error - for example, return a message to the user
            $error = $uploadResult['error'];
        } else {
            $imagePath = $uploadResult['success'];
        }
    }

    // Check if we're updating an existing product or creating a new one
    if (!empty($_POST['ProductID'])) {
        // Update the product
        $productID = $_POST['ProductID'];
        $result = updateProduct($productID, $productNumber, $model, $color, $size, $description, $price, $stockQuantity, $imagePath, $categoryID, $brandID);
    } else {
        // Create a new product
        $result = createProduct($productNumber, $model, $color, $size, $description, $price, $stockQuantity, $imagePath, $categoryID, $brandID);
    }

    // Based on $result, redirect or display a success/error message
    if ($result) {
        // Redirect to product list or display success message
        header('Location: product_list.php');
        exit;
    } else {
        // Handle error
        $error = 'There was an error saving the product.';
    }
}

function baseUrl() {
    // Normally you would make this dynamic or configured, but for localhost it's simple
    return 'https://zuzanagabonayova.eu/';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
        <div class="md:flex">
            <div class="p-8">
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Product Form</div>
                
                <form action="product_form.php" method="post" enctype="multipart/form-data" class="mt-4">
                    <input type="hidden" name="ProductID" value="<?php echo htmlspecialchars($product['ProductID']); ?>">

                    <!-- Here you will have other input fields for the product attributes -->

                    <label class="block mt-3">
                        <span class="text-gray-700">Product Number</span>
                        <input type="text" name="ProductNumber" value="<?php echo htmlspecialchars($product['ProductNumber']); ?>" class="mt-1 block w-full" required>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Model</span>
                        <input type="text" name="Model" value="<?php echo htmlspecialchars($product['Model']); ?>" class="mt-1 block w-full" required>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Color</span>
                        <input type="text" name="Color" value="<?php echo htmlspecialchars($product['Color']); ?>" class="mt-1 block w-full">
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Size</span>
                        <input type="text" name="Size" value="<?php echo htmlspecialchars($product['Size']); ?>" class="mt-1 block w-full">
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Description</span>
                        <textarea name="Description" class="mt-1 block w-full" rows="3" required><?php echo htmlspecialchars($product['Description']); ?></textarea>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Price</span>
                        <input type="number" name="Price" min="0.00" max="10000.00" step="0.01" value="<?php echo htmlspecialchars($product['Price']); ?>" class="mt-1 block w-full" required>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Stock Quantity</span>
                        <input type="number" name="StockQuantity" value="<?php echo htmlspecialchars($product['StockQuantity']); ?>" class="mt-1 block w-full">
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Category ID</span>
                        <input type="number" name="CategoryID" value="<?php echo htmlspecialchars($product['CategoryID']); ?>" class="mt-1 block w-full">
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Brand ID</span>
                        <input type="number" name="BrandID" value="<?php echo htmlspecialchars($product['BrandID']); ?>" class="mt-1 block w-full">
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Author</span>
                        <input type="text" name="AdminID" value="<?php echo htmlspecialchars($product['AdminID']); ?>" class="mt-1 block w-full">
                    </label>

                    <!-- Image upload field -->
                    <label class="block mt-3">
                        <span class="text-gray-700">Product Image</span>
                        <input type="file" name="ProductMainImage" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-1">
                        <?php if ($product['ProductMainImage']): ?>
                            <img src="<?php echo baseUrl() . htmlspecialchars($product['ProductMainImage']); ?>" class="w-16 h-16 rounded mt-2" alt="Product Image">
                        <?php endif; ?>
                    </label>

                    <div class="mt-6 flex justify-between">
                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded hover:bg-indigo-400">Save Product</button>
                        <a href="<?php echo baseUrl(); ?>product_list.php" class="px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded hover:bg-gray-600">Back to Product List</a>
                    </div>
                </form>
                <?php if (isset($error)): ?>
                    <p class="text-red-500 text-xs italic mt-4">
                        <?php echo $error; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>


