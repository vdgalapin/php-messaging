<?php

session_start();
// require '../config/db.php';
require dirname(__DIR__) . '/config/db.php';

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