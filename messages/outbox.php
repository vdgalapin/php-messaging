<?php

session_start();
// require '../config/db.php';
require dirname(__DIR__) . '/config/db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
};

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT messages.*, users.username AS receiver
    FROM messages
    JOIN users ON messages.receiver_id = users.id
    WHERE sender_id = ?
    ORDER BY sent_at DESC");
$stmt->execute([$user_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h3>Outbox</h3>
<ul>
    <?php foreach ($messages as $msg): ?>
        <li>
            <string> To <?= htmlspecialchars($msg['receiver']) ?>:</strong>
            <?= htmlspecialchars($msg['message']) ?>
            <em>(<?= $msg['sent_at'] ?>)</em>
        </li>
    <?php endforeach; ?>
</ul>