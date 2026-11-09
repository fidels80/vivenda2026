<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\presenze\models\Splitted_transSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="splitted-trans-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'ora') ?>

    <?= $form->field($model, 'codicepersonale') ?>

    <?php // echo $form->field($model, 'sorgente') ?>

    <?php // echo $form->field($model, 'direzione')->checkbox() ?>

    <?php // echo $form->field($model, 'x') ?>

    <?php // echo $form->field($model, 'esitocc') ?>

    <?php // echo $form->field($model, 'presenze_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
