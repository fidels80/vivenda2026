<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RelusrformactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="relusrformaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'form') ?>

    <?= $form->field($model, 'read')->checkbox() ?>

    <?= $form->field($model, 'write')->checkbox() ?>

    <?php // echo $form->field($model, 'delete')->checkbox() ?>

    <?php // echo $form->field($model, 'access')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
