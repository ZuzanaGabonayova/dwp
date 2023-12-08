<?php
require_once '../config/db.php';
require_once '../product/ReadProductCrud.php';
require_once '../utils/url_helpers.php';

session_start(); // Initialize the session for counting the cart items

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
<body class="bg-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Products</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the products in the webshop. Including their attributes.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="add_product.php" class="block rounded-md bg-amber-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm">Add product</a>
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
                                        <img class="h-10 w-10 rounded-full" src="<?= $product["ProductMainImage"]; ?>" alt="Product image">
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
