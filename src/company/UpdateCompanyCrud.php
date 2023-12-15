<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL); */

require_once '../config/db.php';

class UpdateCompanyCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateCompanyPresentation($description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID, $title) {
        

        // Prepare the SQL statement
        $stmt = $this->conn->prepare("UPDATE PresentationOfCompany SET DescriptionOfCompany = ?, OpeningHours = ?, Email = ?, Phone = ?, Street = ?, HouseNumber = ?, PostalCodeID = ?, Title = ? ");

        // Bind the parameters
        $stmt->bind_param("ssssssis", $description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID, $title);

        // Execute the statement
        $result = $stmt->execute();
        if ($result) {
            return ['success' => 'Company presentation updated successfully.'];
        } else {
            return ['error' => 'Failed to update company presentation.'];
        }
    }
}
?>
