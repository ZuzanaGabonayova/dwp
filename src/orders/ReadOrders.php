<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once __DIR__ . '../../config/db.php';

class ReadOrders {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function readOrders() {
        $sql = "SELECT o.*, li.product_name, li.quantity 
                FROM orders o 
                LEFT JOIN order_line_items li ON o.id = li.order_id 
                ORDER BY o.id";
        return $this->conn->query($sql);
    }
}