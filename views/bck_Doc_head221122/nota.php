<?php

use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_head */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-head-form">
 
    <?php $form = ActiveForm::begin([ 'enableClientValidation' => true,'options' => [
        'validateOnSubmit' => true,
        'class' => 'form'
    ]]);?>
    
    
 <h1>Per Favore inserire/Modificare  la Nota</h1>
    <?php echo $form->field($model, 'id')->textInput(['hidden' => true])->label('')?>

    <?php echo $form->field($model, 'xnota')->textarea(['rows' => 6,'required'=>true])
    ->label('Nota') ?>

 
 <?= Html::submitButton('Salva', ['class' => 'btn btn-info'     ,   'data' => [
            'confirm' => 'Sei sicuro di voler Confermare la nota?',
            'method' => 'post',
        ]]) ?>
    <?php ActiveForm::end();?>

</div>
