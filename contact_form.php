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
