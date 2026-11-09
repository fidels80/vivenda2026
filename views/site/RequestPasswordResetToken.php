<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use demogorgorn\ajax\AjaxSubmitButton;


$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Inserire la mail dell'utenta per la quale si richiede il reset della password</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'action' => ['site/RequestPasswordReset'],
                'id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
       <?php     echo Html::button('richiedi', 
       ['value' => 'site/RequestPasswordReset',
    'class' => 'btn btn-success']);
?>
 <?php AjaxSubmitButton::begin([
    'label' => 'Check',
    'ajaxOptions' => [
        'type' => 'POST',
        'url' => 'site/RequestPasswordReset',
        'success' => new \yii\web\JsExpression('function(html){
            $("#output").html(html);
            }'),
    ],
    'options' => ['class' => 'customclass', 'type' => 'submit'],
]);
AjaxSubmitButton::end();
?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
