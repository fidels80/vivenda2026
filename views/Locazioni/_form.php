<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;
/* @var $this yii\web\View */
/* @var $model app\models\Locazioni */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="locazioni-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descrizione')->textInput(['maxlength' => true]) ?>

    <?php  echo $form->field($model, 'colore')->widget(ColorInput::classname(),
     [ 
    'options' => ['placeholder' => 'Select color ...',
    'class'=>"form-control",
    'aria-required'=>'true'],
 ]); 
//echo $form->field($model, 'colore')->textInput(['maxlength' => true])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
