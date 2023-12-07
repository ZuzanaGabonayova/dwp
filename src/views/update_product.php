<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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

$error = isset($_GET["error"]) ? $_GET["error"] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body>
    <div class="bg-white">
        <div class="px-6 py-6 lg:px-8">
            <div class="max-w-2xl mx-auto ring-1 ring-gray-900/10 p-4 rounded-md shadow-sm">
                <?php if ($product): ?>
                    <form action="../actions/handle_update_product.php" method="post" enctype="multipart/form-data" class="space-y-4">
                        <h2 class="mb-6 text-xl font-semibold text-gray-500 uppercase">Edit product</h2>
                        <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                            <input type="hidden" name="ProductID" value="<?= $product["ProductID"] ?>">

                            <!-- Product Number -->
                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="ProductNumber">Product Number</label>
                                <input type="text" name="ProductNumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="<?= htmlspecialchars($product["ProductNumber"]); ?>" required>
                            </div>

                            <!-- Model -->
                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="Model">Model</label>
                                <input type="text" name="Model" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="<?= htmlspecialchars($product["Model"]); ?>" required>
                            </div>

                            <!-- Description -->
                            <div class="sm:col-span-2">
                                <label for="Description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                                <textarea rows="4" name="Description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" required><?= htmlspecialchars($product["Description"]); ?></textarea>
                            </div>

                            <!-- Price -->
                            <div class="w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="Price">Price</label>
                                <input type="number" name="Price" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="<?= htmlspecialchars($product["Price"]); ?>" required>
                            </div>

                            <!-- Stock Quantity -->
                            <div class="w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="StockQuantity">Stock Quantity</label>
                                <input type="number" name="StockQuantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="<?= htmlspecialchars($product["StockQuantity"]); ?>" required>
                            </div>

                            <!-- Category -->
                            <div class="w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="CategoryID">Category</label>
                                <select name="CategoryID" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category["CategoryID"]; ?>" <?= $category["CategoryID"] == $product["CategoryID"] ? 'selected' : ''; ?>><?= htmlspecialchars($category["CategoryName"]); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Brand -->
                            <div class="w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="BrandID">Brand</label>
                                <select name="BrandID" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                    <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand["BrandID"]; ?>" <?= $brand["BrandID"] == $product["BrandID"] ? 'selected' : ''; ?>><?= htmlspecialchars($brand["BrandName"]); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Colors -->
                            <div class="sm:col-span-full">
                                <label for="colors" class="block mb-2 text-sm font-medium text-gray-900">Color</label>
                                <?php foreach ($colors as $color): ?>
                                <label>
                                    <input type="checkbox" name="colors[]" value="<?= $color["ColorID"]; ?>" <?= in_array($color["ColorID"], $currentColors) ? 'checked' : ''; ?>><?= htmlspecialchars($color["ColorName"]); ?>
                                </label>
                                <?php endforeach; ?>
                            </div>

                            <!-- Sizes -->
                            <?php foreach ($sizes as $size): ?>
                            <label>
                                <input type="checkbox" name="sizes[]" value="<?= $size["SizeID"]; ?>" <?= in_array($size["SizeID"], $currentSizes) ? 'checked' : ''; ?>><?= htmlspecialchars($size["Size"]); ?>
                            </label>
                            <?php endforeach; ?>

                            <!-- Image -->
                            <input type="file" name="ProductMainImage">
                            <img src="<?= htmlspecialchars($product["ProductMainImage"]); ?>" alt="Current Image" class="h-10 w-10 rounded">

                            <!-- Submit Button -->
                            <input type="submit" value="Update Product" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        </div>
                    </form>
                <?php else: ?>
                    <p>Product not found.</p>
                <?php endif; ?>
                <?php if ($error): ?>
                    <p class="error"><?= htmlspecialchars($error); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
