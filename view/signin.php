<?php
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/menu.php';
?>

<h3>Login</h3>
<form method="post" action="teka.php?rt=user/login">
    <p>
        <label for="username">Korisnicko ime:</label>
        <input type="text" name="username" id="username" required>
    </p>
    <p>
        <label for="password">Zaporka:</label>
        <input type="password" name="password" id="password" required>
    </p>
    <p>
        <button type="submit" name="login">Login!</button>
    </p>
</form>

<h3>Nemas racun? Registriraj se.</h3>
<form method="post" action="teka.php?rt=user/register">
    <p>
        <label for="newusername">KOrisnicko ime: (3-20 znakova)</label>
        <input type="text" name="newusername" id="newusername" pattern="[A-Za-z]{3,20}" title="3-20 letters" required>
    </p>
    <p>
        <label for="newpassword">Zaporka:</label>
        <input type="password" name="newpassword" id="newpassword" required>
    </p>
    <p>
        <label for="newemail">Email:</label>
        <input type="email" name="newemail" id="newemail" required>
    </p>
    <p>
        <button type="submit" name="register">Registriraj se!</button>
    </p>
</form>

<?php require_once __DIR__ . '/_footer.php'; ?>
