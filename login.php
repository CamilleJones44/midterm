<?php
require 'database.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['userID'];
        header("Location: reserve.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
   <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
   <h2><a href="index.php" style="text-decoration: none; color: #007bff;">Login</a></h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <p><?php echo $error ?? '';
        ?></p>
</body>

</html>