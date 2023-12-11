<?php
require_once '../config/db.php';
require_once '../product/ReadProductCrud.php';
require_once '../utils/url_helpers.php';

//session_start(); // Initialize the session for counting the cart items

$readProductCrud = new ReadProductCrud($conn);
$products = $readProductCrud->readProducts();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900">Products</h2>
                <a href="../views/add_product.php" class="flex items-center gap-x-1 rounded-md bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 text-sm font-semibold shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                    Add product
                </a>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="mx-4 -my-2 overflow-x-auto sm:mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-300 sm:rounded-lg">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Number</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Image</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <?php
                                if ($products && $products->num_rows > 0):
                                    while($product = $products->fetch_assoc()):
                                        $productColors = $readProductCrud->getProductColors($product["ProductID"]);
                                        $productSizes = $readProductCrud->getProductSizes($product["ProductID"]);
                                        $categoryName = $readProductCrud->getCategoryName($product["CategoryID"]);
                                        $brandName = $readProductCrud->getBrandName($product["BrandID"]);
                                        $authorName = $readProductCrud->getAuthorName($product["AdminID"]);
                                ?>
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><?= $product["ProductNumber"]; ?></td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $product["Model"]; ?></td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $product["Price"]; ?></td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <img class="h-10 w-10 rounded-full" src="../<?= $product["ProductMainImage"]; ?>" alt="Product image">
                                    </td>
                                    <td class="relative whitespace-nowrap pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="update_product.php?ProductID=<?php echo $product['ProductID']; ?>" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Edit</a>
                                       <a class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600" href="../actions/handle_delete_product.php?ProductID=<?php echo $product['ProductID']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                                            Delete
                                       </a>

                                    </td>
                                </tr>
                                <?php
                                    endwhile;
                                else:
                                ?>
                                <tr><td colspan='5' class='py-3 px-6 text-center'>No products found</td></tr>
                                <?php
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
