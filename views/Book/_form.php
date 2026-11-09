<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'titolo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'editore')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'issn_isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'formato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prezzo')->textInput() ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_inizio')->textInput() ?>

    <?= $form->field($model, 'datafine')->textInput() ?>

    <?= $form->field($model, 'attivo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
