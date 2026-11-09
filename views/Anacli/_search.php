<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AnacliSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anacli-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cd_cli') ?>

    <?= $form->field($model, 'Desk') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'localita') ?>

    <?= $form->field($model, 'cap') ?>

    <?php // echo $form->field($model, 'cd_nazione') ?>

    <?php // echo $form->field($model, 'PartitaIva') ?>

    <?php // echo $form->field($model, 'CodiceFiscale') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
