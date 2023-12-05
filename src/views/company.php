<?php

require_once '../config/db.php';
require_once '../company/ReadCompanyCrud.php';

$readCrud = new ReadCompanyCrud($conn);
$companyData = $readCrud->readCompanyPresentation();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Presentation</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="bg-gray-100 p-8">

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
    </div>

</body>
</html>
