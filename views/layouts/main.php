<?php
use app\models\User;
use app\models\LoginForm;

/* @var $this \yii\web\View */
/* @var $content string */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
//use app\models\User;
use app\models\SignupForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;


$usrid = Yii::$app->user->Id;

$ris = [];
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['level', 'cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one() ?: [];
}

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\app\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
\hail812\adminlte3\assets\PluginAsset::register($this)->add(['sweetalert2']);
$this->registerCssFile(Yii::getAlias('@web/css/apple-theme.css'), ['depends' => [\hail812\adminlte3\assets\AdminLteAsset::class]]);
$this->registerCssFile(Yii::getAlias('@web/css/custom-styles.css'), ['depends' => [\hail812\adminlte3\assets\AdminLteAsset::class]]);

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$publishedRes = Yii::$app->assetManager->publish('@vendor/hail812/yii2-adminlte3/src/web/js');
$this->registerJsFile($publishedRes[1] . '/control_sidebar.js', ['depends' => '\hail812\adminlte3\assets\AdminLteAsset']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini apple-theme<?= Yii::$app->user->isGuest ? ' login-page' : '' ?>">
<script>
    (function () {
        try {
            if (localStorage.getItem('vivenda-theme') === 'dark') {
                document.body.classList.add('dark-mode');
            }
        } catch (e) { }
    })();
</script>
<?php $this->beginBody() ?>

<?php
$request = Yii::$app->request;
$get = $request->get();
?>

<!-- Loading overlay: copre la pagina durante il caricamento per evitare click ripetuti -->
<div id="app-loader" style="position: fixed; inset: 0; z-index: 99999; background: #f4f6f9; display: flex; align-items: center; justify-content: center; flex-direction: column;">
    <i class="fas fa-circle-notch fa-spin" style="color: #007bff; font-size: 3.5rem;"></i>
    <p class="mt-3 mb-0 text-muted" style="font-size: 1rem;">Caricamento...</p>
</div>
<script>
    (function () {
        function hideLoader() {
            var el = document.getElementById('app-loader');
            if (el) {
                el.style.transition = 'opacity .3s ease';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 350);
            }
        }
        if (document.readyState === 'complete') {
            hideLoader();
        } else {
            window.addEventListener('load', hideLoader);
            // Fallback: se la pagina impiega troppo, togli comunque dopo 5s
            setTimeout(hideLoader, 5000);
        }
    })();
</script>

<?php if (Yii::$app->user->isGuest): ?>
    <?php $authWide = (($request->get('isnew')) !== null) || (($request->get('reset')) !== null); ?>
    <div class="wrapper auth-wrapper">
        <div class="auth-container<?= $authWide ? ' auth-container-wide' : '' ?>">
    <?php
    if (($request->get('isnew')) !== null) {
        echo $this->render('/site/signup', ['model' => new SignupForm()]);
    } else {

        if (($request->get('reset')) !== null) {
      echo $this->render('/user/rp',
          ['model'=> new PasswordResetRequestForm()]
        );
          //, ['model' => new LoginForm()]);

        } elseif (($request->get('token') == null)) {
            echo  $this->render('/site/login', ['model' => new LoginForm(),]);
        }
    }
    ?>
        </div>
    </div>
<?php //$this->render('/site/login',[$model=>[new LoginForm()]]) ?>

</div>


<?php elseif (($ris['cd_cli'] ?? null) == null || ($ris['level'] ?? null) == null): ?>

<div class="wrapper">
<?php echo $this->render('navbar', ['assetDir' => $assetDir]) ?>


    <!-- /.control-sidebar -->
    <div class="card">
    <div class="card-body login-card-body">
<table height="450px" width='100%'>
    <br><br><br><br><br><br><br><br>
    <h1 align ="center">A breve sarà attivata l'utenza controlla la mail <br>
        che hai usato per registarti!</h1>
    <br>
</table>
</div></div>
    <!-- Main Footer -->
    <?= $this->render('footer') ?>
</div>


    <?php else: ?>
<div class="wrapper">
    <!-- Navbar -->
    <?php echo  $this->render('navbar', ['assetDir' => $assetDir]) ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php  echo $this->render('sidebar', ['assetDir' => $assetDir]) ?>

    <!-- Content Wrapper. Contains page content -->
    <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?= $this->render('control-sidebar') ?>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?= $this->render('footer') ?>
</div>
<?php  endif;?>
<?= \bizley\cookiemonster\CookieMonster::widget(['content' => [
        'buttonMessage' => 'OK', // instead of default 'I understand'
        'mainMessage'=>'I Cookies utilizzzati sono vincolati solo e unicamente all\'uso interno della web app per la quale avete richiesto accesso di conseguenza l\'uso
        degli stessi è limitato alla singola applicazione e sessione e non vengono ceduti a terze parti o utilizzati a fini statistici di qualunque tipo'
    ],
    'mode' => 'bottom'
]); ?>

<?php
$mailFailedMsg = Yii::$app->session->getFlash('mail_failed');
if ($mailFailedMsg !== null) {
    $mailFailedText = is_string($mailFailedMsg) && $mailFailedMsg !== ''
        ? $mailFailedMsg
        : 'Non è stato possibile inviare l\'email. Il dato è stato comunque salvato.';
    $mailFailedJson = \yii\helpers\Json::htmlEncode($mailFailedText);
    $mailFailedJs = <<<JS
(function () {
    var showMailAlert = function () {
        if (typeof Swal === 'undefined') { return; }
        Swal.fire({
            icon: 'warning',
            title: 'Email non inviata',
            text: {$mailFailedJson},
            confirmButtonText: 'OK'
        });
    };
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', showMailAlert);
    } else {
        showMailAlert();
    }
})();
JS;
    $this->registerJs($mailFailedJs);
}
?>

<?php
$confirmSaveJs = <<<JS
(function () {
    if (typeof Swal === 'undefined') { return; }
    $(document).on('click',
        'form[method="post"] button.btn-success:not([type="button"]):not([data-no-confirm]), ' +
        'form[method="post"] input[type="submit"].btn-success:not([data-no-confirm])',
        function (e) {
            var \$btn = $(this);
            var \$form = \$btn.closest('form');
            if (\$form.data('swal-confirmed')) { return; }
            e.preventDefault();
            Swal.fire({
                title: 'Confermi il salvataggio?',
                text: 'I dati verranno salvati.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sì, salva',
                cancelButtonText: 'Annulla',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d'
            }).then(function (result) {
                if (result.isConfirmed) {
                    \$form.data('swal-confirmed', true);
                    \$btn.trigger('click');
                }
            });
        });
})();
JS;
$this->registerJs($confirmSaveJs);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
