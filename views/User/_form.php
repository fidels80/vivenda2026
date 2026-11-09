     <script type="text/javascript" src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#password2').focusout(function(){
        var pass = $('#password').val();
        var pass2 = $('#password2').val();
        if(pass != pass2){
            alert('le password non sono uguali!');
        }

    });
});
       </script> 

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\usrgrp;
use app\models\xmenu;
use app\models\xsubmenu;
use app\models\Anacli;
use dosamigos\fileupload\FileUploadui;


$cli= anacli::find()
        ->Select(['cd_cli'])
        ->where (['PartitaIva'=>$model->piva])
        ->AsArray()
        ->One();
        yii::warning($model->cd_cli);

        if (empty($cli)==false || empty( $model->cd_cli)==true){
        $model->cd_cli= $cli['cd_cli'] ?? '';
        }


/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

/*
'default'
'primary'
'secondary'
'info'
'danger'
'warning'
'success'
'light'
'dark'
*/
$grid=[];//array('id'=>'default','name'=>'default');
$grid[]=array('id'=>'default','Name'=>'Trasparente');
$grid[]=array('id'=>'primary','Name'=>'Blu');
$grid[]=array('id'=>'secondary','Name'=>'Grigio');
$grid[]=array('id'=>'info','Name'=>'Azzurro');
$grid[] = array('id' => 'danger', 'Name' => 'Rosso');
$grid[]=array('id'=>'warning','Name'=>'Giallo');
$grid[] = array('id' => 'success', 'Name' => 'Verde');
$grid[] = array('id' => 'light', 'Name' => 'Bianco');
$grid[] = array('id' => 'dark', 'Name' => 'Nero');




$grid2=ArrayHelper::map($grid, 'id', 'Name');
$grid3 = []; //array('id'=>'default','name'=>'default');
$grid3[] = array('id' => 'default', 'Name' => 'Trasparente');
$grid3[] = array('id' => 'primary', 'Name' => 'Blu');
$grid3[] = array('id' => 'secondary', 'Name' => 'Grigio');
$grid3[] = array('id' => 'info', 'Name' => 'Azzurro');
$grid3[] = array('id' => 'danger', 'Name' => 'Rosso');
$grid3[] = array('id' => 'warning', 'Name' => 'Giallo');
$grid3[] = array('id' => 'success', 'Name' => 'Verde');
$grid3[] = array('id' => 'light', 'Name' => 'Bianco');
$grid3[] = array('id' => 'gray', 'Name' => 'Grigio');
$grid3[] = array('id' => 'gray-dark', 'Name' => 'Grigio/nero');
$grid3[] = array('id' => 'black', 'Name' => 'Nero');

$grid3 = ArrayHelper::map($grid3, 'id', 'Name');
yii::warning($grid3);
 
$status_=[];
$status_[] = array('id' => '0', 'Name' => 'Disabilitato');
$status_[] = array('id' => '10', 'Name' => 'Attivato');
$status_=ArrayHelper::map($status_, 'id', 'Name');
yii::warning($status_);

$usrgrp = usrgrp::find()
    ->select(['codice as id', 'descrizione as  Name'])
    ->asArray()
    ->all();
$usrgrplt = ArrayHelper::map($usrgrp, 'id', 'Name');



$moduli= xmenu::find()
     ->select(['voce as id', 'voce as  Name'])
      ->where(['>','len(voce)',1])
      ->andwhere(['<','level',100])
      ->AsArray()
      ->all();  
$smoduli = xsubmenu::find()
    ->select(['voce as id', 'voce as  Name'])
    ->where(['>', 'len(voce)', 1])
     ->andwhere(['<','level',100])
    ->AsArray()
    ->all();
$xmenus=array_merge($moduli,$smoduli);
 
$lst_menu=ArrayHelper::map($xmenus,'id','Name');

$cli= Anacli::find()
->select(['cd_cli as id','Desk as Name'])
->where(['=','cd_cli','C004241'])
->orwhere(['=','cd_cli','C001443'])
->orwhere(['=','cd_cli','C000065'])
->orwhere(['=','cd_cli','C004207'])
->orwhere(['=','cd_cli','C004024'])
->asArray()
->all();
$lstcli=ArrayHelper::map($cli,'id','Name');





