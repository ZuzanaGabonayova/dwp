<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once '../product/CreateProductCrud.php';

$crud = new CreateProductCrud($conn);

$categories = $crud->getCategories();
$brands = $crud->getBrands();
$colors = $crud->getColors();
$sizes = $crud->getSizes();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body>
    <div class="bg-white">
        <div class="px-6 py-6 lg:px-8">
            <div class="max-w-2xl mx-auto ring-1 ring-gray-900/10 p-4 rounded-md shadow-sm">
                <form class="space-y-4" action="../actions/handle_create_product.php" method="post" enctype="multipart/form-data">
                    <h2 class="mb-6 text-xl font-semibold text-gray-500 uppercase">New product</h2>
                    <!-- Product Number -->
                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="ProductNumber">Product Number</label>
                        <input type="text" name="ProductNumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                    </div>
                    <!-- Model -->
                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="Model">Model</label>
                        <input type="text" name="Model" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                    </div>
                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label for="Description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                        <textarea rows="4" name="Description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" required></textarea>
                    </div>
                    <!-- Price -->
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="Price">Price</label>
                        <input type="number" name="Price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                    </div>
                    <!-- Stock Quantity -->
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="StockQuantity">Stock Quantity</label>
                        <input type="number" name="StockQuantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                    </div>
                    <!-- Category -->
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="CategoryID">Category</label>
                        <select name="CategoryID" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?= $category["CategoryID"]; ?>"><?= htmlspecialchars($category["CategoryName"]); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Brand -->
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="BrandID">Brand</label>
                        <select name="BrandID" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                            <option value="">Select Brand</option>
                            <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand["BrandID"]; ?>"><?= htmlspecialchars($brand["BrandName"]); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Colors -->
                    <div class="sm:col-span-full">
                        <label for="colors" class="block mb-2 text-sm font-medium text-gray-900">Color</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 space-y-4">
                            <?php foreach ($colors as $color): ?>
                                <div class="items-center flex flex-row">
                                    <input type="checkbox" name="colors[]" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" value="<?= $color["ColorID"]; ?>">
                                    <label class="ml-3 text-sm text-gray-600"><?= htmlspecialchars($color["ColorName"]); ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Sizes -->
                    <div class="sm:col-span-full">
                        <label for="sizes" class="block mb-2 text-sm font-medium text-gray-900">Size</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 space-y-4">
                            <?php foreach ($sizes as $size): ?>
                                <div class="items-center flex flex-row">
                                    <input type="checkbox" name="sizes[]" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" value="<?= $size["SizeID"]; ?>">
                                    <label class="ml-3 text-sm text-gray-600"><?= htmlspecialchars($size["Size"]); ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Product Main Image -->
                    <div class="col-span-full">
                        <label for="ProductMainImage" class="block mb-2 text-sm font-medium text-gray-900">Product Main Image</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="ProductMainImage" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="ProductMainImage" name="ProductMainImage" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF, WEBP up to 10MB</p>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="col-span-full">
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Product</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
