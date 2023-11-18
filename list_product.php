<?php
// Database configuration
require 'db.php'; // Include the database
require 'crud_operations.php'; // Include CRUD operations

// Attempt to fetch all products
$products = readProducts();

// Function to get the base URL of the script
function baseUrl() {
    // Normally you would make this dynamic or configured, but for localhost it's simple
    return 'https://zuzanagabonayova.eu/';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="output.css">
</head>
<body class="">
    <div class="bg-gray-100 py-10">
        <div class="max-w-7xl mx-auto">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Products</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the products in the webshop. Including their attributes.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <button type="button" class="block rounded-md bg-amber-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm">Add product</button>
                    </div>
                </div>
                <div class="mt-8 flow-root ">
                    <div class="mx-4 -my-2 overflow-x-auto sm:mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-offset-white/[0.05] sm:rounded-lg">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Number</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Image</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-300">
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
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><?= $product["ProductNumber"]; ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $product["Model"]; ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate"><?= $product["Description"]; ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $product["Price"]; ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <img class="h-10 w-10 rounded-full" src="<?= $product["ProductMainImage"]; ?>" alt="Product image">
                                            </td>
                                            <td class="relative whitespace-nowrap pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a href="" class="text-amber-500 ">Edit
                                                </a>
                                            </td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
