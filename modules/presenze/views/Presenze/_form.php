<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\presenze\models\Presenze */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="presenze-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tran')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idterm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datarec')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
