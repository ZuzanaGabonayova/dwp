<?php
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
                                `Author` = ? 
                                WHERE `ProductID` = ?");
        $stmt->bind_param("sssdiiiiii",
            $productData['ProductNumber'],
            $productData['Model'],
            $productData['Description'],
            $productData['Price'],
            $productData['ProductMainImage'],
            $productData['CategoryID'],
            $productData['BrandID'],
            $productData['StockQuantity'],
            $productData['Author'],
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
        <form action="update_product.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label for="productNumber" class="block text-gray-700 text-sm font-bold mb-2">Product Number:</label>
                <input type="text" id="productNumber" name="productNumber" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <!-- ... other product fields ... -->

            <div class="mb-4">
                <label for="colors" class="block text-gray-700 text-sm font-bold mb-2">Colors:</label>
                <select id="colors" name="colors[]" multiple class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <!-- Options should be generated based on available colors in the database -->
                    <option value="1">Red</option>
                    <option value="2">White</option>
                    <option value="3">Black</option>
                    <option value="4">Yellow</option>
                    <option value="5">Pink</option>
                    <!-- ... other color options ... -->
                </select>
            </div>

            <div class="mb-4">
                <label for="sizes" class="block text-gray-700 text-sm font-bold mb-2">Sizes:</label>
                <select id="sizes" name="sizes[]" multiple class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <!-- Options should be generated based on available sizes in the database -->
                    <option value="1">35</option>
                    <option value="2">36</option>
                    <option value="3">37</option>
                    <option value="4">38</option>
                    <option value="5">39</option>
                    <option value="6">40</option>
                    <option value="7">41</option>
                    <option value="8">42</option>
                    <option value="9">43</option>
                    <!-- ... other size options ... -->
                </select>
            </div>

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
