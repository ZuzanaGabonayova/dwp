<?php

ini_set('display_errors', 1);   
ini_set('display_startup_errors', 1);

require_once '../product/ReadProductCrud.php';
?>


<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Daily special offer</h2>
        </div>
    </div>
    <form action="../actions/handle_special_offer.php" method="post" class="max-w-none sm:max-w-sm">
        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" name="productId">
            <?php
            $readProductCrud = new ReadProductCrud($conn);
            $products = $readProductCrud->readProducts();
            if ($products) {
                while ($product = $products->fetch_assoc()) {
                    echo "<option value=\"{$product['ProductID']}\">{$product['Model']}</option>";
                }
            }
            ?>
        </select>
        <input type="submit" value="Set as Daily Special Offer">
        <button type="submit" class="flex items-center gap-x-1 rounded-md bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 text-sm font-semibold shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            Set as daily special
        </button>
    </form>
</div>