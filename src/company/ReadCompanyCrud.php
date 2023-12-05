<?php

require_once '../config/db.php';


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
