<?php session_start(); ?>
<?php if(!empty($_SESSION['error'])): ?>
    <div style="color: red;">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<h2>Login</h2>
<form method="POST" action="auth/Login.php">
    <input type="text" name="username" placeholder="Username" reqruired><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<h2>Register</h2>
<form method="POST" action="auth/register.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>
