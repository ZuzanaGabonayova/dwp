<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
</head>
<body>
    <h1>Contact Us</h1>
    <form action="contact.php" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" required></textarea><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
