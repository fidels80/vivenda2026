<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AgendafilesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agenda-files-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_agenda') ?>

    <?= $form->field($model, 'descrizione') ?>

    <?= $form->field($model, 'nota') ?>

    <?= $form->field($model, 'f_content') ?>

    <?php // echo $form->field($model, 'nome_file') ?>

    <?php // echo $form->field($model, 'estenzione') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
