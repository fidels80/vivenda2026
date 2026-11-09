<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_rowsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-rows-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'doc_head_id') ?>

    <?= $form->field($model, 'cd_art') ?>

    <?= $form->field($model, 'descrizione') ?>

    <?= $form->field($model, 'um') ?>

    <?php // echo $form->field($model, 'qta') ?>

    <?php // echo $form->field($model, 'prezzo') ?>

    <?php // echo $form->field($model, 'sconto') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'cd_doc') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'numdoc') ?>

    <?php // echo $form->field($model, 'cd_cli') ?>

    <?php // echo $form->field($model, 'xid_testa') ?>

    <?php // echo $form->field($model, 'xid_riga') ?>

    <?php // echo $form->field($model, 'iva') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
