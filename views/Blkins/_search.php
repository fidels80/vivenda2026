<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BlkinsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blkins-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'CC_CLIENTE') ?>

    <?= $form->field($model, 'agente') ?>

    <?= $form->field($model, 'Tipo_evento') ?>

    <?= $form->field($model, 'importato') ?>

    <?php // echo $form->field($model, 'Codice_progetto') ?>

    <?php // echo $form->field($model, 'descrizione') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
