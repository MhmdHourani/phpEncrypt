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

$reg_usd = '/^[0-9]+\.*[0-9]*[\$,\s\$]/';
$reg_euro = '/^[0-9]+\.*[0-9]*[\€,\s\€]/';
$reg_pound = '/^[0-9]+\.*[0-9]*[\£,\s\£]/';

$error = "";
$usd = "";
$euro = "";
$pound = "";
$Erroramount = true;
$message = "";
if (isset($_POST['save'])) {
    if (!empty($_POST['amount'])) {
        $amount = $_POST['amount'];
        if (preg_match($reg_usd, $amount)) {
            $amount = intval($amount);
            $usd = $amount;
            $euro =  $amount * 0.89;
            $pound = $amount * 0.75;
            $Erroramount = false;
        }
        if (preg_match($reg_euro, $amount)) {
            $amount = intval($amount);
            $euro = $amount;
            $usd = $amount * 1.13;
            $pound = $amount * 0.85;
            $Erroramount = false;
        }
        if (preg_match($reg_pound, $amount)) {
            $amount = intval($amount);
            $pound = $amount;
            $euro =  $amount * 1.18;
            $usd = $amount * 1.33;
            $Erroramount = false;
        }
        if ($Erroramount) {
            $message = "Error Amount Value";
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        .setting {
            width: 100%;
            display: flex;
            justify-content: space-evenly;
            padding: 10px;
        }

        .setting select {
            width: 40%;
            display: inline-block;
            height: 35px;

        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="Dashboard.php">
                    <i class="fas fa-home"></i>
                    <span>
                        <?php if (isset($_SESSION['username'])) {
                            echo  $_SESSION['username'];
                        }
                        ?>
                    </span>
                </a>
            </div>
        </nav>

        <form method="post">
            <div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend mt-5">
                        <span class="input-group-text" id="inputGroup-sizing-default">Amount</span>
                    </div>
                    <input type="text" name="amount" placeholder="Enter The Amount" class=" mt-5 form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <div class="input-group mb-3">

                    <input type="submit" name="save" class="form-control btn-success" value="Convert" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                </div>
                <div class="setting">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">USD</span>
                        </div>
                        <input type="text" value="<?php echo "$" . $usd . $message; ?>" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Euro</span>
                        </div>
                        <input type="text" value="<?php echo "€" . $euro . $message; ?>" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">POUND</span>
                        </div>
                        <input type="text" value="<?php echo "£" . $pound . $message; ?>" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
            </div>
        </form>

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

    </div>
</body>

</html>