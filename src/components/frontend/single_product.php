<?php
/* error_reporting(E_ALL);
ini_set('display_errors', 1); */

//session_start(); // Initialize the session for counting the cart items

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../product/ReadProductCrud.php';


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

// Fetch related products
$recommendedProducts = $readProductCrud->readRandomProductsByCategory($categoryName, 4);

?>

<div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:max-w-7xl lg:gap-x-8 lg:px-8 py-16 sm:py-24 bg-white">
    <?php if ($product) : ?>
        <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
            <div class="aspect-w-1 aspect-h-1 rounded-lg ">
                <img src="../<?= htmlspecialchars($product['ProductMainImage']) ?>" alt="Product Image" class="h-full w-full object-cover object-center">
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
                            <?php foreach ($productSizes as $size) : ?>
                                <div class="size-option border-[#F39200] group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase sm:flex-1 sm:py-4 cursor-pointer bg-white text-gray-900 shadow-sm undefined" onclick="setSize('<?= htmlspecialchars($size) ?>')" style="<?= isset($_GET['selected_size']) && $_GET['selected_size'] === $size ? 'background-color: #F39200;' : '' ?>"><?= htmlspecialchars($size) ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <p class="font-bold mt-3">Price: $<?= htmlspecialchars($product['Price']) ?></p>
                <p class="mt-3">Colors: <?= htmlspecialchars(implode(", ", $productColors)) ?></p>

                <p class="mt-1">Category: <?= htmlspecialchars($categoryName) ?></p>
                <p class="mt-1">Brand: <?= htmlspecialchars($brandName) ?></p>
                <div class="mt-6">
                    <form method="get" action="../../views/cart.php">
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
    <?php else : ?>
        <p class="text-center">Product not found.</p>
    <?php endif; ?>
    <!-- Recommended Products Section -->
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Customers also purchased</h2>

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <?php if ($recommendedProducts && $recommendedProducts->num_rows > 0) : ?>
                    <?php while ($row = $recommendedProducts->fetch_assoc()) : ?>
                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                <img src="../<?= htmlspecialchars($row['ProductMainImage']) ?>" alt="Product Image" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="single_product.php?ProductID=<?= htmlspecialchars($row['ProductID']) ?>">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            <?= htmlspecialchars($row['Model']) ?>
                                        </a>
                                    </h3>
                                </div>
                                <p class="text-sm font-medium text-gray-900">$<?= htmlspecialchars($row['Price']) ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<style>
    /* Style for disabled button */
    input[type="submit"][disabled] {
        background-color: lightgray;
        /* Change the background color for disabled state */
        cursor: not-allowed;
        /* Change cursor for disabled state */
    }
</style>

<script>
    function setSize(size, event) {
        document.getElementById('selectedSize').value = size;
        const sizeOptions = document.querySelectorAll('.size-option');
        sizeOptions.forEach(option => {
            option.style.backgroundColor = 'white'; // Reset all sizes to default background color
        });
        event.currentTarget.style.backgroundColor = '#F39200'; // Change background color of selected size

        // Enable or disable the submit button based on whether a size is selected
        const addToCartButton = document.querySelector('input[name="add_to_cart"]');
        addToCartButton.disabled = size === ''; // Disable button if no size is selected
    }

    // Disable the submit button by default
    window.addEventListener('DOMContentLoaded', function() {
        const addToCartButton = document.querySelector('input[name="add_to_cart"]');
        addToCartButton.disabled = true;
    });

    // Add event listener to size options to handle the click event
    const sizeOptions = document.querySelectorAll('.size-option');
    sizeOptions.forEach(option => {
        option.addEventListener('click', function(event) {
            setSize(option.textContent, event); // Pass the selected size and event to setSize function
        });
    });
</script>