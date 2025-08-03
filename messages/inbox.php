<?php

session_start();
require '../config/db.php';

if( $isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT messages.*, users.username AS sender_username FROM messages JOIN users ON messages.sender_id = users.id WHERE receiver_id = ? ORDER BY sent_at DESC");
$stmt->execute([$user_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h3>Inbox</h3>
<ul>
    <?php foreach ($messages as $msg): ?>
        <li>
            <strong><?= htmlspecialchars($msg['sender']) ?>:</strong>
            <?= htmlspecialchars($msg['message']) ?> 
                <em>(<?= msg['sent_at'] ?>)</em>
        </li>
    <?php endforeach; ?>
</ul>


