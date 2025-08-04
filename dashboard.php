<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<?php if(!empty($_SESSION['error'])): ?>
    <div style="color: red;">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if(!empty($_SESSION['database_message'])): ?>
    <div style="color: green;">
        <?= $_SESSION['database_message']; ?>
    </div>
    <?php unset($_SESSION['database_message']); ?>
<?php endif; ?>


<h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>

<a href="auth/logout.php">Logout</a>

<h3>Send Message</h3>
<form action="messages/send.php" method="POST">
    <input type="text" name="receiver" placeholder="Recipient username" required><br>
    <textarea name="message" placeholder="Your message..." required></textarea><br>
    <button type="submit">Send</button>
</form>

<hr>
<div id="inbox">
    <h3>Inbox (auto-refresh)</h3>
    <ul id="inbox-messages"></ul>
</div>

<script>
function loadInbox() {
    fetch("messages/ajax_fetch.php")
        .then(res => res.json())
        .then(data => {
            const ul = document.getElementById("inbox-messages");
            ul.innerHTML = "";
            data.forEach(msg => {
                const li = document.createElement("li");
                li.innerHTML = `<strong>${msg.sender}:</strong> ${msg.message} <em>(${msg.sent_at})</em>`;
                ul.appendChild(li);
            });
        });
}
setInterval(loadInbox, 3000);
loadInbox();
</script>

<hr>
<a href="messages/inbox.php">📥 Full Inbox</a> |
<a href="messages/outbox.php">📤 Outbox</a>
