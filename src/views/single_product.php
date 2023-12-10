<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Initialize the session for counting the cart items

require_once '../config/db.php';
require_once '../product/ReadProductCrud.php';

// Include all your provided functions here

if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $readProductCrud = new ReadProductCrud($conn); // Create an instance of ReadProductCrud
    $product = $readProductCrud->readProduct($productID); // Call the method using the instance
    $productColors = $readProductCrud->getProductColors($productID); // Use the class method
    $productSizes = $readProductCrud->getProductSizes($productID);
    $categoryName = $readProductCrud->getCategoryName($product['CategoryID']);
    $brandName = $readProductCrud->getBrandName($product['BrandID']);
    $authorName = $readProductCrud->getAuthorName($product['AdminID']); // Adjust as per your table structure
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['add_to_cart'])) {
        $selectedSize = $_GET['selected_size'] ?? null;
        if ($selectedSize === null || empty($selectedSize)) {
            echo '<p>Please select a size before adding to cart.</p>';
        } else{
            header('Location: cart.php?action=add&id=' . $productID . '&hidden_name=' . urlencode($product['Model']) . '&hidden_price=' . urlencode($product['Price']) . '&selected_size=' . urlencode($_GET['selected_size']));
            exit();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="">
    <?php
    include '../components/navigationbar.php';
    ?>
    <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:max-w-7xl lg:gap-x-8 lg:px-8 py-16 sm:py-24 bg-white">
        <?php if ($product): ?>
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <div class="aspect-square rounded-lg ">
                    <img src="<?= htmlspecialchars($product['ProductMainImage']) ?>" alt="Product Image" class="h-full w-full object-cover object-center">
                </div>
                <div class="px-8 mt-20 lg:mt-0 sm:px:0 sm:mt-16 ">
                    <h1 class="text-3xl font-bold mb-2 tracking-tight"><?= htmlspecialchars($product['Model']) ?></h1>
                    <p><?= nl2br(htmlspecialchars($product['Description'])) ?></p>
                    <div class="mt-10">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">Size</h3>
                            <a href="#" class="text-sm font-medium text-[#F39200] hover:text-[#F39200]/80">Size guide</a>
                        </div>
                        <div class="mt-4">
                            <div class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4">
                                <?php foreach ($productSizes as $size): ?>
                                    <div class="size-option border-[#F39200] group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase sm:flex-1 sm:py-4 cursor-pointer bg-white text-gray-900 shadow-sm undefined" onclick="setSize('<?= htmlspecialchars($size) ?>', event)" style="<?= isset($_GET['selected_size']) && $_GET['selected_size'] === $size ? 'background-color: #F39200;' : '' ?>"><?= htmlspecialchars($size) ?></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <p class="font-bold mt-3">Price: $<?= htmlspecialchars($product['Price']) ?></p>
                    <p class="mt-3">Colors: <?= htmlspecialchars(implode(", ", $productColors)) ?></p>
                        
                    <p class="mt-1">Category: <?= htmlspecialchars($categoryName) ?></p>
                    <p class="mt-1">Brand: <?= htmlspecialchars($brandName) ?></p>
                    <div class="mt-6">
                    <form method="get" action="cart.php">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="<?= $productID ?>">
                        <input type="hidden" name="hidden_name" value="<?= htmlspecialchars($product['Model']) ?>">
                        <input type="hidden" name="hidden_price" value="<?= htmlspecialchars($product['Price']) ?>">
                        <input type="hidden" id="selectedSize" name="selected_size" value="<?= isset($_GET['selected_size']) ? htmlspecialchars($_GET['selected_size']) : '' ?>">
                        <input type="submit" name="add_to_cart" class="bg-primary hover:bg-primary/80 text-white font-bold py-2 px-4 rounded cursor-pointer" value="Add to Cart">
                    </form>
                </div>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center">Product not found.</p>
        <?php endif; ?>
    </div>

    <script>
        function setSize(size, event) {
            document.getElementById('selectedSize').value = size;
            const sizeOptions = document.querySelectorAll('.size-option');
            sizeOptions.forEach(option => {
                option.style.backgroundColor = 'white'; // Reset all sizes to default background color
            });
            event.currentTarget.style.backgroundColor = '#F39200'; // Change background color of selected size

            // Store selected size in session
            const selectedSize = encodeURIComponent(size);
            <?php
            // Start PHP block within JavaScript
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Store selected size in session variable
            echo 'sessionStorage.setItem("selected_size", "' . $_GET['selected_size'] . '");';
            ?>
        }
    </script>

</body>
</html>
