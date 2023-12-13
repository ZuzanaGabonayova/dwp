<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../product/ReadProductCrud.php';
require_once __DIR__ . '/../../utils/url_helpers.php';



$readProductCrud = new ReadProductCrud($conn);
$products = $readProductCrud->readProducts();


?>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900">Products</h2>
                <a href="<?php echo baseUrl(); ?>src/views/admin/add_product.php" class="flex items-center gap-x-1 rounded-md bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 text-sm font-semibold shadow-sm">
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
                            <!-- Table Headers -->
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Order ID</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Customer Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Customer Email</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Products</th>
                                    <!-- Add more headers if necessary -->
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <?php
                                $currentOrderId = null;
                                while ($row = $ordersResult->fetch_assoc()) {
                                    if ($row['id'] != $currentOrderId) {
                                        if ($currentOrderId != null) {
                                            // Close the products cell and the previous row
                                            echo "</td></tr>";
                                        }
                                        // Start a new row
                                        ?>
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><?= $row['id']; ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= htmlspecialchars($row['customer_name']); ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= htmlspecialchars($row['customer_email']); ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?php
                                        $currentOrderId = $row['id'];
                                    }
                                    // Display products in the same cell
                                    echo htmlspecialchars($row['product_name']) . " - Quantity: " . htmlspecialchars($row['quantity']) . "<br>";
                                }
                                if ($currentOrderId != null) {
                                    // Close the last row
                                    echo "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
