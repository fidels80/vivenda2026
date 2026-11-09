<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dadata')->textInput() ?>

    <?= $form->field($model, 'adata')->textInput() ?>

    <?= $form->field($model, 'elemento')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
