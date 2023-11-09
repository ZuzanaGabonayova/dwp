<?php
require 'db.php'; // Include the database configuration
require 'upload.php'; // Include the upload helper

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ProductID"])) {
    // Sanitize and validate the input data here as per your requirements
    $productID = $conn->real_escape_string($_POST["ProductID"]);
    $productNumber = $conn->real_escape_string($_POST["ProductNumber"]);
    $model = $conn->real_escape_string($_POST["Model"]);
    $description = $conn->real_escape_string($_POST["Description"]);
    $price = $conn->real_escape_string($_POST["Price"]);
    $productMainImage = $conn->real_escape_string($_POST["ProductMainImage"]);
    $stockQuantity = $conn->real_escape_string($_POST["StockQuantity"]);
    
    if (isset($_FILES['ProductMainImage']) && $_FILES['ProductMainImage']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadResult = uploadFile($_FILES['ProductMainImage']);
        if (isset($uploadResult['error'])) {
            // Handle error - for example, return a message to the user
            $error = $uploadResult['error'];
        } else {
            $productMainImage = $uploadResult['success'];
        }
    }
    // Assume $conn is your mysqli connection
    $stmt = $conn->prepare("UPDATE Product SET ProductNumber = ?, Model = ?, Description = ?, Price = ?, ProductMainImage = ?, StockQuantity = ? WHERE ProductID = ?");
    $stmt->bind_param("sssdsii", $productNumber, $model, $description, $price, $productMainImage, $stockQuantity, $productID);

    if ($stmt->execute()) {
        // Redirect back to the product list with a success message
        header("Location: list_product.php?update=success");
        exit();
    } else {
        // Handle error here
        $error = $stmt->error;
    }
    $stmt->close();
}

// Function to read a single product
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

// Get the product data
$product = false;
if (isset($_GET["ProductID"])) {
    $product = readProduct($_GET["ProductID"], $conn);
}

function baseUrl() {
    // Normally you would make this dynamic or configured, but for localhost it's simple
    return 'https://zuzanagabonayova.eu/';
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Include Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-semibold text-gray-800 my-6">Edit Product</h1>
        <?php if ($product): ?>
            <?php if(isset($error)): ?>
                <div class="text-red-500">
                    <?= "Error: " . $error; ?>
                </div>
            <?php endif; ?>
            <form action="update_product.php" method="post" class="mb-4">
                <input type="hidden" name="ProductID" value="<?= $product["ProductID"] ?>">

                <label for="Model">Product Number:</label>
                <input type="text" id="ProductNumber" name="ProductNumber" value="<?= htmlspecialchars($product["ProductNumber"]); ?>">
                
                <label for="Model">Model:</label>
                <input type="text" id="Model" name="Model" value="<?= htmlspecialchars($product["Model"]); ?>">
                
                <label for="Description">Description:</label>
                <textarea id="Description" name="Description" required><?= htmlspecialchars($product["Description"]); ?></textarea>
                
                <label for="Price">Price:</label>
                <input type="number" id="Price" name="Price" step="0.01" value="<?= htmlspecialchars($product["Price"]); ?>">
                
                <label for="StockQuantity">Stock Quantity:</label>
                <input type="number" id="StockQuantity" name="StockQuantity" value="<?= htmlspecialchars($product["StockQuantity"]); ?>">
                

                <label class="block mt-3">
                        <span class="text-gray-700">Product Image</span>
                        <input type="file" name="ProductMainImage" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-1">
                        <?php if ($product['ProductMainImage']): ?>
                            <img src="<?php echo baseUrl() . htmlspecialchars($product['ProductMainImage']); ?>" class="w-16 h-16 rounded mt-2" alt="Product Image">
                        <?php endif; ?>
                </label>

                <!-- Add more fields as needed -->
                
                <input type="submit" value="Update Product" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
            </form>
        <?php else: ?>
            <p class="text-red-500">Product not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
