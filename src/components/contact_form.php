<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require '../../vendor/autoload.php'; // If using Composer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fade-in {
            animation: fadeIn 1s;
        }
    </style>
    <script src='https://js.hcaptcha.com/1/api.js' async defer></script>
</head>
<body>
    <form id="contact-form" class="mx-auto max-w-xl" id="contactForm" action="../actions/contact.php" method="post">
        <div class="flex flex-col gap-6">
        <div class="mb-10">
        <h2>Contact Us</h2>
        <?php
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        echo 'Test Variable: ' . $_ENV('TEST_VARIABLE');
        ?>
        </div>
        <div class="flex flex-col gap-6">
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
        <div class="h-captcha" data-sitekey="64369d24-19ca-4b0e-8aee-9926ffc4c301"></div>
        <button class="block w-full rounded-md bg-[#FF8C42] px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-[#FF8C42]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit" value="Submit"> Send message </button>
        </div>
        </div>
    </form>

    <!-- Success and Error Message Divs -->
    <div id="successMessage" class="hidden mb-4 p-4 text-green-700 bg-green-100 border border-green-400 rounded fade-in" aria-live="polite"></div>
    <div id="errorMessage" class="hidden mb-4 p-4 text-red-700 bg-red-100 border border-red-400 rounded fade-in" aria-live="assertive"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('contact-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(form);
        fetch('../actions/contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                // Success message
                document.getElementById('successMessage').innerText = data.message;
                document.getElementById('successMessage').classList.remove('hidden');
                document.getElementById('errorMessage').classList.add('hidden');
                form.reset(); // Reset the form
            } else {
                // Error message
                document.getElementById('errorMessage').innerText = data.message;
                document.getElementById('errorMessage').classList.remove('hidden');
                document.getElementById('successMessage').classList.add('hidden');
            }
        })
        .catch(error => {
            document.getElementById('errorMessage').innerText = 'An error occurred: ' + error;
            document.getElementById('errorMessage').classList.remove('hidden');
            document.getElementById('successMessage').classList.add('hidden');
        });
    });
});

    </script>
</body>
</html>

    