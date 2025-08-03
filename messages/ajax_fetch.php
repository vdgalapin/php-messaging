<?php

session_start();
require '../config/db.php';

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
$messages = $stmt->fetchALL(PDO:FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($messages);

?>