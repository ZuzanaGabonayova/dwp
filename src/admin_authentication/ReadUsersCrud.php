<?php

require_once __DIR__ . '/../config/db.php';

class ReadUsersCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function readUsersCrud() {
        $sql = "SELECT Username FROM Admin";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
