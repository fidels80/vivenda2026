<?php

use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_head */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-head-form">
<?php
echo \hail812\adminlte\widgets\Alert::widget([
    'type' => 'danger',
    'body' => 'il mancato inserimento delle note prevede il mancato annullamento della richiesta',
]);
?>
    <?php $form = ActiveForm::begin([ 'enableClientValidation' => true,'options' => [
        'validateOnSubmit' => true,
        'class' => 'form'
    ]]);?>
    
    
 <h1>Per Favore inserire Motivazioni Rifiuto</h1>
    <?php echo $form->field($model, 'id')->textInput(['hidden' => true])->label('')?>

    <?php echo $form->field($model, 'rifiutato_nota')->textarea(['rows' => 6,'required'=>true])
    ->label('Motivazioni Rifiuto') ?>

 
 <?= Html::submitButton('Rifiuta', ['class' => 'btn btn-danger'     ,   'data' => [
            'confirm' => 'Sei sicuro di voler ANNULLARE il documento?',
            'method' => 'post',
        ]]) ?>
    <?php ActiveForm::end();?>

</div>
