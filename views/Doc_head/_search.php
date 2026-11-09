<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_headSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-head-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cd_doc') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'numdoc') ?>

    <?= $form->field($model, 'cd_cli') ?>

    <?php // echo $form->field($model, 'cd_pg') ?>

    <?php // echo $form->field($model, 'sconto') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
