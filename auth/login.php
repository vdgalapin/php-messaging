<?php

session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['passsword'] ?? '';

    $stmt = $pdo->query("SELECT * FROM users WHERE username = ?");
    $stmt-> execute([$username]);

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../welcome.php");
    } else {
        echo "Invalid login credentials.";
    }
}

?>