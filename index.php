<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/style.css">
    <title>Главная страница</title>
</head>
<body>
<?php
$page = 'index';
include('include/menu.php');
?>
<div class="container">
    <div class="jumbotron">
        <h2>Мой сайт</h2>
        <p>Этот сайт является <strong>необходимым условием</strong> получения зачета. В нем используются технологи
            JQuery и Bootstrap.</p>
        <p>С помощью меню в верхней части страницы можно перейти к текущим новостям, связаться с нами, посмотреть карту
            и отредактировать что-то в панели администратора.</p>
    </div>
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>