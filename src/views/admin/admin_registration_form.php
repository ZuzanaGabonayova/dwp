<?php 
require_once '../../admin_authentication/loggedin.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
</head>
<body>
    <h2>Admin Registration</h2>
    <form method="post" action="../../admin_authentication/register_admin.php">
        <input type="text" name="firstname" placeholder="First Name" required><br><br>
        <input type="text" name="lastname" placeholder="Last Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
