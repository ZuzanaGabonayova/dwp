<?php

require 'crud_operations.php'; // Make sure this points to the correct path where your crud_operations.php file is
require 'upload.php'; // Make sure this points to the correct path where your upload.php file is

$product = ['id' => '', 'name' => '', 'description' => '', 'price' => '', 'image' => ''];

// Check if we're editing an existing product
if (isset($_GET['id'])) {
    // Retrieve the product details from the database
    $product['id'] = $_GET['id'];
    // ... Load product details into $product array
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imagePath = ''; // Default to no image

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadResult = uploadFile($_FILES['image']);
        if (isset($uploadResult['error'])) {
            // Handle error - for example, return a message to the user
            $error = $uploadResult['error'];
        } else {
            $imagePath = $uploadResult['success'];
        }
    }

    // Check if we're updating an existing product or creating a new one
    if (!empty($_POST['id'])) {
        // Update the product
        $id = $_POST['id'];
        $result = updateProduct($id, $name, $description, $price, $imagePath);
    } else {
        // Create a new product
        $result = createProduct($name, $description, $price, $imagePath);
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
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

                    <label class="block">
                        <span class="text-gray-700">Name</span>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" class="mt-1 block w-full" required>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Description</span>
                        <textarea name="description" class="mt-1 block w-full" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Price</span>
                        <input type="number" name="price" min="0.00" max="10000.00" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" class="mt-1 block w-full" required>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Product Image</span>
                        <input type="file" name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none  p-1">
                    </label>

                    <div class="mt-6 flex justify-between">
                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded hover:bg-indigo-400">Save Product</button>
                        <a href="<?php echo baseUrl(); ?>product_list.php" class="px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded hover:bg-gray-600">Back to Product List</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
