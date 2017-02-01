<?php
session_start();
$postAdded = false;
$postRemoved = false;
$postEdited = false;
$mapEdited = false;
$markerAdded = false;
$markerRemoved = false;
$markerEdited = false;
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
        case 'editmap':
            if (isset($_POST['centerLat']) and isset($_POST['centerLng']) and isset($_POST['zoom'])) {
                $centerLat = $_POST['centerLat'];
                $centerLng = $_POST['centerLng'];
                $zoom = $_POST['zoom'];
                $query = $conn->query("UPDATE map SET center_latitude = '$centerLat', center_longitude = '$centerLng', zoom = '$zoom'");
                if ($query) {
                    $mapEdited = true;
                }
            }
            break;
        case 'addmarker':
            if (isset($_POST['title']) and isset($_POST['address']) and isset($_POST['image']) and isset($_POST['lat']) and isset($_POST['lng']) and isset($_POST['url'])) {
                $title = $_POST['title'];
                $address = $_POST['address'];
                $image = $_POST['image'];
                $lat = $_POST['lat'];
                $lng = $_POST['lng'];
                $url = $_POST['url'];
                $query = $conn->query("INSERT INTO markers VALUES ('','$title','$address','$image','$lat','$lng','$url')");
                if ($query) {
                    $markerAdded = true;
                }
            }
            break;
        case 'removemarker':
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $query = $conn->query("DELETE FROM markers WHERE id = $id");
                if ($query) {
                    $markerRemoved = true;
                }
            }
            break;
        case 'editmarker':
            if (isset($_POST['title']) and isset($_POST['address']) and isset($_POST['image']) and isset($_POST['lat']) and isset($_POST['lng']) and isset($_POST['url']) and isset($_POST['id'])) {
                $title = $_POST['title'];
                $address = $_POST['address'];
                $image = $_POST['image'];
                $lat = $_POST['lat'];
                $lng = $_POST['lng'];
                $url = $_POST['url'];
                $id = $_POST['id'];
                $query = $conn->query("UPDATE markers SET title='$title', address='$address', image='$image',latitude='$lat',longitude='$lng',url='$url' where id = $id");
                if ($query) {
                    $markerEdited = true;
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUM1IWmQ9snKi3GXbQQ67ArP21ggtOcg">
    </script>
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
            <?php if ($mapEdited) { ?>
                <div class="alert alert-success">
                    <strong>Успешно!</strong> Настройки карты обновлены.
                </div>
            <?php } ?>
            <?php if ($markerAdded) { ?>
                <div class="alert alert-success">
                    <strong>Успешно!</strong> Маркер добавлен на карту.
                </div>
            <?php } ?>
            <?php if ($markerRemoved) { ?>
                <div class="alert alert-success">
                    <strong>Успешно!</strong> Маркер удален с карты.
                </div>
            <?php } ?>
            <?php if ($markerEdited) { ?>
                <div class="alert alert-success">
                    <strong>Успешно!</strong> Маркер отредактирован.
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
                            var postId = urldecode($(e.relatedTarget).data('post-id'));
                            var postTitle = urldecode($(e.relatedTarget).data('post-title'));
                            var postText = urldecode($(e.relatedTarget).data('post-text'));
                            //populate the textbox
                            $(e.currentTarget).find('input[name="title"]').val(postTitle);
                            $(e.currentTarget).find('input[name="postId"]').val(postId);
                            CKEDITOR.instances['editText'].setData(postText);
                        });
                        function urldecode(url) {
                            return decodeURIComponent((url + '').replace(/\+/g, ' '));
                        }
                    </script>
                </div>
                <?php
                include('include/markers.php'); ?>
                <div id="map"
                     class="tab-pane fade">
                    <h2>Настройки карты</h2>
                    <div class="well">
                        <form id="messageForm"
                              method="POST"
                              action="?act=editmap">
                            <div class="form-group">
                                <label for="centerLat">Широта середины (lat):</label>
                                <input type="number"
                                       name="centerLat"
                                       step="any"
                                       min="-90"
                                       max="90"
                                       class="form-control"
                                       id="centerLat"
                                       value="<?php echo $centerLatitude; ?>">
                            </div>
                            <div class="form-group">
                                <label for="centerLng">Долгота середины (lng):</label>
                                <input type="number"
                                       name="centerLng"
                                       step="any"
                                       min="-180"
                                       max="180"
                                       class="form-control"
                                       id="centerLng"
                                       value="<?php echo $centerLongitude; ?>">
                            </div>
                            <div class="form-group">
                                <label for="zoom">Зум карты:</label>
                                <input type="number"
                                       name="zoom"
                                       step="any"
                                       min="1"
                                       max="100"
                                       class="form-control"
                                       id="zoom"
                                       value="<?php echo $zoom; ?>">
                            </div>
                            <button type="submit"
                                    class="btn btn-primary">Изменить карту
                            </button>
                        </form>
                    </div>
                    <h2>Настройки маркеров</h2>
                    <button type="button"
                            class="btn btn-primary btn-block"
                            data-toggle="modal"
                            data-target="#newMarkerModal"
                            style="margin-bottom: 5px">Добавить маркер
                    </button>
                    <div id="newMarkerModal"
                         class="modal fade"
                         role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button"
                                            class="close"
                                            data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Добавление нового маркера</h4>
                                </div>
                                <form method="POST"
                                      action="?act=addmarker">
                                    <div class="modal-body">
                                        <label for="title"
                                               class="control-label">Название маркера</label>
                                        <input type="text"
                                               id="title"
                                               name="title"
                                               class="form-control"
                                               required="required"
                                               placeholder="Например, мой дом"
                                               minlength="3"
                                               maxlength="30">
                                        <br>
                                        <label for="address">Адрес (не обязательно)</label>
                                        <input type="text"
                                               id="address"
                                               name="address"
                                               class="form-control"
                                               placeholder="Например, Хошимина 11/1"
                                               minlength="10"
                                               maxlength="50">
                                        <br>
                                        <label for="image">Ссылка на изображение (не обязательно)</label>
                                        <input type="text"
                                               id="image"
                                               name="image"
                                               class="form-control"
                                               placeholder="Например, http://www.w3schools.com/css/trolltunga.jpg"
                                               minlength="10"
                                               maxlength="100">
                                        <br>
                                        <div id="mapControl"
                                             class="jumbotron">
                                            <script type="text/javascript">
                                                var map;
                                                var marker;
                                                function initMap() {
                                                    map = new google.maps.Map(document.getElementById('mapControl'), {
                                                        center: {lat: 10.0, lng: 20.0},
                                                        zoom: 1
                                                    });

                                                    map.addListener('click', function (event) {
                                                        if (marker) marker.setPosition(event.latLng);
                                                        else {
                                                            marker = new google.maps.Marker({
                                                                map: map,
                                                                position: {
                                                                    lat: event.latLng.lat(),
                                                                    lng: event.latLng.lng()
                                                                }
                                                            });
                                                        }
                                                        $('#lat').val(event.latLng.lat());
                                                        $('#lng').val(event.latLng.lng());
                                                    })
                                                }
                                                ;
                                                initMap();
                                            </script>
                                        </div>
                                        <label for="lat">Широта точки</label>
                                        <input type="number"
                                               name="lat"
                                               step="any"
                                               min="-90"
                                               max="90"
                                               value="0"
                                               class="form-control"
                                               id="lat"
                                               value="">
                                        <br>
                                        <label for="lng">Долгота точки</label>
                                        <input type="number"
                                               name="lng"
                                               step="any"
                                               min="-180"
                                               max="180"
                                               value="0"
                                               class="form-control"
                                               id="lng"
                                               value="">
                                        <br>
                                        <label for="url">Ссылка для перехода (не обязательно)</label>
                                        <input type="text"
                                               id="url"
                                               name="url"
                                               class="form-control"
                                               placeholder="Например, http://www.w3schools.com/"
                                               minlength="10"
                                               maxlength="100">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-default"
                                                data-dismiss="modal">Закрыть
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary">Добавить
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="editMarkerModal"
                         class="modal fade"
                         role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button"
                                            class="close"
                                            data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Редактирование маркера</h4>
                                </div>
                                <form method="POST"
                                      action="?act=editmarker">
                                    <div class="modal-body">
                                        <label for="title"
                                               class="control-label">Название маркера</label>
                                        <input type="text"
                                               id="title"
                                               name="title"
                                               class="form-control"
                                               required="required"
                                               placeholder="Например, мой дом"
                                               minlength="3"
                                               maxlength="30">
                                        <br>
                                        <label for="address">Адрес (не обязательно)</label>
                                        <input type="text"
                                               id="address"
                                               name="address"
                                               class="form-control"
                                               placeholder="Например, Хошимина 11/1"
                                               minlength="10"
                                               maxlength="50">
                                        <br>
                                        <label for="image">Ссылка на изображение (не обязательно)</label>
                                        <input type="text"
                                               id="image"
                                               name="image"
                                               class="form-control"
                                               placeholder="Например, http://www.w3schools.com/css/trolltunga.jpg"
                                               minlength="10"
                                               maxlength="100">
                                        <br>
                                        <label for="lat">Широта точки</label>
                                        <input type="number"
                                               name="lat"
                                               step="any"
                                               min="-90"
                                               max="90"
                                               value="0"
                                               class="form-control"
                                               id="lat"
                                               value="">
                                        <br>
                                        <label for="lng">Долгота точки</label>
                                        <input type="number"
                                               name="lng"
                                               step="any"
                                               min="-180"
                                               max="180"
                                               value="0"
                                               class="form-control"
                                               id="lng"
                                               value="">
                                        <br>
                                        <label for="url">Ссылка для перехода (не обязательно)</label>
                                        <input type="text"
                                               id="url"
                                               name="url"
                                               class="form-control"
                                               placeholder="Например, http://www.w3schools.com/"
                                               minlength="10"
                                               maxlength="100">
                                        <input type="hidden"
                                               name="id"
                                               id="id">
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
                    foreach ($markers as $marker) {
                        ?>
                        <div class="well">
                            <p>
                            <h4>Название: </h4><?php echo $marker['title'] ?>
                            <?php if ($marker['address']) { ?>
                                <h4>Адрес: </h4><?php echo $marker['address'] ?>
                            <?php } ?>
                            <?php if ($marker['image']) { ?>
                                <h4>Изображение: </h4><img src="<?php echo $marker['image'] ?>"
                                                           width="200px">
                            <?php } ?>
                            <h4>Широта: </h4><?php echo $marker['latitude'] ?>
                            <h4>Долгота: </h4><?php echo $marker['longitude'] ?>
                            <?php if ($marker['url']) { ?>
                                <h4>Ссылка: </h4><?php echo $marker['url'] ?>
                            <?php } ?>
                            </p>
                            <form method="POST"
                                  action="?act=removemarker">
                                <button type="submit"
                                        class="btn btn-danger"
                                        content="Удалить">Удалить
                                </button>
                                <button type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-id="<?php echo urlencode($marker['id']); ?>"
                                        data-title="<?php echo urlencode($marker['title']); ?>"
                                        data-address="<?php echo urlencode($marker['address']); ?>"
                                        data-image="<?php echo urlencode($marker['image']); ?>"
                                        data-latitude="<?php echo urlencode($marker['latitude']); ?>"
                                        data-longitude="<?php echo urlencode($marker['longitude']); ?>"
                                        data-url="<?php echo urlencode($marker['url']); ?>"
                                        data-target="#editMarkerModal">Редактировать
                                </button>
                                <input type="hidden"
                                       name="id"
                                       value="<?php echo $marker['id']; ?>">
                            </form>
                        </div>
                        <?php
                    }
                    ?>
                    <script>
                        $('#editMarkerModal').on('show.bs.modal', function (e) {
                            var id = urldecode($(e.relatedTarget).data('id'));
                            var title = urldecode($(e.relatedTarget).data('title'));
                            var address = urldecode($(e.relatedTarget).data('address'));
                            var image = urldecode($(e.relatedTarget).data('image'));
                            var latitude = urldecode($(e.relatedTarget).data('latitude'));
                            var longitude = urldecode($(e.relatedTarget).data('longitude'));
                            var url = urldecode($(e.relatedTarget).data('url'));
                            //populate the textbox
                            $(e.currentTarget).find('input[name="title"]').val(title);
                            $(e.currentTarget).find('input[name="address"]').val(address);
                            $(e.currentTarget).find('input[name="image"]').val(image);
                            $(e.currentTarget).find('input[name="lat"]').val(latitude);
                            $(e.currentTarget).find('input[name="lng"]').val(longitude);
                            $(e.currentTarget).find('input[name="url"]').val(url);
                            $(e.currentTarget).find('input[name="id"]').val(id);
                        });
                    </script>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


</body>
</html>