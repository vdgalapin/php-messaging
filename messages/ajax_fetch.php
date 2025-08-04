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

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT messages.*, users.username AS sender
    FROM messages
    JOIN users ON messages.sender_id = users.id
    WHERE receiver_id = ?
    ORDER BY sent_at DESC
    LIMIT 10");
$stmt->execute([$user_id]);
$messages = $stmt->fetchALL(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($messages);

?>