<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PasswordResetRequestForm */

$this->title = 'Recupera password';

$logoUrl = Yii::getAlias('@web') . '/images/vivenda-logo.png';
?>

<div class="auth-box">

    <div class="auth-brand">
        <img src="<?= Html::encode($logoUrl) ?>" alt="Vivenda" class="auth-logo">
        <p class="auth-brand-subtitle">Gestione commesse e documenti</p>
    </div>

    <div class="card auth-card">
        <div class="card-body">
            <p class="auth-card-title">Recupera password</p>
            <p class="auth-hint">Inserisci la mail dell'utente per la quale si richiede il reset della password.</p>

            <?php $form = ActiveForm::begin([
                'id' => 'request-password-reset-form',
                'action' => ['user/rp'],
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

            <?= Html::submitButton('<i class="fas fa-paper-plane"></i> Invia', [
                'class' => 'btn btn-primary btn-block btn-lg auth-submit',
            ]) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <p class="auth-footer">
        <?= Html::a('Torna al login', ['site/login']) ?>
    </p>
</div>
