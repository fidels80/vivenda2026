<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm */

$this->title = 'Registrati';

$logoUrl = Yii::getAlias('@web') . '/images/vivenda-logo.png';
?>

<div class="auth-box">

    <div class="auth-brand">
        <img src="<?= Html::encode($logoUrl) ?>" alt="Vivenda" class="auth-logo">
        <p class="auth-brand-subtitle">Crea il tuo account</p>
    </div>

    <div class="card auth-card">
        <div class="card-body">
            <p class="auth-card-title">Registrati</p>
            <p class="auth-hint">Compila i campi per registrarti.</p>

            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'action' => ['site/signup'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'errorOptions' => ['class' => 'invalid-feedback d-block'],
                ],
            ]); ?>

            <?= $form->field($model, 'username', [
                'labelOptions' => ['class' => 'auth-label'],
                'inputTemplate' => '<div class="auth-input-wrap">{input}<i class="fas fa-user auth-field-icon"></i></div>',
            ])
                ->label('Username')
                ->textInput(['class' => 'form-control auth-input', 'maxlength' => 29, 'autofocus' => true]) ?>

            <?= $form->field($model, 'email', [
                'labelOptions' => ['class' => 'auth-label'],
                'inputTemplate' => '<div class="auth-input-wrap">{input}<i class="fas fa-envelope auth-field-icon"></i></div>',
            ])
                ->label('Email')
                ->textInput(['class' => 'form-control auth-input', 'placeholder' => 'nome@dominio.it']) ?>

            <?= $form->field($model, 'piva', [
                'labelOptions' => ['class' => 'auth-label'],
                'inputTemplate' => '<div class="auth-input-wrap">{input}<i class="fas fa-building auth-field-icon"></i></div>',
            ])
                ->label('Partita IVA')
                ->textInput(['class' => 'form-control auth-input', 'maxlength' => 13]) ?>

            <?= $form->field($model, 'password', [
                'labelOptions' => ['class' => 'auth-label'],
                'inputTemplate' => '<div class="auth-input-wrap">{input}<i class="fas fa-lock auth-field-icon"></i></div>',
            ])
                ->label('Password')
                ->passwordInput(['class' => 'form-control auth-input', 'id' => 'signup-password', 'placeholder' => '••••••••']) ?>

            <div class="form-group auth-field">
                <label class="auth-label" for="signup-password2">Conferma password</label>
                <div class="auth-input-wrap">
                    <input type="password" id="signup-password2" class="form-control auth-input" name="password2" placeholder="••••••••">
                    <i class="fas fa-lock auth-field-icon"></i>
                </div>
                <div id="signup-password-msg" class="invalid-feedback d-block"></div>
            </div>

            <?= Html::submitButton('<i class="fas fa-user-plus"></i> Registrati', [
                'class' => 'btn btn-primary btn-block btn-lg auth-submit',
            ]) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <p class="auth-footer">
        Hai già un account? <?= Html::a('Accedi', ['site/login']) ?>
    </p>
</div>

<?php
$js = <<<JS
(function () {
    function check() {
        var p1 = \$('#signup-password').val() || '';
        var p2 = \$('#signup-password2').val() || '';
        var msg = \$('#signup-password-msg');
        var btn = \$('#form-signup button[type="submit"]');

        if (p1 && p2 && p1 !== p2) {
            msg.text('Le password non coincidono.');
            btn.prop('disabled', true);
            return;
        }
        if (p1 && !/[A-Z]/.test(p1)) {
            msg.text('La password deve contenere almeno un carattere maiuscolo.');
            btn.prop('disabled', true);
            return;
        }
        if (p1 && !/[0-9]/.test(p1)) {
            msg.text('La password deve contenere almeno un numero.');
            btn.prop('disabled', true);
            return;
        }
        msg.text('');
        btn.prop('disabled', false);
    }

    \$('#signup-password, #signup-password2').on('input', check);
})();
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
