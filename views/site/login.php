<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */

$this->title = 'Accedi';

$logoUrl = Yii::getAlias('@web') . '/images/vivenda-logo.png';
?>

<div class="auth-box">

    <div class="auth-brand">
        <img src="<?= Html::encode($logoUrl) ?>" alt="Vivenda" class="auth-logo">
        <p class="auth-brand-subtitle">Gestione commesse e documenti</p>
    </div>

    <?php if (Yii::$app->session->hasFlash('inviato')): ?>
        <div class="alert alert-success">
            A breve riceverai una mail con il link di reset. Ricordati di controllare anche lo spam!
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('errore')): ?>
        <div class="alert alert-danger">
            Non sono riuscito a inviare la mail!!
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('Login fallita')): ?>
        <div class="alert alert-danger">
            Email o password inseriti non corrispondono!
        </div>
    <?php endif; ?>

    <div class="card auth-card">
        <div class="card-body">
            <p class="auth-card-title">Collegati</p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => ['site/login'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'errorOptions' => ['class' => 'invalid-feedback d-block'],
                ],
            ]); ?>

            <?= $form->field($model, 'email', [
                'labelOptions' => ['class' => 'auth-label'],
                'inputTemplate' => '<div class="auth-input-wrap">{input}<i class="fas fa-envelope auth-field-icon"></i></div>',
            ])
                ->label('Email')
                ->textInput([
                    'class' => 'form-control auth-input',
                    'placeholder' => 'nome@dominio.it',
                    'autofocus' => true,
                ]) ?>

            <?= $form->field($model, 'password', [
                'labelOptions' => ['class' => 'auth-label'],
                'inputTemplate' => '<div class="auth-input-wrap">{input}<i class="fas fa-lock auth-field-icon"></i>'
                    . '<button type="button" class="auth-pass-toggle" tabindex="-1" aria-label="Mostra password">'
                    . '<i class="fas fa-eye"></i></button></div>',
            ])
                ->label('Password')
                ->passwordInput([
                    'class' => 'form-control auth-input',
                    'placeholder' => '••••••••',
                ]) ?>

            <div class="auth-row">
                <div class="auth-remember">
                    <?= $form->field($model, 'rememberMe')
                        ->checkbox(['uncheck' => null])
                        ->label('Ricordami') ?>
                </div>

                <?= Html::a('Password dimenticata?', ['user/rp', 'reset' => 1], ['class' => 'auth-link']) ?>
            </div>

            <?= Html::submitButton('<i class="fas fa-sign-in-alt"></i> Accedi', [
                'class' => 'btn btn-primary btn-block btn-lg auth-submit',
            ]) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <p class="auth-footer">
        Non hai un account? <?= Html::a('Registrati', ['site/login', 'isnew' => true]) ?>
    </p>
</div>

<?php
$js = <<<JS
$('.auth-pass-toggle').on('click', function () {
    var \$input = \$('#loginform-password');
    var type = \$input.attr('type') === 'password' ? 'text' : 'password';
    \$input.attr('type', type);
    \$('i', this).toggleClass('fa-eye fa-eye-slash');
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
