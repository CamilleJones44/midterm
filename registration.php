<?php
require 'database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $email = trim($_POST['email']);
    // Validation    
    if (empty($username) || empty($password) || empty($email)) {
        $error = "All fields are required!";
    } else {
        // Insert user into the database       
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $password, $email])) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error registering user!";
        }
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2><a href="index.php" style="text-decoration: none; color: #007bff;">Register</a></h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="submit" value="Register">
    </form>
    <p><?php echo $error ?? '';
        ?></p>
</body>

</html>