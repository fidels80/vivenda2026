<?php

use yii\helpers\Html;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$publishedRes = Yii::$app->assetManager->publish('@vendor/hail812/yii2-adminlte3/src/web/js');
$this->registerJsFile($publishedRes[1] . '/control_sidebar.js', ['depends' => '\hail812\adminlte3\assets\AdminLteAsset']);

?>

<script>
    function dm() {
        var isDark = !document.body.classList.contains('dark-mode');
        document.body.classList.toggle('dark-mode', isDark);
        try {
            localStorage.setItem('vivenda-theme', isDark ? 'dark' : 'light');
        } catch (e) { }
        aggiornaIconaTema(isDark);
    }

    function aggiornaIconaTema(isDark) {
        var icon = document.getElementById('dm-icon');
        if (!icon) { return; }
        icon.classList.toggle('far', !isDark);
        icon.classList.toggle('fa-moon', !isDark);
        icon.classList.toggle('fas', isDark);
        icon.classList.toggle('fa-sun', isDark);
    }

    document.addEventListener('DOMContentLoaded', function () {
        aggiornaIconaTema(document.body.classList.contains('dark-mode'));
        var toggle = document.getElementById('dm-toggle');
        if (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                dm();
            });
        }
    });
</script>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" data-enable-remember="true">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Schermo intero">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" id="dm-toggle" title="Tema chiaro/scuro" role="button">
                <i class="far fa-moon" id="dm-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link', 'title' => 'Logout']) ?>
        </li>
    </ul>
</nav>
