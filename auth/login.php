<?php

session_start();
// require '../config/db.php';
require dirname(__DIR__) . '/config/db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt-> execute([$username]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../dashboard.php");
    } else {
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: ../index.php");
    }
}

?>