<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\presenze\models\Splitted_trans */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="splitted-trans-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'data')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codicepersonale')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sorgente')->textInput() ?>

    <?= $form->field($model, 'direzione')->checkbox() ?>

    <?= $form->field($model, 'x')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'esitocc')->textInput() ?>

    <?= $form->field($model, 'presenze_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
