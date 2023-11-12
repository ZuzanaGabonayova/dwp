<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <form class="mx-auto max-w-xl" id="contactForm" action="contact.php" method="post">
        <!-- [Form fields] -->
        <div class="mb-10">
        <h2>Contact Us</h2>
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
        <button class="block w-full rounded-md bg-[#FF8C42] px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-[#FF8C42]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit" value="Submit"> Send message </button>
    </div>
    </form>
    <div id="formResponse"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('contactForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submit action

                var formData = new FormData(form);
                fetch('contact.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    var responseElement = document.getElementById('formResponse');
                    responseElement.innerText = data.message;
                    if (data.status) {
                        responseElement.style.color = 'green';
                        form.reset();
                    } else {
                        responseElement.style.color = 'red';
                    }
                })
                .catch(error => {
                    document.getElementById('formResponse').innerText = 'An error occurred: ' + error;
                });
            });
        });
    </script>
</body>
</html>
