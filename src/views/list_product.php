<?php

require_once 'src/config/db.php';
require_once 'src/product/ReadProductCrud.php';
require_once 'src/utils/url_helpers.php';

// Attempt to fetch all products
$products = readProducts();

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
    <!-- Modal -->
    <div
      id="addProductModal"
      role="dialog"
      aria-modal="true"
      class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4"
    >
      <div
        class="modal-content relative bg-white rounded-lg overflow-hidden shadow-xl max-w-2xl mx-auto overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full"
      >
        <button
          class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
          onclick="hideModal()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>

       <div aria-labelledby="modalTitle" class="p-4" id="modalContent">
            <h2 id="modalTitle" class="text-lg font-bold">Add New Product</h2>
            <!-- Dynamic content will be loaded here -->
        </div>
      </div>
    </div>

    <div class="bg-gray-100 py-10">
        <div class="max-w-7xl mx-auto">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Products</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the products in the webshop. Including their attributes.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a href="add_product.php" class="block rounded-md bg-amber-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm">Add product</a>
                    </div>
                </div>
                <div class="mt-8 flow-root ">
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
                                        
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $product["Price"]; ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <img class="h-10 w-10 rounded-full" src="<?= $product["ProductMainImage"]; ?>" alt="Product image">
                                            </td>
                                            <td class="relative whitespace-nowrap pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a href="<?php echo baseUrl(); ?>update_product.php?ProductID=<?php echo $product['ProductID']; ?>" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Edit</a>
                                                <a class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600" href="delete_product.php?ProductID=<?php echo $product['ProductID']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this product?');">
                                                Delete
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
<script>
    // Load modal content from the server
    function loadAndShowModal() {
        fetch('add_product.php')
            .then(response => response.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                showModal();
            })
            .catch(error => console.error('Error loading modal content:', error));
    }

    // Show modal
    function showModal() {
        document.getElementById("addProductModal").style.display = "block";
        document.addEventListener("click", handleClickOutside, true);
    }


    // Hide modal
    function hideModal() {
        document.getElementById("addProductModal").style.display = "none";
        // Optionally, focus back to showModalBtn if exists
        let showModalBtn = document.getElementById("showModalBtn");
        if (showModalBtn) {
            showModalBtn.focus();
        }
        document.removeEventListener("click", handleClickOutside, true);
    }


    // Hide modal if clicked outside of modal-content
    function handleClickOutside(event) {
        let modalContent = document.querySelector(".modal-content");
        if (!modalContent.contains(event.target)) {
            hideModal();
        }
    }

    // Add event listener to the button
    document.addEventListener("DOMContentLoaded", function () {
        let showModalBtn = document.getElementById("showModalBtn");
        if (showModalBtn) {
            showModalBtn.addEventListener("click", loadAndShowModal);
        }
    });

    // Display the selected file name in the input field
   function displayFileName() {
    var input = document.getElementById("ProductMainImage");
    if (input.files && input.files[0]) {
        var fileName = input.files[0].name;
        document.getElementById("file-name").textContent = "Selected file: " + fileName;
    }
}
</script>
</body>
</html>

