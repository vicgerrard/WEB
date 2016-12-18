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
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="css/blog.css">
    <title>Новости</title>
</head>
<body>
<?php
$page = 'blog';
include('include/menu.php');
require 'include/connection.php';
?>


<div class="container">
    <?php
    $query = $conn->query('SELECT * FROM blog ORDER BY 1 DESC');
    if ($query) {
        if ($query->num_rows == 0) {
            ?>
            <div class="jumbotron">
                <h2>Записей пока нет!</h2>
            </div>
            <?php
        }
        while ($row = $query->fetch_row()) {
            ?>
            <div class="jumbotron">
                <div class="container">
                    <h2><?php echo $row[1]; ?></h2>
                    <p class="blog-post-meta"><?php echo $row[2]; ?></p>
                    <?php echo $row[3]; ?>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>