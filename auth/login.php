<?php

session_start();
// require '../config/db.php';
// require dirname(__DIR__) . '/config/db.php';
$dbFile = dirname(__DIR__) . '/config/db.php';

if (file_exists($dbFile)) {
    require $dbFile; // Local: use db.php
} else {
    // Render: connect using environment variables
    $host = getenv('DB_HOST');
    $db   = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');
    $port = getenv('DB_PORT');
    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "<pre>";
    var_dump([
        'host' => $host,
        'port' => $port,
        'db'   => $db,
        'user' => $user,
        'pass' => $pass,
    ]);
    echo "</pre>";
    die("❌ DB connection failed: " . $e->getMessage());
    }
}

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