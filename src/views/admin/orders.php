<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/db.php';

// Query to fetch orders with their line items
$query = "SELECT o.*, li.product_name, li.quantity 
          FROM orders o 
          LEFT JOIN order_line_items li ON o.id = li.order_id 
          ORDER BY o.id";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Display each order and its line items
    $current_order_id = 0;
    while ($row = $result->fetch_assoc()) {
        // Check if this is a new order
        if ($row["id"] != $current_order_id) {
            if ($current_order_id != 0) {
                // Not the first order, so close the previous order's list
                echo "</ul>";
            }
            // Display order details
            echo "<h2>Order ID: " . $row["id"] . "</h2>";
            echo "<p>Customer Name: " . $row["customer_name"] . "</p>";
            echo "<p>Customer Email: " . $row["customer_email"] . "</p>";
            // ... display other order fields as needed

            // Start a new list for line items
            echo "<ul>";
            $current_order_id = $row["id"];
        }
        // Display line item
        echo "<li>" . $row["product_name"] . " - Quantity: " . $row["quantity"] . "</li>";
    }
    echo "</ul>"; // Close the last order's list
} else {
    echo "No orders found.";
}

$conn->close();
?>
