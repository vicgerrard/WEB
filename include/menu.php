<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 17.12.2016
 * Time: 21:27
 */
?>
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../">Мой сайт</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li<?php if ($page == 'index') { ?> class="active"<?php } ?>><a href="../">Главная страница</a></li>
                <li<?php if ($page == 'blog') { ?> class="active"<?php } ?>><a href="../blog">Блог</a></li>
                <li<?php if ($page == 'contact') { ?> class="active"<?php } ?>><a href="../contact">Контакты</a></li>
                <li<?php if ($page == 'map') { ?> class="active"<?php } ?>><a href="../map">Карта</a></li>
                <li<?php if ($page == 'admin') { ?> class="active"<?php } ?>><a href="../admin">Панель
                        администратора</a></li>
                <?php

                if (session_status() == PHP_SESSION_NONE)
                        session_start();
                    if (isset($_SESSION['logined']) && $_SESSION['logined'] == 1) {
                        ?>
                        <li><a href="../admin?act=logout">Выход</a></li><?php
                    }

                ?>
            </ul>
        </div>
    </div>
</div>
