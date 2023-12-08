<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

require_once '../config/db.php';
require_once '../company/ReadCompanyCrud.php';

$readCrud = new ReadCompanyCrud($conn);
$companyData = $readCrud->readCompanyPresentation();
?>


<div class="container mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Company Presentation</h2>

        <?php
        if ($companyData): ?>
            <p class="text-gray-700"><strong>Description:</strong> <?php echo htmlspecialchars($companyData['DescriptionOfCompany']); ?></p>
            <p class="text-gray-700"><strong>Opening Hours:</strong> <?php echo htmlspecialchars($companyData['OpeningHours']); ?></p>
            <p class="text-gray-700"><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($companyData['Email']); ?>" class="text-blue-600"><?php echo htmlspecialchars($companyData['Email']); ?></a></p>
            <p class="text-gray-700"><strong>Phone:</strong> <a href="tel:<?php echo htmlspecialchars($companyData['Phone']); ?>" class="text-blue-600"><?php echo htmlspecialchars($companyData['Phone']); ?></a></p>
            <p class="text-gray-700"><strong>Address:</strong> <?php echo htmlspecialchars($companyData['Street'] . ' ' . $companyData['HouseNumber'] . ', ' . $companyData['PostalCodeID']); ?></p>
        <?php else: ?>
            <p class="text-gray-700">No company presentation data available.</p>
        <?php endif; ?>
        <a href="../views/edit_company_presentation.php" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Edit
        </a>
    </div>