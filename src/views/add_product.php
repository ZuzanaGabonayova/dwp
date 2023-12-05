<?php

require_once '../product/AddProductCrud.php';

$crud = new AddProductCrud($conn);

$categories = $crud->getCategories();
$brands = $crud->getBrands();
$colors = $crud->getColors();
$sizes = $crud->getSizes();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $crud->processProductForm($_POST, $_FILES);
    if (isset($result['error'])) {
        $error = $result['error'];
    } else {
        $crud->closeConnection();
        header("Location: list_product.php?add=success");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="output.css">
</head>
<body>
    
</body>
</html>

    <div class="bg-white">
    <div class="px-6 py-6 lg:px-8">
        <div class="max-w-2xl mx-auto ring-1 ring-gray-900/10 p-4 rounded-md shadow-sm">
            <!-- Error Message Display -->
            <?php if (isset($error)): ?>
                <div class="mb-4 p-4 text-red-700 bg-red-100 border border-red-400 rounded">
                    <strong>Error:</strong> <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form class="space-y-4" action="add_product.php" method="post" enctype="multipart/form-data" class="">
                <h2 class="mb-6 text-xl font-semibold text-gray-500 uppercase">New product</h2>
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="ProductNumber">Product Number</label>
                        <div class="mt-2">
                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" type="text" name="ProductNumber" placeholder="Product Number" required>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="Model">Model</label>
                        <div class="mt-2">
                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" type="text" name="Model" placeholder="Model" required>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="Description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                        <div class="mt-2">
                            <textarea rows="4" name="Description" placeholder="Write a product description here..." class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" required></textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about the product.</p>
                    </div>
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="Price">Price</label>
                        <div class="mt-2">
                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" type="number" name="Price" placeholder="Product Price" required>
                        </div>
                    </div>
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="StockQuantity">Stock Quantity</label>
                        <div class="mt-2">
                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" type="number" name="StockQuantity" required>
                        </div>
                    </div>
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="StockQuantity">Category</label>
                        <select name="CategoryID" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?= $category["CategoryID"]; ?>"><?= htmlspecialchars($category["CategoryName"]); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="StockQuantity">Brand</label>
                        <select name="BrandID" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Select Brand</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand["BrandID"]; ?>"><?= htmlspecialchars($brand["BrandName"]); ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="sm:col-span-full">
                        <label for="sizes" class="block mb-2 text-sm font-medium text-gray-900">Size</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 space-y-4">
                                <?php foreach ($sizes as $size): ?>
                                    <div class="items-center flex flex-row">
                                        <input type="checkbox" name="sizes[]" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" value="<?= $size["SizeID"]; ?>">
                                        <label class="ml-3 text-sm text-gray-600" for="sizes"><?= htmlspecialchars($size["Size"]); ?></label>
                                    </div>
                                <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="col-span-full">
                        <label for="ProductMainImage" class="block mb-2 text-sm font-medium text-gray-900">Product Main Image</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <!-- (SVG and other elements remain the same) -->

                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="ProductMainImage" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="ProductMainImage" name="ProductMainImage" type="file" class="sr-only" onchange="displayFileName()">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                <span id="file-name"></span> <!-- Element to display the file name -->
                            </div>
                        </div>
                    </div>
                    <div class="col-span-full">
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Product</button>
                        </div>
                    </div>
                   
                    
                    </div>

                </div>
                
        </form>
        </div>
    </div>
</div>