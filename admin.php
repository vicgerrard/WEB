<?php
session_start();
$postAdded = false;
$postRemoved = false;
$postEdited = false;
require 'include/connection.php';
if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case 'logout':
            unset($_SESSION['logined']);
            break;
        case 'login':
            if (isset($_POST['Login']) and isset($_POST['Password'])) {
                $login = $_POST['Login'];
                $password = $_POST['Password'];
                $query = $conn->query("SELECT * FROM users WHERE Login = '$login' AND Password = '$password'");
                if ($query and $query->num_rows == 1) {
                    $_SESSION['logined'] = 1;
                }
            }
            break;
        case 'addpost':
            if (isset($_POST['title']) and isset($_POST['text'])) {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $query = $conn->query("INSERT INTO blog VALUES ('','$title',now(),'$text')");
                if ($query) {
                    $postAdded = true;
                }
            }
            break;
        case 'removepost':
            if (isset($_POST['postId'])) {
                $postId = $_POST['postId'];
                $query = $conn->query("DELETE FROM blog WHERE id = $postId");
                if ($query) {
                    $postRemoved = true;
                }
            }
            break;
        case 'editpost':
            if (isset($_POST['postId']) and isset($_POST['title']) and isset($_POST['text'])) {
                $postId = $_POST['postId'];
                $title = $_POST['title'];
                $text = $_POST['text'];
                $query = $conn->query("UPDATE blog SET title = '$title', text = '$text' where id = $postId");
                if ($query) {
                    $postEdited = true;
                }
            }
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
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
          href="css/admin.css">
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="ckeditor/ckeditor.js"></script>

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
            <form class="form-signin"
                  method="POST"
                  action="?act=login">
                <h2 class="form-signin-heading">Введите логин и пароль</h2>
                <label for="login"
                       class="sr-only">Логин</label>
                <input type="text"
                       id="login"
                       name="Login"
                       class="form-control"
                       placeholder="Login"
                       required
                       autofocus>
                <label for="password"
                       class="sr-only">Пароль</label>
                <input type="password"
                       id="password"
                       name="Password"
                       class="form-control"
                       placeholder="Password"
                       required>
                <button class="btn btn-lg btn-primary btn-block"
                        type="submit">Войти
                </button>
            </form>
        </div>
        <?php
    } else { ?>
        <div class="jumbotron">
            <?php if ($postEdited) { ?>
                <div class="alert alert-success">
                    <strong>Успешно!</strong> Запись отредактирована.
                </div>
            <?php } ?>
            <?php if ($postAdded) { ?>
                <div class="alert alert-success">
                    <strong>Успешно!</strong> Запись добавлена в блог.
                </div>
            <?php } ?>
            <?php if ($postRemoved) { ?>
                <div class="alert alert-success">
                    <strong>Успешно!</strong> Запись удалена из блога.
                </div>
            <?php } ?>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab"
                                      href="#feedback">Сообщения обратной связи</a></li>
                <li><a data-toggle="tab"
                       href="#blog">Записи в блоге</a></li>
                <li><a data-toggle="tab"
                       href="#map">Управление картой</a></li>
            </ul>
            <div class="tab-content"
                 style="margin-top: 5px">
                <div id="feedback"
                     class="tab-pane fade in active">
                    <?php
                    $query = $conn->query('SELECT * FROM feedback ORDER BY 1 DESC');
                    if ($query) {
                        if ($query->num_rows == 0) {
                            ?>
                            <div class="well">
                                <p>Записей пока нет!</p>
                            </div>
                            <?php
                        }
                        while ($row = $query->fetch_row()) {
                            ?>
                            <div class="well">
                                <?php
                                printf("<p><h4>Отправитель: </h4>%s<h4>Емейл: </h4>%s<h4>Сообщение: </h4>%s</p>", $row[1], $row[2], $row[3]);
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div id="blog"
                     class="tab-pane fade">
                    <button type="button"
                            class="btn btn-primary btn-block"
                            data-toggle="modal"
                            data-target="#newPostModal"
                            style="margin-bottom: 5px">Добавить запись
                    </button>
                    <div id="newPostModal"
                         class="modal fade"
                         role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button"
                                            class="close"
                                            data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Добавление новой записи</h4>
                                </div>
                                <form method="POST"
                                      action="?act=addpost">
                                    <div class="modal-body">
                                        <label for="title"
                                               class="control-label">Название записи</label>
                                        <input type="text"
                                               id="title"
                                               name="title"
                                               class="form-control"
                                               required="required"
                                               value=""
                                               placeholder="Например, привет мир!"
                                               minlength="2"
                                               maxlength="30">
                                        <hr>
                                        <label for="text"
                                               class="control-label">Текст записи</label>
                                        <textarea autocomplete="off"
                                                  name="text"
                                                  id="text"
                                                  rows="10"
                                                  cols="80"
                                                  class="form-control"
                                                  required="required"
                                                  minlength="50"></textarea>
                                        <script>
                                            CKEDITOR.replace('text');
                                        </script>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-default"
                                                data-dismiss="modal">Закрыть
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary">Добавить запись
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div id="editPostModal"
                         class="modal fade"
                         role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button"
                                            class="close"
                                            data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Редактирование записи</h4>
                                </div>
                                <form method="POST"
                                      action="?act=editpost">
                                    <div class="modal-body">
                                        <label for="title"
                                               class="control-label">Название записи</label>
                                        <input type="text"
                                               id="title"
                                               name="title"
                                               class="form-control"
                                               required="required"
                                               value=""
                                               placeholder="Например, привет мир!"
                                               minlength="2"
                                               maxlength="30">
                                        <hr>
                                        <label for="text"
                                               class="control-label">Текст записи</label>
                                        <textarea autocomplete="off"
                                                  name="text"
                                                  id="editText"
                                                  rows="10"
                                                  cols="80"
                                                  class="form-control"
                                                  required="required"
                                                  minlength="50"></textarea>
                                        <input type="hidden"
                                               name="postId"
                                               value="">
                                        <script>
                                            CKEDITOR.replace('editText');
                                        </script>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-default"
                                                data-dismiss="modal">Закрыть
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary">Редактировать
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    $query = $conn->query('SELECT * FROM blog ORDER BY 1 DESC');
                    if ($query) {
                        while ($row = $query->fetch_row()) {
                            ?>
                            <div class="well">
                                <p>
                                <h4>Название: </h4><?php echo $row[1]; ?>
                                </p>
                                <form method="POST"
                                      action="?act=removepost">
                                    <button type="submit"
                                            class="btn btn-danger"
                                            content="Удалить">Удалить
                                    </button>
                                    <button type="button"
                                            class="btn btn-primary"
                                            data-toggle="modal"
                                            data-post-id="<?php echo urlencode($row[0]); ?>"
                                            data-post-title="<?php echo urlencode($row[1]); ?>"
                                            data-post-text="<?php echo urlencode($row[3]); ?>"
                                            data-target="#editPostModal">Редактировать
                                    </button>
                                    <input type="hidden"
                                           name="postId"
                                           value="<?php echo $row[0]; ?>">
                                </form>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <script>
                        $('#editPostModal').on('show.bs.modal', function (e) {
                            //get data-id attribute of the clicked element
                            var postId = decodeURI($(e.relatedTarget).data('post-id'));
                            var postTitle = decodeURI($(e.relatedTarget).data('post-title'));
                            var postText = decodeURI($(e.relatedTarget).data('post-text'));
                            //populate the textbox
                            $(e.currentTarget).find('input[name="title"]').val(postTitle);
                            $(e.currentTarget).find('input[name="postId"]').val(postId);
                            CKEDITOR.instances['editText'].setData(postText);
                        });
                    </script>
                </div>
                <div id="map"
                     class="tab-pane fade">
                    <p>ПОКА НИЧЕГО НЕТ</p>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


</body>
</html>