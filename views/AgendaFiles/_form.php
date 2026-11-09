<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* @var $this yii\web\View */
/* @var $model app\models\AgendaFiles */
/* @var $form yii\widgets\ActiveForm */
 
$request = Yii::$app->request;

$get = $request->get();
if(!empty($get)){
  //  yii::error($get);
}
if (array_key_exists('idagenda', $get)) {
$fid=$get['idagenda'];
}else{
$fid=null;

}
//yii::error($get);
//var_dump($get);
//echo $get['idagenda'];
//$request->get('idagenda');
?>

<div class="agenda-files-form">




    <?php echo 'asdsadassdasdasdasd';
    $form = ActiveForm::begin(); ?>

    <?php //$form->field($model, 'id')->textInput() ?>

    <?=
   
    
      $form->field($model, 'id_agenda')->textInput(['disabled' => false,
     
    
   
     'value'=>$fid])
    
     
    ?>

    <?= $form->field($model, 'descrizione')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nota')->textInput() ?>

    <?php //echo $form->field($model, 'f_content')->textInput() ?>

    <?php //echo $form->field($model, 'nome_file')->textInput() ?>

    <?php  //echo $form->field($model, 'estenzione')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'file')->fileInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
