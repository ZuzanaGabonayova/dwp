<?php
require 'db.php'; // Include the database connection
require 'upload.php'; // Include the CRUD operations

/**
 * Read all products
 */
function readProducts() {
    global $conn;
    
    $sql = "SELECT * FROM Product";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}


// Attempt to fetch all products
$products = readProducts();



// Function to get the base URL of the script
function baseUrl() {
    // Normally you would make this dynamic or configured, but for localhost it's simple
    return 'https://zuzanagabonayova.eu/';
}

function updateProduct($conn, $productId, $productData, $colors, $sizes) {
    // Start transaction
    $conn->begin_transaction();

    try {
        // Update product base information
        $stmt = $conn->prepare("UPDATE `Product` SET 
                                `ProductNumber` = ?, 
                                `Model` = ?, 
                                `Description` = ?, 
                                `Price` = ?, 
                                `ProductMainImage` = ?, 
                                `CategoryID` = ?, 
                                `BrandID` = ?, 
                                `StockQuantity` = ?, 
                                `AdminID` = ? 
                                WHERE `ProductID` = ?");
        $stmt->bind_param("sssdisiiii",
            $productData['ProductNumber'],
            $productData['Model'],
            $productData['Description'],
            $productData['Price'],
            $productData['ProductMainImage'],
            $productData['CategoryID'],
            $productData['BrandID'],
            $productData['StockQuantity'],
            $productData['AdminID'],
            $productId
        );
        $stmt->execute();
        $stmt->close();

        // Update product colors
        $stmt = $conn->prepare("DELETE FROM `ProductColor` WHERE `ProductID` = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO `ProductColor` (`ProductID`, `ColorID`) VALUES (?, ?)");
        foreach ($colors as $colorId) {
            $stmt->bind_param("ii", $productId, $colorId);
            $stmt->execute();
        }
        $stmt->close();

        // Update product sizes
        $stmt = $conn->prepare("DELETE FROM `ProductSize` WHERE `ProductID` = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO `ProductSize` (`ProductID`, `SizeID`) VALUES (?, ?)");
        foreach ($sizes as $sizeId) {
            $stmt->bind_param("ii", $productId, $sizeId);
            $stmt->execute();
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();
        echo "Product updated successfully with colors and sizes.";
    } catch (Exception $e) {
        // An error occurred, rollback changes
        $conn->rollback();
        echo "Error updating product: " . $e->getMessage();
    }
}

$productID = $_GET['ProductID'] ?? null;

if (!$productID) {
    die('ProductID must be provided.');
}

$product = readProducts ($conn, $productID);

if (!$product) {
    die('Product not found.');
}


// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and assign POST data to variables
    // ...

    // Assuming $_POST['colors'] and $_POST['sizes'] are arrays of selected color and size IDs
    $colors = $_POST['colors'] ?? [];
    $sizes = $_POST['sizes'] ?? [];

    // Handle file upload if a file was sent
    // ...

    // Update the product
    $result = updateProduct($conn, $productID, $_POST, $colors, $sizes);

    // Based on $result, redirect or display a success/error message
    if ($result) {
        // Redirect to product list or display success message
        header('Location: product_list.php');
        exit;
    } else {
        // Handle error
        $error = 'There was an error updating the product.';
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <!-- Include Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-semibold text-gray-800 my-6">Update Product</h1>

        <?php if (isset($error)): ?>
            <p class="text-red-500 text-xs italic"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="update_product.php?ProductID=<?php echo htmlspecialchars($productID); ?>" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <!-- Hidden field for the ProductID -->
            <input type="hidden" name="ProductID" value="<?php echo htmlspecialchars($product['ProductID']); ?>">

            <div class="mb-4">
                <label for="productNumber" class="block text-gray-700 text-sm font-bold mb-2">Product Number:</label>
                <input type="text" id="productNumber" name="productNumber" value="<?php echo htmlspecialchars($product['ProductNumber']); ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- ... other product fields ... -->

            <!-- Submit button -->
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</body>
</html>