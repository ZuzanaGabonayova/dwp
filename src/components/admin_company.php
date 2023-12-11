<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

require_once '../config/db.php';
require_once '../company/ReadCompanyCrud.php';

$readCrud = new ReadCompanyCrud($conn);
$companyData = $readCrud->readCompanyPresentation();
?>


<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Company Presentation</h2>
            <a href="../views/edit_company_presentation.php" class="flex items-center gap-x-1 rounded-md bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 text-sm font-semibold shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                </svg>
                Update information
            </a>
        </div>
    </div>
        <?php
        if ($companyData): ?>
            <div class="overflow-hidden rounded-xl border border-gray-300 mt-6">
                <div class="flex items-center gap-x-4 border-b bg-gray-100 p-6">
                    <img src="https://tailwindui.com/img/logos/48x48/tuple.svg" alt="Tuple" class="h-12 w-12 flex-none rounded-lg bg-white ring-2 ring-gray-300 ring-offset-2">
                    <div class="text-sm font-medium leading-6 text-gray-900">
                        Sneaker Shop
                    </div>
                    <div class="relative ml-auto">
                        <a href=""></a>
                    </div>
                </div>
                <dl class="-my-3 px-6 py-4 text-sm leading-6 divide-y-reverse">
                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">Description</dt>
                        <dd class="text-gray-900"><?php echo htmlspecialchars($companyData['DescriptionOfCompany']); ?></dd>
                    </div>
                     <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">Opening Hours</dt>
                        <dd class="text-gray-900"><?php echo htmlspecialchars($companyData['OpeningHours']); ?></dd>
                    </div>
                     <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">Email</dt>
                        <dd class="text-gray-900"><?php echo htmlspecialchars($companyData['Email']); ?></dd>
                    </div>
                     <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">Phone</dt>
                        <dd class="text-gray-900"><?php echo htmlspecialchars($companyData['Phone']); ?></dd>
                    </div>
                     <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">Street</dt>
                        <dd class="text-gray-900"><?php echo htmlspecialchars($companyData['Street']); ?></dd>
                    </div>
                     <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">House Number</dt>
                        <dd class="text-gray-900"><?php echo htmlspecialchars($companyData['HouseNumber']); ?></dd>
                    </div>
                     <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">Postal Code</dt>
                        <dd class="text-gray-900"><?php echo htmlspecialchars($companyData['PostalCodeID']); ?></dd>
                    </div>
                </dl>
            </div>
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