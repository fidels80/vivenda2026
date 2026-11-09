<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Log */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'operazione')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valore')->textInput() ?>

    <?= $form->field($model, 'old_valore')->textInput() ?>

    <?= $form->field($model, 'timeins')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
