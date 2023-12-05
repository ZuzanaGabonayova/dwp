<?php

require_once '../config/db.php';

class UpdateCompanyCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateCompanyPresentation($description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID) {
        $stmt = $this->conn->prepare("UPDATE PresentationOfCompany SET DescriptionOfCompany = ?, OpeningHours = ?, Email = ?, Phone = ?, Street = ?, HouseNumber = ?, PostalCodeID = ?");
        $stmt->bind_param("ssssssi", $description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID);
        return $stmt->execute();
    }
}
?>
