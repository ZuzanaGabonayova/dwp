<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL); */

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../admin_authentication/ReadUsersCrud.php';

$readCrud = new ReadUsersCrud($conn);
$userData = $readCrud->readUsersCrud();
?>

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Users</h2>
            <a href="<?php echo baseUrl(); ?>src/views/admin/admin_registration_form.php" class="flex items-center gap-x-1 rounded-md bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 text-sm font-semibold shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                </svg>
                Add new user
            </a>
        </div>
    </div>
    <div class="mt-8 flow-root">
            <div class="mx-4 -my-2 overflow-x-auto sm:mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-300 sm:rounded-lg">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Username</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                            <?php
                            if ($userData):
                                foreach ($userData as $user): ?>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?php echo $user['Username']; ?>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td>No users found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>