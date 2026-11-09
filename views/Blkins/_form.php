<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Blkins */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blkins-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CC_CLIENTE')->textInput() ?>

    <?= $form->field($model, 'agente')->textInput() ?>

    <?= $form->field($model, 'Tipo_evento')->textInput() ?>

    <?= $form->field($model, 'importato')->textInput() ?>

    <?= $form->field($model, 'Codice_progetto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descrizione')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
