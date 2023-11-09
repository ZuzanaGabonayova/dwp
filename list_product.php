<?php
require 'db.php'; // Include the database



/* // Database configuration
$host = 'localhost'; // or your host name/IP
$user = 'your_username'; // your database username
$password = 'your_password'; // your database password
$dbname = 'your_database_name'; // your database name
 */

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

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $colors[] = $row["ColorName"];
        }
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

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row["Size"];
        }
    }
    return $sizes;
}

// SQL query to select all records from the Product table
$sql = "SELECT * FROM `Product`";

// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while($product = $result->fetch_assoc()) {
        $productColors = getProductColors($product["ProductID"], $conn);
        $productSizes = getProductSizes($product["ProductID"], $conn);

        echo "ProductID: " . $product["ProductID"] .
             " - Product Number: " . $product["ProductNumber"] .
             " - Model: " . $product["Model"] .
             " - Description: " . $product["Description"] .
             " - Price: " . $product["Price"] .
             " - Main Image: " . $product["ProductMainImage"] .
             " - CategoryID: " . $product["CategoryID"] .
             " - BrandID: " . $product["BrandID"] .
             " - Created At: " . $product["CreatedAt"] .
             " - Edited At: " . $product["EditedAt"] .
             " - Author: " . $product["Author"] .
             " - Stock Quantity: " . $product["StockQuantity"] .
             " - Colors: " . implode(", ", $productColors) .
             " - Sizes: " . implode(", ", $productSizes) . "<br>";
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>



