<?php
session_start();
require 'include/connection.php';
if (isset($_GET['act']) and $_GET['act'] == 'logout') {
    unset($_SESSION['logined']);
}
if (isset($_GET['act']) and $_GET['act'] == 'login') {
    if (isset($_POST['Login']) and isset($_POST['Password'])) {
        $login = $_POST['Login'];
        $password = $_POST['Password'];
        $query = $conn->query("SELECT * FROM users WHERE Login = '$login' AND Password = '$password'");
        if ($query and $query->num_rows == 1) {
            $_SESSION['logined'] = 1;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" media="screen" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/admin.css">
    <title>Главная страница</title>
</head>
<body>
<?php
$page = 'admin';
include('include/menu.php');
?>


<div class="container">
    <?php if (!isset($_SESSION['logined'])) { ?>
        <div class="jumbotron">
            <form class="form-signin" method="POST" action="?act=login">
                <h2 class="form-signin-heading">Введите логин и пароль</h2>
                <label for="login" class="sr-only">Логин</label>
                <input type="text" id="login" name="Login" class="form-control" placeholder="Login" required autofocus>
                <label for="password" class="sr-only">Пароль</label>
                <input type="password" id="password" name="Password" class="form-control" placeholder="Password"
                       required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
            </form>
        </div>
    <?php } ?>
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>