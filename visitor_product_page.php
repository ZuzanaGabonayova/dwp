<?php
// Database configuration
require 'db.php'; // Include the database

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
<?php
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <div class="flex justify-between items-center pb-6">
        <div>
            <a class="text-xl text-blue" href="view_cart.php">Cart</a>
            <h2 class="text-4xl font-semibold">Products</h2>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid md:grid-cols-3 gap-6">
        <?php if ($products): ?>
            <?php while ($product = $products->fetch_assoc()): ?>
                <!-- <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white">
                    <img class="w-full" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2"><?php echo htmlspecialchars($product['name']); ?></div>
                        <p class="text-gray-700 text-base">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>
                    </div>
                    <div class="px-6 pt-4 pb-2">
                        <span class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></span>
                        
                        <form action="add_to_cart.php" method="post" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div> -->



                <!-- <div class="w-full grid grid-cols-3 gap-20"> -->
                    <div class="border-2 border-solid rounded-3xl shadow-lg">
                        <div class="flex justify-center border-b-2 border-solid shadow-lg">
                            <img class="object-cover h-72 w-[450px]" src="<?php echo htmlspecialchars($product['ProductMainImage']); ?>" alt="<?php echo htmlspecialchars($product['Model']); ?>"/>
                        </div>
                        <div class="flex justify-center align-center w-full">
                            <div class="my-4 w-10/12">
                                <div class="font-bold text-xl mb-2"><?php echo htmlspecialchars($product['Model']); ?></div>

                                <div class="mt-10 flex flex-col items-center">
                                    <div class="my-2">
                                        <p class="py-2"><?php echo htmlspecialchars(number_format($product['Price'], 2)); ?> kr</p>
                                        <a href="#" class="text-[#FF8C42] font-bold border-b-2 border-solid border-[#FF8C42] hover:border-[#000000]">DETAILS</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->


            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
