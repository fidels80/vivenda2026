<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'xid_testa')->textInput() ?>

    <?= $form->field($model, 'cd_cli')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Cd_PG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DataScadenza')->textInput() ?>

    <?= $form->field($model, 'DataPagamento')->textInput() ?>

    <?= $form->field($model, 'DataFattura')->textInput() ?>

    <?= $form->field($model, 'NumFattura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Protocollo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Pagata')->textInput() ?>

    <?= $form->field($model, 'NumEffetto')->textInput() ?>

    <?= $form->field($model, 'TotEffetti')->textInput() ?>

    <?= $form->field($model, 'ImportoV')->textInput() ?>

    <?= $form->field($model, 'IncassoV')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
