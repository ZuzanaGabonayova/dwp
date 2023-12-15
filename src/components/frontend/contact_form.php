<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once __DIR__ . '../../../utils/url_helpers.php'; 
?>
    <form id="contact-form" class="px-6 pb-24 pt-20 sm:pb-32 lg:px-8 lg:py-48" action="<?php echo baseUrl() ?>src/actions/contact.php" method="post">
        <input type="hidden" id="recaptchaResponse" name="recaptcha_response">
        <div class="mx-auto max-w-xl lg:mr-0 lg:max-w-lg">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 mb-6">
                Contact us
            </h2>
            <div class="grid grid-cols-1 gap-y-6">
                <div>
                    <label class="block text-sm font-semibold leading-6 text-gray-900" for="name">Name:</label>
                    <input class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" id="name" name="name" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold leading-6 text-gray-900" for="email">Email:</label>
                    <input class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="email" id="email" name="email" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold leading-6 text-gray-900" for="message">Message:</label>
                    <textarea class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" id="message" name="message" required></textarea>
                </div>
            </div>
            <div class="mt-8 flex flex-col gap-12">
                <button class="block w-full rounded-md bg-[#FF8C42] px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-[#FF8C42]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit" value="Submit"> Send message </button>
            </div>
        </div>
    </form>
    