<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'titolo') ?>

    <?= $form->field($model, 'editore') ?>

    <?= $form->field($model, 'issn_isbn') ?>

    <?= $form->field($model, 'formato') ?>

    <?php // echo $form->field($model, 'prezzo') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'data_inizio') ?>

    <?php // echo $form->field($model, 'datafine') ?>

    <?php // echo $form->field($model, 'attivo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
