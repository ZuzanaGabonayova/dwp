<?php

require_once '../product/UpdateProductCrud.php';

$crud = new UpdateProductCrud($conn);

$categories = $crud->getCategories();
$brands = $crud->getBrands();
$colors = $crud->getColors();
$sizes = $crud->getSizes();

$product = false;
$currentColors = $currentSizes = [];
if (isset($_GET["ProductID"])) {
    $productID = intval($_GET["ProductID"]);
    $product = $crud->readProduct($productID);
    $currentColors = $crud->getCurrentAttributes($productID, 'ProductColor', 'ColorID');
    $currentSizes = $crud->getCurrentAttributes($productID, 'ProductSize', 'SizeID');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ProductID"])) {
    $result = $crud->updateProduct($_POST, $_FILES, $_POST["ProductID"]);
    if (isset($result['error'])) {
        $error = $result['error'];
    } else {
        header("Location: list_product.php?update=success");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="">
    <div class="b-white">
        <div class="px-6 py-6 lg:px-8">
            <div class="max-w-2xl mx-auto ring-1 ring-gray-900/10 p-4 rounded-md shadow-sm">
                 <?php if ($product): ?>
                    <form action="update_product.php" method="post" enctype="multipart/form-data" class="space-y-4"></form>
                    <h2 class="mb-6 text-xl font-semibold text-gray-500 uppercase">Edit product</h2>
                    <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                        <input type="hidden" name="ProductID" value="<?= $product["ProductID"] ?>">
                        <div class="sm:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="ProductNumber">Product Number</label>
                            <div class="mt-2">
                                <input type="text" name="ProductNumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="<?= htmlspecialchars($product["ProductNumber"]); ?>" required>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="Model">Model</label>
                            <div class="mt-2">
                                <input type="text" name="Model" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="<?= htmlspecialchars($product["Model"]); ?>" required>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="Description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea rows="4" name="Description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" required><?= htmlspecialchars($product["Description"]); ?></textarea>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about the product.</p>
                        </div>
                        <div class="w-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="Price">Price</label>
                            <div class="mt-2">
                                <input type="number" name="Price" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="<?= htmlspecialchars($product["Price"]); ?>" required>
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="Price">Stock Quantity</label>
                            <div class="mt-2">
                                <input type="number" name="StockQuantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="<?= htmlspecialchars($product["StockQuantity"]); ?>" required>
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="Price">Stock Quantity</label>
                            <div class="mt-2">
                                <input type="number" name="StockQuantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="<?= htmlspecialchars($product["StockQuantity"]); ?>" required>
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="Price">Category</label>
                            <div class="mt-2">
                                <select name="CategoryID" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category["CategoryID"]; ?>" <?= $category["CategoryID"] == $product["CategoryID"] ? 'selected' : ''; ?>><?= htmlspecialchars($category["CategoryName"]); ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="Price">Category</label>
                            <div class="mt-2">
                                <select name="BrandID" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand["BrandID"]; ?>" <?= $brand["BrandID"] == $product["BrandID"] ? 'selected' : ''; ?>><?= htmlspecialchars($brand["BrandName"]); ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-full">
                            <label for="colors" class="block mb-2 text-sm font-medium text-gray-900">Color</label>
                        </div>
                        <?php foreach ($colors as $color): ?>
                        <label>
                            <input type="checkbox" name="colors[]" value="<?= $color["ColorID"]; ?>" <?= in_array($color["ColorID"], $currentColors) ? 'checked' : ''; ?>><?= htmlspecialchars($color["ColorName"]); ?>
                        </label>
                        <?php endforeach; ?>
                        <?php foreach ($sizes as $size): ?>
                        <label>
                            <input type="checkbox" name="sizes[]" value="<?= $size["SizeID"]; ?>" <?= in_array($size["SizeID"], $currentSizes) ? 'checked' : ''; ?>><?= htmlspecialchars($size["Size"]); ?>
                        </label>
                        <?php endforeach; ?>
                        <input type="file" name="ProductMainImage">
                        <img src="<?= htmlspecialchars($product["ProductMainImage"]); ?>" alt="Current Image" class="h-10 w-10 rounded">
                        <input type="submit" value="Update Product" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    </div>
                    <?php else: ?>
                        <p>Product not found.</p>
                    <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
