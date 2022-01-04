<?php include('server.php'); ?>

<html>

<head>
    <title>
        login page
    </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class='header'>
        <h2>login</h2>
        <form method="POST" action="login.php">
            <?php include('errors.php') ?>
            <div class="input-group">
                <label>UserName</label>
                <input type='text' name='username'>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type='password' name='password'>
            </div>
            <div class="input-group">
                <button type='submit' name='login_user'>Login</button>
            </div>
            <p>
                Not Yet Member?
                <a href="register.php">
                    Sign Up
                </a>
            </p>
        </form>
    </div>
</body>

</html>