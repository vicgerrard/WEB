<?php
session_start();
$feedbackSended = false;
if (isset($_GET['act']) and $_GET['act'] == 'send') {
    if (isset($_POST['name']) and isset($_POST['email']) and isset($_POST['message'])) {
        require 'include/connection.php';
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $query = $conn->query("INSERT INTO feedback VALUES ('','$name','$email','$message')");
        if ($query) {
            $feedbackSended = true;
        }
    }
}
require "include/connection.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="css/bootstrap.min.css">
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="css/style.css">
    <title>Главная страница</title>
</head>
<body>
<?php
$page = 'contact';
include('include/menu.php');
?>


<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <?php if ($feedbackSended) { ?>
            <div class="alert alert-success">
                <strong>Успешно!</strong> Ваше сообщение отправлено, с вами скоро свяжутся.
            </div>
        <?php } ?>
        <form id="messageForm"
              method="POST"
              action="?act=send">
            <div class="row">
                <div id="error" class="col-sm-12" style="color: #ff0000; margin-top: 5px; margin-bottom: 5px;"></div>
                <!-- Имя и email пользователя -->
                <div class="col-sm-6">
                    <!-- Имя пользователя -->
                    <div class="form-group has-feedback">
                        <label for="name" class="control-label">Введите ваше имя:</label>
                        <input type="text" id="name" name="name" class="form-control" required="required" value=""
                               placeholder="Например, Иван Иванович" minlength="2" maxlength="30">
                        <span class="glyphicon form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Email пользователя -->
                    <div class="form-group has-feedback">
                        <label for="email" class="control-label">Введите адрес email:</label>
                        <input type="email" id="email" name="email" class="form-control" required="required" value=""
                               placeholder="Например, ivan@mail.ru" maxlength="30">
                        <span class="glyphicon form-control-feedback"></span>
                    </div>
                </div>
            </div>

            <!-- Сообщение пользователя -->
            <div class="form-group has-feedback">
                <label for="message" class="control-label">Введите сообщение:</label>
                <textarea id="message" class="form-control" rows="3"
                          name="message"
                          placeholder="Введите сообщение от 20 до 500 символов" minlength="20" maxlength="500"
                          required="required"></textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary pull-right">Отправить сообщение</button>
        </form><!-- Конец формы -->

    </div>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>