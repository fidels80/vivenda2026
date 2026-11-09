<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rep_publicazioni */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rep-publicazioni-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cd_cf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cd_Art')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descrizione')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datacons')->textInput() ?>

    <?= $form->field($model, 'Cd_DOSottoCommessa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Cd_DO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PrezzoUnitarioScontatoV')->textInput() ?>

    <?= $form->field($model, 'Qta')->textInput() ?>

    <?= $form->field($model, 'PrezzoTotaleE')->textInput() ?>

    <?= $form->field($model, 'Cd_ARMarca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Id_DORig')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
