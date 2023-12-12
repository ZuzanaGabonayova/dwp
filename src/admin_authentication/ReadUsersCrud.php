<?php

require_once __DIR__ . '/../config/db.php';

class ReadUsersCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function readUsersCrud() {
        $sql = "SELECT Username FROM Admin";
        return $this->conn->query($sql)->fetch_assoc();
    }
}
?>
