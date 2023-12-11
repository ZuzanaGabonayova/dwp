<?php

ini_set('display_errors', 1);   
ini_set('display_startup_errors', 1);

require_once '../product/ReadProductCrud.php';
?>



<form action="../actions/handle_special_offer.php" method="post">
    <label class="block mb-2 text-sm font-medium text-gray-900" for="CategoryID">Set daily special offer</label>
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
</form>
