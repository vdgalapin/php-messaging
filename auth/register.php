<?php
session_start();
// require '../config/db.php';
require dirname(__DIR__) . '/config/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
        $stmt->execute([$username, $password]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        header("Location: ../dashboard.php");
        
    } catch (PDOExecption $e) {
        die("Registration failed: " . $e->getMessage());
    }
}
?>