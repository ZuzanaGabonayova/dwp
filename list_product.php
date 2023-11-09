<?php
// Database configuration
require 'db.php'; // Include the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get color names for a product
function getProductColors($productId, $conn) {
    $colors = [];
    $sql = "SELECT c.ColorName FROM `ProductColor` pc
            JOIN `Color` c ON pc.ColorID = c.ColorID
            WHERE pc.ProductID = " . intval($productId);
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $colors[] = $row["ColorName"];
    }
    return $colors;
}

// Function to get size names for a product
function getProductSizes($productId, $conn) {
    $sizes = [];
    $sql = "SELECT s.Size FROM `ProductSize` ps
            JOIN `Size` s ON ps.SizeID = s.SizeID
            WHERE ps.ProductID = " . intval($productId);
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $sizes[] = $row["Size"];
    }
    return $sizes;
}

// Function to get the category name for a product
function getCategoryName($categoryId, $conn) {
    $sql = "SELECT CategoryName FROM `ProductCategory` WHERE CategoryID = " . intval($categoryId);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["CategoryName"];
    } else {
        return null;
    }
}

// Function to get the brand name for a product
function getBrandName($brandId, $conn) {
    $sql = "SELECT BrandName FROM `ProductBrand` WHERE BrandID = " . intval($brandId);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["BrandName"];
    } else {
        return null;
    }
}

// Function to get the author name for a product
function getAuthorName($AdminID, $conn) {
    // This assumes you have a table named `Authors` with fields `AuthorID` and `AuthorName`
    // Adjust the table and field names according to your schema
    $sql = "SELECT FirstName, LastName FROM Admin WHERE AdminID = " . intval($AdminID);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["FirstName"] . " " . $row["LastName"];
    } else {
        return null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Include Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-semibold text-gray-800 my-6">Product List</h1>
        <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
            <table class="min-w-max w-full table-fixed">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Product Number</th>
                        <th class="py-3 px-6 text-left">Product</th>
                        <th class="py-3 px-6 text-left">Description</th>
                        <th class="py-3 px-6 text-center">Price</th>
                        <th class="py-3 px-6 text-center">Colors</th>
                        <th class="py-3 px-6 text-center">Sizes</th>
                        <th class="py-3 px-6 text-center">Category</th>
                        <th class="py-3 px-6 text-center">Brand</th>
                        <th class="py-3 px-6 text-center">Stock Quantity</th>
                        <th class="py-3 px-6 text-center">Image</th>
                        <th class="py-3 px-6 text-center">Created At</th>
                        <th class="py-3 px-6 text-center">Edited At</th>
                        <th class="py-3 px-6 text-center">Author</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php
                    // SQL query to select all records from the Product table
                    $sql = "SELECT * FROM `Product`";

                    // Execute the query
                    $result = $conn->query($sql);

                    // Check if there are results
                    if ($result->num_rows > 0):
                        // Output data of each row
                        while($product = $result->fetch_assoc()):
                            $productColors = getProductColors($product["ProductID"], $conn);
                            $productSizes = getProductSizes($product["ProductID"], $conn);
                            $categoryName = getCategoryName($product["CategoryID"], $conn);
                            $brandName = getBrandName($product["BrandID"], $conn);
                            $authorName = getAuthorName($product["AdminID"], $conn); // If you have an authors table
                            ?>
                            <tr class='border-b border-gray-200 odd:bg-white even:bg-gray-100'>
                                <td class='py-3 px-6 text-left whitespace-nowrap'><?= $product["ProductNumber"]; ?></td>
                                <td class='py-3 px-6 text-left'><?= $product["Model"]; ?></td>
                                <td class='py-3 px-6 text-left line-clamp-3 overflow-y-auto'><?= $product["Description"]; ?></td>
                                <td class='py-3 px-6 text-center'><?= $product["Price"]; ?></td>
                                <td class='py-3 px-6 text-center'><?= implode(", ", $productColors); ?></td>
                                <td class='py-3 px-6 text-center'><?= implode(", ", $productSizes); ?></td>
                                <td class='py-3 px-6 text-center'><?= $categoryName; ?></td>
                                <td class='py-3 px-6 text-center'><?= $brandName; ?></td>
                                <td class='py-3 px-6 text-center'><?= $product["StockQuantity"]; ?></td>
                                <td class='py-3 px-6 text-center'>
                                    <img src="<?= $product["ProductMainImage"]; ?>" alt="Product Image" class="h-10 w-10 rounded-full">
                                </td>
                                <td class='py-3 px-6 text-center'><?= $product["CreatedAt"]; ?></td>
                                <td class='py-3 px-6 text-center'><?= $product["EditedAt"]; ?></td>
                                <td class='py-3 px-6 text-center'><?= $authorName; ?></td>
                            </tr>
                            <?php
                        endwhile;
                    else:
                        ?>
                        <tr><td colspan='13' class='py-3 px-6 text-center'>No products found</td></tr>
                        <?php
                    endif;

                    // Close connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
