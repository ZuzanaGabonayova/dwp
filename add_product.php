<?php
require 'db.php';
require 'upload.php';

$categories = $conn->query("SELECT CategoryID, CategoryName FROM ProductCategory")->fetch_all(MYSQLI_ASSOC);
$brands = $conn->query("SELECT BrandID, BrandName FROM ProductBrand")->fetch_all(MYSQLI_ASSOC);
$colors = $conn->query("SELECT ColorID, ColorName FROM Color")->fetch_all(MYSQLI_ASSOC);
$sizes = $conn->query("SELECT SizeID, Size FROM Size")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productNumber = $_POST["ProductNumber"];
    $model = $_POST["Model"];
    $description = $_POST["Description"];
    $price = $_POST["Price"];
    $stockQuantity = $_POST["StockQuantity"];
    $categoryID = $_POST["CategoryID"];
    $brandID = $_POST["BrandID"];
    $selectedColors = $_POST["colors"] ?? [];
    $selectedSizes = $_POST["sizes"] ?? [];
    $mainImage = '';

    if (isset($_FILES["ProductMainImage"]) && $_FILES["ProductMainImage"]["error"] === UPLOAD_ERR_OK) {
        $uploadResult = uploadFile($_FILES["ProductMainImage"]);
        if (isset($uploadResult['success'])) {
            $mainImage = $uploadResult['success'];
        } else {
            $error = $uploadResult['error'];
        }
    }

    if (!isset($error)) {
        $stmt = $conn->prepare("INSERT INTO Product (ProductNumber, Model, Description, Price, StockQuantity, CategoryID, BrandID, ProductMainImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiiis", $productNumber, $model, $description, $price, $stockQuantity, $categoryID, $brandID, $mainImage);
        $stmt->execute();
        $productID = $conn->insert_id;

        $colorStmt = $conn->prepare("INSERT INTO ProductColor (ProductID, ColorID) VALUES (?, ?)");
        foreach ($selectedColors as $colorID) {
            $colorStmt->bind_param("ii", $productID, $colorID);
            $colorStmt->execute();
        }

        $sizeStmt = $conn->prepare("INSERT INTO ProductSize (ProductID, SizeID) VALUES (?, ?)");
        foreach ($selectedSizes as $sizeID) {
            $sizeStmt->bind_param("ii", $productID, $sizeID);
            $sizeStmt->execute();
        }

        header("Location: list_product.php?add=success");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
        <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">Add New Product</h1>
        <form action="add_product.php" method="post" enctype="multipart/form-data" class="">
            <div class="mx-auto max-w-2xl">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label class="block text-sm font-medium leading-6 text-gray-900" for="ProductNumber">Product Number</label>
                        <div class="mt-2">
                            <input class="rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md" type="text" name="ProductNumber" required>
                        </div>
                    </div>
                    <div class="sm:col-span-4">
                        <label class="block text-sm font-medium leading-6 text-gray-900" for="Model">Model</label>
                        <div class="mt-2">
                            <input class="rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md" type="text" name="Model" required>
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="Description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                        <div class="mt-2">
                            <textarea rows="3" name="Description" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required></textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about yourself.</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" for="Price">Price</label>
                        <div class="mt-2">
                            <input class="rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md" type="number" name="Price" step="0.01" required>
                        </div>
                    </div>
                     <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" for="StockQuantity">Stock Quantity</label>
                        <div class="mt-2">
                            <input class="rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md" type="number" name="StockQuantity" required>
                        </div>
                    </div>
                    <select name="CategoryID" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category["CategoryID"]; ?>"><?= htmlspecialchars($category["CategoryName"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="BrandID" required>
                        <option value="">Select Brand</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand["BrandID"]; ?>"><?= htmlspecialchars($brand["BrandName"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="col-span-full">
                        <label for="colors" class="block text-sm font-medium leading-6 text-gray-900">Color</label>
                        <div class="mt-2">
                            <div class="grid grid-cols-1 gap-y-8 sm:grid-cols-6">
                                <?php foreach ($colors as $color): ?>
                                    <input type="checkbox" name="colors[]" value="<?= $color["ColorID"]; ?>"><?= htmlspecialchars($color["ColorName"]); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="sizes" class="block text-sm font-medium leading-6 text-gray-900">Size</label>
                        <div class="mt-2">
                            <div class="grid grid-cols-1 gap-y-8 sm:grid-cols-6">
                                <?php foreach ($sizes as $size): ?>
                                    <input type="checkbox" name="sizes[]" value="<?= $size["SizeID"]; ?>"><?= htmlspecialchars($size["Size"]); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-full"> 
                        <label for="ProductMainImage" class="block text-sm font-medium leading-6 text-gray-900">Product Main Image</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="ProductMainImage" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="ProductMainImage" name="ProductMainImage" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>
                    <input type="file" name="ProductMainImage">
                    <input type="submit" value="Add Product" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                </div>
            </div>
        </form>
    </div>
</div>

    
</body>
</html>
