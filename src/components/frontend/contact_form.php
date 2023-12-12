<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
    <form id="contact-form" class="px-6 pb-24 pt-20 sm:pb-32 lg:px-8 lg:py-48" id="contactForm" action="../../actions/contact.php" method="post">
        <div class="mx-auto max-w-xl lg:mr-0 lg:max-w-lg">
            <div class="grid grid-cols-1 gap-y-6">
                <div>
                    <label class="block text-sm font-semibold leading-6 text-gray-900" for="name">Name:</label><br>
                    <input class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" id="name" name="name" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold leading-6 text-gray-900" for="email">Email:</label><br>
                    <input class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="email" id="email" name="email" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold leading-6 text-gray-900" for="message">Message:</label>
                    <textarea class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" id="message" name="message" required></textarea>
                </div>
            </div>
            <div class="mt-8 flex flex-col gap-12">
                <div class="h-captcha" data-sitekey="64369d24-19ca-4b0e-8aee-9926ffc4c301"></div>
                <button class="block w-full rounded-md bg-[#FF8C42] px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-[#FF8C42]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit" value="Submit"> Send message </button>
            </div>
        </div>
    </form>

    <!-- Success and Error Message Divs -->
    <div id="successMessage" class="hidden mb-4 p-4 text-green-700 bg-green-100 border border-green-400 rounded fade-in" aria-live="polite"></div>
    <div id="errorMessage" class="hidden mb-4 p-4 text-red-700 bg-red-100 border border-red-400 rounded fade-in" aria-live="assertive"></div>

    <script src="../../../assets/js/contact_form.js"></script>

    