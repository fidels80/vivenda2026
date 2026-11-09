<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView as kgrid;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\db\Query;
use kartik\date\DatePicker;
use kartik\select2\Select2;
$tfields=explode(",", $fields);
//print_r( $tfields);
$reftab=[];
$fks=Yii::$app->controller->module->Getfk($tab);
if(!empty($fks)){

foreach($fks as $item){
   if (is_array($item) ) {
      foreach($item as $key => $value) {
if ($key===0){
  $ftab=$value;
}else
{
$cfield=$key;
$ffield=$value;
}
      }
      array_push($reftab, array('ftab'=>$ftab,'cfield'=>$cfield,'ffield'=>$ffield));
 
   }

}

}

?>

<?php
echo '<h1> updating '.$tab.'</h1>';

?>
<?php $form = ActiveForm::begin([
  'method' => 'post',
  'action' => ['savedata']]); ?>
<?php

  foreach(explode(',',$fields) as $item){
    if (strlen($item)<>0){
  
  if($item==$pk){
    echo $form->field($model2, $item)->textInput(['readonly'=> true]);
  }
elseif (!empty(Yii::$app->controller->module->search_array($reftab, 'cfield', $item))){
$d=Yii::$app->controller->module->search_array($reftab, 'cfield', $item);
foreach($d as $item2){
  if (is_array($item2) ) {
    foreach($item2 as $key => $value) {
      if($key=='ftab'){
        $gensel=$value;
        echo $gensel;
      }
    }
  }

}
//$gensel=$ftab[0]['ftab'];


//yii::warning('cane'.$cane.'item'.$item);
$tmparr=Yii::$app->controller->module->genselect($gensel);
//$listdatap= ArrayHelper::map($tmparr,'id','descritpion');
yii::warning($tmparr);
try {
     echo $form->field($model2, $item)->widget(Select2::classname(), ['data' => $tmparr,
  'options' => ['placeholder' => 'Seleziona valore ...',],
  'pluginOptions' => [
      'allowClear' => true
  ],
]);}catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
  echo $form->field($model2, $item)->textInput();
}


}

  else{
  // print_r( Yii::$app->controller->module->search_array($reftab, 'cfield', $item));
    $arr=Yii::$app->controller->module->getfieldspecdeail($tab,$item);
    yii::warning($arr);
    $arr2='';
    if (str_contains($arr[0]['Type'],'char')|| str_contains($arr[0]['Type'],'int')){
    echo $form->field($model2, $item)->textInput();
    }
    elseif(str_contains($arr[0]['Type'],'bit')) {

      echo $form->field($model2, $item)->checkbox();

    }
  elseif(str_contains($arr[0]['Type'],'date') ) {
//yii::warning($model2);
    echo $form->field($model2, $item)->widget(DatePicker::classname(), [
      'options' => ['placeholder' => 'Enter   date ...'],
      'pluginOptions' => [
          'autoclose'=>true,
          'format'=>'yyyy-mm-dd'
      ]
  ]);

  }
  else {
    echo $form->field($model2, $item)->textInput();
  }
  }
  
  }
  }
   echo $form->field($model2, 'tab')->textInput()->hiddenInput()->label(false);
   echo $form->field($model2, 'pk')->textInput()->hiddenInput()->label(false);
?>

<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>