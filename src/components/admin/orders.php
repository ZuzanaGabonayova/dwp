<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../orders/ReadOrders.php';
require_once __DIR__ . '/../../utils/url_helpers.php';



$readOrders = new ReadOrders($conn);
$ordersResult = $readOrders->readOrders();
?>


    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900">Orders</h2>
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
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Invoice</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <?php
                                $currentOrderId = null;
                                while ($row = $ordersResult->fetch_assoc()) {
                                if ($row['id'] != $currentOrderId) {
                                    if ($currentOrderId != null) {
                                        // Close the products cell and the previous row
                                        echo "</td>";
                                        ?>
                                        <td class="relative whitespace-nowrap pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a target="_blank" href="<?php echo baseUrl(); ?>src/actions/generate_pdf.php?order_id=<?php echo $currentOrderId; ?>" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Invoice</a>
                                        </td>
                                        </tr>
                                        <?php
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
                                echo "</td>";
                                ?>
                                <td class="relative whitespace-nowrap pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <a target="_blank" href="<?php echo baseUrl(); ?>src/actions/generate_pdf.php?order_id=<?php echo $currentOrderId; ?>" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Invoice</a>
                                </td>
                                </tr>
                                <?php
                            }

                            // ... [Other code]
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
