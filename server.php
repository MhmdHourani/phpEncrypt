<?php
session_start();
$username = "";
$email = "";
$errors = array();

$database = mysqli_connect('localhost', 'root', '', 'registration');

if (isset($_POST['reg_user'])) {
    $username = mysqli_real_escape_string($database, $_POST['username']);
    $email = mysqli_real_escape_string($database, $_POST['email']);
    $password_1 = mysqli_real_escape_string($database, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($database, $_POST['password_2']);
    if (empty($username)) {
        array_push($errors, 'Username Is Required');
    }
    if (empty($email)) {
        array_push($errors, 'Email Is Required');
    }
    if (empty($password_1)) {
        array_push($errors, 'password_1 Is Required');
    }
    if (empty($password_1 != $password_2)) {
        array_push($errors, 'Password 2 should match password 1');
    }
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($database, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        if ($user['username'] === $username) {
            $array_push($errors, "Username Alerady exists");
        }
        if ($user['email'] === $email) {
            $array_push($error, 'Email Already Exists');
        }
    }
    var_dump(count($errors));
    if (count($errors)) {
        $password = md5($password_1);
        $query = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')";
        mysqli_query($database, $query);
        $_SESSION['username'] = $username;
        $_SESSION['seccess'] = "You are new logged in";
        header('location: index.php');
    }
}
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($database, $_POST['username']);
    $password = mysqli_real_escape_string($database, $_POST['password']);
    if (empty($username)) {
        array_push($errors, "Username Is Requied");
    }
    if (empty($password)) {
        array_push($errors, "Password Is Requied");
    }
    if (count($errors) === 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        var_dump($query);
        $result  = mysqli_query($database, $query);
        if (mysqli_num_rows($result) === 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = 'You are now logger in';
            header('location: index.php');
        } else {
            array_push($errors, "Worng username or password.");
        }
    }
}
