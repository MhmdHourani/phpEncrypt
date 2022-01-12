<?php
session_start();
$username = "";
$email = "";
$errors = array();
define('HOST', 'localhost');
define('NAME', 'registration');
define('CHARSET', 'utf8');
define('USER', 'root');
define('PASSWORD', '');

try {
    $pdo = new PDO(
        "mysql:host=" . HOST . ";charset=" . CHARSET . ";dbname=" . NAME,
        USER,
        PASSWORD,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (Exception $ex) {
    print($ex->getMessage());
    die();
}

if (isset($_POST['reg_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
    if (empty($username)) {
        array_push($errors, 'Username Is Required');
    }
    if (empty($email)) {
        array_push($errors, 'Email Is Required');
    }
    if (empty($password_1)) {
        array_push($errors, 'password_1 Is Required');
    }
    if ($password_1 != $password_2) {
        array_push($errors, 'Password 2 should match password 1');
    }

    $stmt = $pdo->prepare("SELECT * FROM user WHERE username='$username' OR email='$email' LIMIT 1");
    $stmt->execute();
    $user = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    if (!empty($user) && $user[0]) {
        if ($user[0]['username'] === $username) {
            array_push($errors, "Username Alerady exists");
        }
        if ($user[0]['email'] === $email) {
            array_push($error, 'Email Already Exists');
        }
    }

    if (count($errors) <= 0) {
        $password = md5($password_1);
        $stmt1 = $pdo->prepare("INSERT INTO user (username,email,password) VALUES (?,?,?)");
        $stmt1->execute(array($username, $email, $password));
        $_SESSION['username'] = $username;
        $_SESSION['seccess'] = "You are new logged in";
        header('location: index.php');
    }
}

if (isset($_POST['login_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username)) {
        array_push($errors, "Username Is Requied");
    }
    if (empty($password)) {
        array_push($errors, "Password Is Requied");
    }
    if (count($errors) === 0) {
        $password = md5($password);

        $stmt2 = $pdo->prepare("SELECT * FROM user WHERE username=(?) AND password=(?)");
        $stmt2->execute(array($username, $password));
        $user = $stmt2->fetchAll(\PDO::FETCH_ASSOC);

        if (!empty($user)) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = 'You are now logger in';
            header('location: dashboard.php');
        } else {
            array_push($errors, "Worng username or password.");
        }
    }
}
