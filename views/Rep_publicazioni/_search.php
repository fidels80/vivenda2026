<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rep_publicazioniSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rep-publicazioni-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'cd_cf') ?>

    <?= $form->field($model, 'cd_Art') ?>

    <?= $form->field($model, 'descrizione') ?>

    <?= $form->field($model, 'datacons') ?>

    <?= $form->field($model, 'Cd_DOSottoCommessa') ?>

    <?php // echo $form->field($model, 'Cd_DO') ?>

    <?php // echo $form->field($model, 'PrezzoUnitarioScontatoV') ?>

    <?php // echo $form->field($model, 'Qta') ?>

    <?php // echo $form->field($model, 'PrezzoTotaleE') ?>

    <?php // echo $form->field($model, 'Cd_ARMarca') ?>

    <?php // echo $form->field($model, 'Id_DORig') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
