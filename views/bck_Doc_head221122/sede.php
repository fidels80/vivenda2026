<?php

use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\relcli;
use app\models\anacli;


use app\models\CliDest;

$usrid = Yii::$app->user->Id;

if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['email','cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
    //->AsArray();
}

 


$annmodel = (new \yii\db\Query())
    ->select(['altcli as id', 'Desk as Name'])
    ->from('relcli')
    ->leftJoin('ana_cli', 'relcli.altcli = ana_cli.cd_cli')
    ->where(['relcli.cd_cli' => $ris['cd_cli']])
->all();
$listdest = ArrayHelper::map($annmodel, 'id', 'Name');
yii::error($annmodel);

/* @var $this yii\web\View */
/* @var $model app\models\Doc_head */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-head-form">

    <?php $form = ActiveForm::begin();?>
    
    
 <h1>Per Favore inserire il Nuovo Intestatario</h1>
    <?php echo $form->field($model, 'id')->textInput(['hidden' => true])->label('')?>

    <?php echo $form->field($model, 'altcli')->widget(Select2::classname(), [
    'data' => $listdest,
    'options' => ['placeholder' => 'Seleziona Intestatario'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
])    ->label('Intestatario') ?>

 
 <?= Html::submitButton('Conferma', ['class' => 'btn btn-success'     ,   
 'data' => [
            'confirm' => 'Sei sicuro di voler Confermare Il nuovo Intestatario?',
            'method' => 'post',
        ]]) ?>
    <?php ActiveForm::end();?>

</div>
