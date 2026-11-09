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
$fieldz=Yii::$app->controller->module->Getfields($tab);
$fieldz2=Yii::$app->controller->module->getfieldspec($tab);
$tfields=explode(",", $fields);
$pk=   Yii::$app->controller->module->Getpk($tab);
foreach($fieldz2 as $key => $value) {
//echo "kiave 1   ".$key ."   valore   ".'value'.'</br>';  
foreach($value as $key2 => $value2) {
 //   echo "kiave  2  ".$key2 ."   valore   ".$value2.'</br>';  
switch($key2){
case 'Field':
            $Field=$value2;
case 'Type':
            $type=$value2;
case 'Null':
            $Anull=$value2;
}

    // addRule(['name', 'email'], 'string', ['max' => 128])
}
$z=Yii::$app->controller->module->getfieldcovert($type);
//print_R($z);
//echo '</br>';
//echo 'addRule (\''.$Field.','.'\''.$z[0].'-'.$z[1] .'\')';
//echo '</br>';
//echo '</br>';
    }
   // }
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


<?php $form = ActiveForm::begin([
  'method' => 'post',
  'action' => ['savenewdata']]); ?>
<?php
//print_r($out);
//print_r($tfields);
/*
foreach($model as $key => $value) {
    if (strlen($value)>0){
    echo'  <label for="'.$key.'">'.$key.'</label><br>
      <input type="text" id="'.$key.'" name="{$key}" value="'.$value.'"><br>';

 }
  }
  //foreach($model->attributes as $attribute => $value) {
    // do your stuff here
   // print_r($attribute);
 //}

 foreach($model as $attribute => $value) {
  // do your stuff here
  print_r($value);
  echo '</br>';

}
*/
 
//echo $form->field($model, 'TotaleContanti')->textInput();
  foreach(explode(',',$fields) as $item){
    if (strlen($item)<>0){
  
  if($item==$pk){
    echo $form->field($model2, $item)->hiddenInput()->label(false);
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
      echo $form->field($model2, $item)->textInput();
  }
  
  }
  }
 // echo $form->field($model2, $key)->textInput();
 //echo'  <label for="'.$key.'">'.$key.'</label><br>
   //   <input type="text" id="'.$key.'" name="'.$key.'" value="'.$value.'"><br>';
   echo $form->field($model2, 'tab')->textInput()->hiddenInput()->label(false);
  // echo $form->field($model2, 'pk')->textInput()->hiddenInput()->label(false);
?>

<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>