<?php
// Database configuration
require 'db.php'; // Include the database
require 'crud_operations.php'; // Include CRUD operations

// Attempt to fetch all products
$products = readProducts();

// Function to get the base URL of the script
function baseUrl()
{
    // Normally you would make this dynamic or configured, but for localhost it's simple
    return 'https://zuzanagabonayova.eu/';
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

<body class="bg-white">

    <?php
    include 'inc/hero.php';
    ?>

    
        <!-- Products Grid -->
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                    Our top categoriess
                </h2>
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                <?php if ($products) : ?>
                <?php while ($product = $products->fetch_assoc()) : ?>
                    <div class="group relative bg-white p-4 shadow-lg rounded-md">
                        <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75"
                        >
                            <img
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full"
                            src="<?php echo htmlspecialchars($product['ProductMainImage']); ?>"
                            alt="<?php echo htmlspecialchars($product['Model']); ?>" 
                            />
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-[#FF8C42] font-bold">
                                <a href="<?php echo baseUrl(); ?>single_product.php?ProductID=<?php echo $product['ProductID']; ?>">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                    <?php echo htmlspecialchars($product['Model']); ?>
                                </a>
                                </h3>
                            </div>
                            <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars(number_format($product['Price'], 2)); ?> kr.</p>
                        </div>
                    </div>
                <?php endwhile; ?>

                <?php else : ?>
                    <p>No products found.</p>
                <?php endif; ?>

                </div>
            </div>
        </div>
    

</body>

</html>