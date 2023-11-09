<?php
require 'db.php';
require 'upload.php';

function readProduct($productId, $conn) {
    $stmt = $conn->prepare("SELECT * FROM Product WHERE ProductID = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

function getCurrentAttributes($productId, $conn, $attributeTable, $idField) {
    $stmt = $conn->prepare("SELECT $idField FROM $attributeTable WHERE ProductID = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return array_column($result, $idField);
}

$categories = $conn->query("SELECT CategoryID, CategoryName FROM ProductCategory")->fetch_all(MYSQLI_ASSOC);
$brands = $conn->query("SELECT BrandID, BrandName FROM ProductBrand")->fetch_all(MYSQLI_ASSOC);
$colors = $conn->query("SELECT ColorID, ColorName FROM Color")->fetch_all(MYSQLI_ASSOC);
$sizes = $conn->query("SELECT SizeID, Size FROM Size")->fetch_all(MYSQLI_ASSOC);

$product = false;
$currentColors = $currentSizes = [];
if (isset($_GET["ProductID"])) {
    $productID = intval($_GET["ProductID"]);
    $product = readProduct($productID, $conn);
    $currentColors = getCurrentAttributes($productID, $conn, 'ProductColor', 'ColorID');
    $currentSizes = getCurrentAttributes($productID, $conn, 'ProductSize', 'SizeID');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ProductID"])) {
    $productID = $_POST["ProductID"];
    $productNumber = $_POST["ProductNumber"];
    $model = $_POST["Model"];
    $description = $_POST["Description"];
    $price = $_POST["Price"];
    $stockQuantity = $_POST["StockQuantity"];
    $categoryID = $_POST["CategoryID"];
    $brandID = $_POST["BrandID"];
    $selectedColors = $_POST["colors"] ?? [];
    $selectedSizes = $_POST["sizes"] ?? [];

    if (isset($_FILES["ProductMainImage"]) && $_FILES["ProductMainImage"]["error"] === UPLOAD_ERR_OK) {
        $uploadResult = uploadFile($_FILES["ProductMainImage"]);
        if (isset($uploadResult['success'])) {
            $mainImage = $uploadResult['success'];
            $stmt = $conn->prepare("UPDATE Product SET ProductMainImage = ? WHERE ProductID = ?");
            $stmt->bind_param("si", $mainImage, $productID);
            $stmt->execute();
        }
    }

    $stmt = $conn->prepare("UPDATE Product SET ProductNumber = ?, Model = ?, Description = ?, Price = ?, StockQuantity = ?, CategoryID = ?, BrandID = ? WHERE ProductID = ?");
    $stmt->bind_param("sssdiiii", $productNumber, $model, $description, $price, $stockQuantity, $categoryID, $brandID, $productID);
    $stmt->execute();

    $conn->query("DELETE FROM ProductColor WHERE ProductID = $productID");
    $colorStmt = $conn->prepare("INSERT INTO ProductColor (ProductID, ColorID) VALUES (?, ?)");
    foreach ($selectedColors as $colorID) {
        $colorStmt->bind_param("ii", $productID, $colorID);
        $colorStmt->execute();
    }

    $conn->query("DELETE FROM ProductSize WHERE ProductID = $productID");
    $sizeStmt = $conn->prepare("INSERT INTO ProductSize (ProductID, SizeID) VALUES (?, ?)");
    foreach ($selectedSizes as $sizeID) {
        $sizeStmt->bind_param("ii", $productID, $sizeID);
        $sizeStmt->execute();
    }

    header("Location: list_product.php?update=success");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-semibold text-gray-800 my-6">Edit Product</h1>
        <?php if ($product): ?>
            <form action="update_product.php" method="post" enctype="multipart/form-data" class="mb-4">
                <input type="hidden" name="ProductID" value="<?= $product["ProductID"] ?>">
                <input type="text" name="ProductNumber" value="<?= htmlspecialchars($product["ProductNumber"]); ?>" required>
                <input type="text" name="Model" value="<?= htmlspecialchars($product["Model"]); ?>" required>
                <textarea name="Description" required><?= htmlspecialchars($product["Description"]); ?></textarea>
                <input type="number" name="Price" step="0.01" value="<?= htmlspecialchars($product["Price"]); ?>" required>
                <input type="number" name="StockQuantity" value="<?= htmlspecialchars($product["StockQuantity"]); ?>" required>
                <select name="CategoryID" required>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category["CategoryID"]; ?>" <?= $category["CategoryID"] == $product["CategoryID"] ? 'selected' : ''; ?>><?= htmlspecialchars($category["CategoryName"]); ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="BrandID" required>
                    <?php foreach ($brands as $brand): ?>
                    <option value="<?= $brand["BrandID"]; ?>" <?= $brand["BrandID"] == $product["BrandID"] ? 'selected' : ''; ?>><?= htmlspecialchars($brand["BrandName"]); ?></option>
                    <?php endforeach; ?>
                </select>
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
            </form>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
