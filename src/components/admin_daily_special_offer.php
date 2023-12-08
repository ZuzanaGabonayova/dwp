<?php

ini_set('display_errors', 1);   
ini_set('display_startup_errors', 1);

require_once '../product/ReadProductCrud.php';
?>



<form action="../actions/handle_special_offer.php" method="post">
    <select name="productId">
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
