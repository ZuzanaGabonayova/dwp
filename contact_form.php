
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<form class="mx-auto max-w-xl" action="contact.php" method="post" onsubmit="submitForm(event)">
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
</body>
</html>