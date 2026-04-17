<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$user]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($pass, $admin['password'])) {
        $_SESSION['adminId'] = $admin['adminId'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid credentials.";
    }
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
