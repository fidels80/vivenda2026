<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Xsubmenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xsubmenu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'voce')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'azione')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_menu')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
