<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Xaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Tipo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
