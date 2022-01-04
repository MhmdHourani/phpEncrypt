<?php
include 'server.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        registeration php system
    </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h2>Register</h2>
    </div>
    <form method='post' action="register.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Username</label>
            <input required name='username' value="<?= $username; ?>">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input required type='email' name="email" value="<?= $email ?>">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input required type="password" name="password_1">
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input required type="password" name="password_2">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="reg_user">
                Register
            </button>
        </div>
        <p>
            Alerady Member?
            <a href="login.php">
                Sign IN
            </a>
        </p>
    </form>

</body>

</html>