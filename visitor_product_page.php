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

    <div class="container mx-auto p-6">
        <!-- <div class="flex justify-between items-center pb-6">
        <div>
            <a class="text-xl text-blue" href="view_cart.php">Cart</a>
            <h2 class="text-4xl font-semibold">Products</h2>
        </div>
    </div> -->

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
                                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75">
                                    <img class="h-full w-full object-cover object-center lg:h-full lg:w-full" src="<?php echo htmlspecialchars($product['ProductMainImage']); ?>" alt="<?php echo htmlspecialchars($product['Model']); ?>" />
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <h3 class="text-sm text-gray-700">
                                            <a href="<?php echo baseUrl(); ?>single_product.php?ProductID=<?php echo $product['ProductID']; ?>" class="text-[#FF8C42] font-bold border-b-2 border-solid border-[#FF8C42] hover:border-[#000000] uppercase">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                <?php echo htmlspecialchars($product['Model']); ?>
                                            </a>
                                        </h3>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars(number_format($product['Price'], 2)); ?> kr</p>
                                    
                                </div>
                            </div> <!-- More products... -->


                        <?php endwhile; ?>

                        <?php else : ?>
                            <p>No products found.</p>
                        <?php endif; ?>

                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($products) : ?>
                <?php while ($product = $products->fetch_assoc()) : ?>
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
                    <!-- <div class="border-2 border-solid rounded-3xl shadow-lg">
                        <div class="flex justify-center border-b-2 border-solid shadow-lg">
                            <img class="object-cover h-72" src="<?php echo htmlspecialchars($product['ProductMainImage']); ?>" alt="<?php echo htmlspecialchars($product['Model']); ?>" />
                        </div>
                        <div class="flex mx-10 align-center w-full">
                            <div class="my-7">
                                <div class="font-bold text-xl mb-2"><?php echo htmlspecialchars($product['Model']); ?></div>

                                <div class="mt-5 flex flex-col">
                                    <div class="my-2">
                                        <p class="py-2"><?php echo htmlspecialchars(number_format($product['Price'], 2)); ?> kr</p>
                                        <a href="#" class="text-[#FF8C42] font-bold border-b-2 border-solid border-[#FF8C42] hover:border-[#000000]">DETAILS</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- </div> -->


                <?php endwhile; ?>
            <?php else : ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>