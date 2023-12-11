<?php

require_once __DIR__ . '/../config/db.php';

class ReadCompanyCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function readCompanyPresentation() {
        $sql = "SELECT * FROM PresentationOfCompany";
        return $this->conn->query($sql)->fetch_assoc();
    }
}
?>
