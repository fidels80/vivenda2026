<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_rows */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-rows-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'doc_head_id')->textInput() ?>

    <?= $form->field($model, 'cd_art')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descrizione')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'um')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qta')->textInput() ?>

    <?= $form->field($model, 'prezzo')->textInput() ?>

    <?= $form->field($model, 'sconto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput() ?>

    <?= $form->field($model, 'cd_doc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'numdoc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cd_cli')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
