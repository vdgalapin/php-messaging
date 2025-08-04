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
    $port = getenv('DB_PORT') ?: '6543';

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("DB connection failed: " . $e->getMessage());
    }
}

if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_SESSION['user_id'];
    $receiver_username = $_POST['receiver'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$receiver_username]);
    $receiver = $stmt->fetch();

    if (!$receiver) {
        $_SESSION['error'] = "User not found.";
        header("Location: ../dashboard.php");
    } else {
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        if ($stmt->execute([$sender_id, $receiver['id'], $message])) {
            $_SESSION['database_message'] = "Sent to " . $receiver_username;
        } else  {
            $_SESSION['error'] = "Failed to sent.";
        }
        
        header("Location: ../dashboard.php");
    }

}

?>