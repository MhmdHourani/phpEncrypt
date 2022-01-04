<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'you must log in first';
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: login.php');
}

?>
<html>

<head>
    <title>
        Home
    </title>
    <link rel="stylesheet" type="text/css">
</head>

<body>
    <div>
        <?php if (isset($_SESSION['success'])) { ?>
            <div>
                <h3>
                    <?php echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['username'])) { ?>
            <p>
                Welcome
                <?= $_SESSION['username']; ?>
            </p>
            <p>
                <a href="index.php?logout=1">
                    lOGOUT
                </a>
            </p>
        <?php } ?>
    </div>
</body>

</html>