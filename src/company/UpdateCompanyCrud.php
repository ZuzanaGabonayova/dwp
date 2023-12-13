<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

require_once '../config/db.php';
require_once '../utils/uploadCompanyImage.php'; // Include the file upload function

class UpdateCompanyCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateCompanyPresentation($description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID, $title, $image) {
        // Handle file uploads
        if (isset($image) && $image['error'] === UPLOAD_ERR_OK) {
            $imageUploadResult = uploadCompanyImage($image);
            if (isset($imageUploadResult['error'])) {
                // Handle error
                return ['error' => $imageUploadResult['error']];
            }
            $imagePath = $imageUploadResult['success'];
        } else {
            // Handle case where no image is provided or there is an upload error
            $imagePath = null;
        }

        // Prepare the SQL statement
        $stmt = $this->conn->prepare("UPDATE PresentationOfCompany SET DescriptionOfCompany = ?, OpeningHours = ?, Email = ?, Phone = ?, Street = ?, HouseNumber = ?, PostalCodeID = ?, Title = ?, Image = ? ");

        // Bind the parameters
        $stmt->bind_param("ssssssisi", $description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID, $title, $imagePath);

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
