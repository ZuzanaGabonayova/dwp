<?php
require 'db.php';
require 'upload.php';

$categories = $conn->query("SELECT CategoryID, CategoryName FROM ProductCategory")->fetch_all(MYSQLI_ASSOC);
$brands = $conn->query("SELECT BrandID, BrandName FROM ProductBrand")->fetch_all(MYSQLI_ASSOC);
$colors = $conn->query("SELECT ColorID, ColorName FROM Color")->fetch_all(MYSQLI_ASSOC);
$sizes = $conn->query("SELECT SizeID, Size FROM Size")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Manually sanitize textual data
    $productNumber = trim($_POST["ProductNumber"]);
    $model = trim($_POST["Model"]);
    $description = trim($_POST["Description"]);

    // Validate and sanitize price as a float
    $price = filter_input(INPUT_POST, "Price", FILTER_VALIDATE_FLOAT);
    if ($price === false || $price > 9999.99) {
        $error = "Invalid price format or exceeds maximum allowed price";
    } else {
        if (!preg_match("/^\d{1,4}(\.\d{1,2})?$/", $_POST['Price'])) {
            $error = "Price must be in decimal(6,2) format";
        }
    }

    // Validate and sanitize stock quantity as an integer
    $stockQuantity = filter_input(INPUT_POST, "StockQuantity", FILTER_VALIDATE_INT);
    if ($stockQuantity === false) {
        $error = "Invalid stock quantity format";
    }

    // Sanitize category and brand IDs
    $categoryID = filter_input(INPUT_POST, "CategoryID", FILTER_SANITIZE_NUMBER_INT);
    $brandID = filter_input(INPUT_POST, "BrandID", FILTER_SANITIZE_NUMBER_INT);

    // Sanitize selected colors and sizes
    $selectedColors = filter_input(INPUT_POST, "colors", FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY) ?? [];
    $selectedSizes = filter_input(INPUT_POST, "sizes", FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY) ?? [];

    // Process file upload
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
        // Insert product data into the database
        $stmt = $conn->prepare("INSERT INTO Product (ProductNumber, Model, Description, Price, StockQuantity, CategoryID, BrandID, ProductMainImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiiis", $productNumber, $model, $description, $price, $stockQuantity, $categoryID, $brandID, $mainImage);
        $stmt->execute();
        $productID = $conn->insert_id;

        // Insert color associations
        $colorStmt = $conn->prepare("INSERT INTO ProductColor (ProductID, ColorID) VALUES (?, ?)");
        foreach ($selectedColors as $colorID) {
            $colorStmt->bind_param("ii", $productID, $colorID);
            $colorStmt->execute();
        }

        // Insert size associations
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

    <div class="bg-white">
    <div class="px-6 py-6 lg:px-8">
        <div class="overflow-y-auto h-[calc(100%-1rem)] max-h-full">
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
                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" type="number" name="Price" step="50" placeholder="Product Price" required>
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
                        <label for="colors" class="block mb-2 text-sm font-medium text-gray-900">Color</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 space-y-4">
                                <?php foreach ($colors as $color): ?>
                                    <div class="items-center flex flex-row">
                                        <input type="checkbox" name="colors[]" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" value="<?= $color["ColorID"]; ?>">
                                        <label class="ml-3 text-sm text-gray-600" for="colors"><?= htmlspecialchars($color["ColorName"]); ?></label>
                                    </div>
                                <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="sm:col-span-full">
                        <label for="sizes" class="block mb-2 text-sm font-medium text-gray-900">Size</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 space-y-4">
                            <div class="grid grid-cols-1 gap-y-8 sm:grid-cols-6">
                                <?php foreach ($sizes as $size): ?>
                                    <input type="checkbox" name="sizes[]" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" value="<?= $size["SizeID"]; ?>">
                                    <label class="ml-3 text-sm text-gray-600" for="sizes"><?= htmlspecialchars($size["Size"]); ?></label>
                                <?php endforeach; ?>
                            </div>
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
                        <!-- (Rest of the form) -->
                    </div>
                            
                    </div>

                </div>
        </form>
        </div>
    </div>
</div>

<script>
// Function to display the file name in the file input field
   function displayFileName() {
    var input = document.getElementById("ProductMainImage");
    if (input.files && input.files[0]) {
        var fileName = input.files[0].name;
        document.getElementById("file-name").textContent = "Selected file: " + fileName;
    }
}

</script>