?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id'=>'usr','options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php //$form->field($model, 'status')->textInput(['maxlength' => true]) 
    

    ?>
 
<div class="card card-primary">
<div class="card-header">
    
<h3 class="card-title">Interfaccia Utente</h3>
</div>
<div class="card-body">
<?php
echo
'<img src="'.Yii::getAlias('@web').'/uploads/'.$model->id.'_'.
 str_replace(' ', '_',$model->file) .'" alt="Img non caricata" width="50" height="50">';

//echo Yii::getAlias('@web') . '/uploads/' . $usrid . '_' . str_replace(' ', '_', $ris['file']);


?>
<?= $form->field($model, 'file')->fileInput(['label'=>'immagine profilo'])->label('Avatar',['class'=>'label-class']) ?>
 
<?= $form->field($model,'grid_color')->widget(Select2::classname(), [
    'data' => $grid2,
    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona locazione ...'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);
 ?>
 
 <?= $form->field($model,'sidebar_color')->widget(Select2::classname(), [
    'data' => $grid3,
    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona locazione ...'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);
 ?>
<?=  $form->field($model,'piva')->textInput(['maxlength' => true,'readonly'=>true]);?>
        <?=$form->field($model, 'password')->passwordInput(['id' => 'password','autofocus' => true])?>
        <?=$form->field($model, 'password')->passwordInput(['id' => 'password2','autofocus' => true])?>

        



</div>
<div class="card-footer">

</div>
</div>






 <?php if(yii::$app->user->identity->level==100){
echo <<<EOD
<div class="card card-danger">
<div class="card-header">
<h3 class="card-title">Admin Panel</h3>
</div>
<div class="card-body">
EOD;


//echo '<br><h3>status a 10 per attivazione utenza</h3><br>';
echo  $form->field($model,'status')->widget(Select2::classname(), [
    'data' => $status_,
    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona Status ...'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);

 };?>


 <?php if (yii::$app->user->identity->level == 100) {
    
    echo $form->field($model, 'gruppo')->widget(Select2::classname(), [
    'data' => $usrgrplt,
    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona gruppo ...'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);
$data = [
    "red" => "red",
    "green" => "green",
    "blue" => "blue",
    "orange" => "orange",
    "white" => "white",
    "black" => "black",
    "purple" => "purple",
    "cyan" => "cyan",
    "teal" => "teal",
];

$row=unserialize($model->moduli);


//explode("|",$model->moduli);

echo $form->field($model, 'moduli',['enableClientValidation' => false])->
widget(Select2::classname(), [
    'data' => $lst_menu,

    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona gruppo ...','multiple' => true,
'tags' => true,
           'value' =>$row,
        'maximumInputLength' => 10


],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);
$row =unserialize($model->reports);

// explode("|", $model->reports);
yii::error($row);
echo $form->field($model, 'reports', ['enableClientValidation' => false])->
    widget(Select2::classname(), [
    'data' => $data,

    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona gruppo ...', 'multiple' => true,
        'tags' => true,
        'value' => $row,
        'maximumInputLength' => 10,

    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);
yii::error($model->cd_cli);

echo $form->field($model, 'cd_cli', ['enableClientValidation' => false])->
    widget(Select2::classname(), [
    'data' => $lstcli,

    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona Cliente ...', 
        

    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);

echo $form->field($model, 'ischief')->checkBox(['label' => 'E\' utente vivenda','data-size'=>'small', 'class'=>'bs_switch'

,'style'=>'margin-bottom:4px;', 'id'=>'acischieftive']);

if ($model->hasAttribute('utente_maxiaffissioni')) {
    echo $form->field($model, 'utente_maxiaffissioni')->checkBox([
        'label' => 'Usa la nuova home con le card delle commesse',
        'data-size' => 'small',
        'class' => 'bs_switch',
        'style' => 'margin-bottom:4px;',
        'id' => 'utente-maxiaffissioni',
    ]);
}

echo <<<EOD
</div>
<div class="card-footer">
</div>
</div>
EOD;



}
;?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
