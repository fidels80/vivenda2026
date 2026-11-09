<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'xid_testa') ?>

    <?= $form->field($model, 'cd_cli') ?>

    <?= $form->field($model, 'Cd_PG') ?>

    <?= $form->field($model, 'DataScadenza') ?>

    <?php // echo $form->field($model, 'DataPagamento') ?>

    <?php // echo $form->field($model, 'DataFattura') ?>

    <?php // echo $form->field($model, 'NumFattura') ?>

    <?php // echo $form->field($model, 'Protocollo') ?>

    <?php // echo $form->field($model, 'Pagata') ?>

    <?php // echo $form->field($model, 'NumEffetto') ?>

    <?php // echo $form->field($model, 'TotEffetti') ?>

    <?php // echo $form->field($model, 'ImportoV') ?>

    <?php // echo $form->field($model, 'IncassoV') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
