<?php
namespace app\modules\dintable\controllers;
use yii;
use yii\web\Controller;
use app\models\Model;
use yii\db\Query;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
   class DtabController extends Controller {
      public function actionGreet() {
         return $this->render('form');
      }
      public function actionDoform($tab)
      {
$fieldz=Yii::$app->controller->module->Getfields($tab);
    $pk=   Yii::$app->controller->module->Getpk($tab);
   $query = new Query;
        $query->select($fieldz)
    ->from($tab);
  //  ->orderBy($fieldz);
    Yii::warning($query);
$columns=[];
    foreach(explode(',',$fieldz) as $item){
      if (strlen($item)<>0){
      $data = [
         'label'=>$item,
        'attribute' => $item,
        'value' => $item
        ,'enableSorting' => true,
        'filter' => Html::input('string', $item)
            ];
      array_push($columns, $data);
   }
    }
  
  
    $model=new ActiveDataProvider([
'query'=>$query,'pagination' => false,])
;
$model->setSort([
   'attributes' => explode(',',$fieldz)]);




 
Yii::warning($model);
if (Yii::$app->user->isGuest) {
echo "non sei loggato";
}else {
 //  echo Yii::$app->controller->module->GetTab();; 

  return $this->render('index',[ 'model'=>$model,'tab'=> $tab,'fieldz'=>$fieldz,'columns' => $columns,'pk'=>$pk]);
}   
}



   public function actionEdit($tab,$pk,array $data,$recid) {
     
      $fieldz=Yii::$app->controller->module->Getfields($tab);
      $pk=   Yii::$app->controller->module->Getpk($tab);
      $query = new \yii\db\Query();
        $query->select($fieldz)
    ->from($tab)
    ->where([$pk=>$recid]);
    //yii::warning($pk);
   // yii::warning($recid);
    $command = $query->createCommand();
   $rows = $command->queryAll();
   // yii::warning($rows);
   $out='';
   $columns=[];
   $model=[];
   $model2= new \yii\base\DynamicModel([
   ]);
   
 foreach($rows as $item){
 foreach($item as $key => $value) {
  $model2->defineAttribute($key,$value); 
}
 }

 $model2->defineAttribute('tab',$tab); 
 $model2->defineAttribute('pk',$pk); 
//yii::warning($model2);




/*blocco <rules></rules>*/
$rules=Yii::$app->controller->module->getfieldspec($tab);
$fieldz2=Yii::$app->controller->module->getfieldspec($tab);
foreach($fieldz2 as $key => $value) {
 //  echo "kiave 1   ".$key ."   valore   ".'value'.'</br>';  
   foreach($value as $key2 => $value2) {
   //    echo "kiave  2  ".$key2 ."   valore   ".$value2.'</br>';  
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
  // yii::error('sono stringa'.$type);
   $z=Yii::$app->controller->module->getfieldcovert($type);
   if (str_contains($type,'varchar') ){

    //  yii::error('sono stringa');
      //yii::error($z);
      
   $model2->addRule($Field, $z[0],['max'=>$z[1]]);
   }
   
   elseif ( str_contains($type,'date')){
      $model2->addRule($Field, 'safe');

   }
   
   
   else
   {
      $model2->addRule($Field, $z[0]);
   

   }
//   echo 'addRule (\''.$Field.','.'\''.$z[0].'-'.$z[1] .'\')';
       }


 
return $this->render('edit',['model'=>$model,'model2'=>$model2,'pk'=>$pk,'tab'=>$tab,'fields'=>$fieldz,'out'=>$out,'data'=>$data]);
 
   }
  
  
  

   public function actionSavedata(){
     // if ($model2->load(Yii::$app->request->post())  ) {
     // print_r($form);
      //return $this->render('edit');
      $model= new \yii\base\DynamicModel([
      ]);
     //$model=[];
      $model->load(Yii::$app->request->post());
     // $model2->save();
      //print_R($model);
      //echo'</br>----</br>';
      //print_r($_POST);


      $tab=($_POST['DynamicModel']['tab']);
      $pk=($_POST['DynamicModel']['pk']);
      $raw_q='';
      $raw_q='update '.$tab.' set  ';
      $pk_val=0;
      foreach($_POST as $item){
        // print_R($item);
         //echo'</br>----</br>';

         if (is_array($item) ) {
            foreach($item as $key => $value) {
               if ($key<>'tab' && $key<>'pk' && $key<>$pk){
           //    echo ('campo '.$key.'     valore   =     '.$value.'</br>');
               $raw_q=$raw_q.'  '.$key.' = '.((is_numeric($value)) ? $value : '\''.$value.'\'').',';
               
              // echo $key .' ||';
               //echo gettype($value);
               //echo'</br>';
               }
               if ($key==$pk){
             //     echo ('<h1>il valore di where  è  '.$key.'     valore   =     '.$value.'</h1></br>');
              $pk_val = $value;

               }
          
            }
         }

      }
      $raw_q = rtrim($raw_q, ',');
      $raw_q=$raw_q. '     where  '.$pk.' =  '.$pk_val;
//echo $raw_q;  
$connection=Yii::$app->db;
$command=$connection->createCommand($raw_q);
$command->execute();
//return $this->render('doform' ,['tab' => $tab]);
return $this->redirect(['dtab/doform','tab' => $tab]);
   //}
   }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
   public function actionNewdata($tab,$pk){
      $fieldz=Yii::$app->controller->module->Getfields($tab);
     
      $model2= new \yii\base\DynamicModel([
      ]);
      $rows      = explode(",", $fieldz);
    foreach($rows as $item){
    //foreach($item as $key => $value) {
     $model2->defineAttribute($item ); 
   //}
    }
   
    $model2->defineAttribute('tab',$tab); 

/*blocco <rules></rules>*/
$rules=Yii::$app->controller->module->getfieldspec($tab);
$fieldz2=Yii::$app->controller->module->getfieldspec($tab);
foreach($fieldz2 as $key => $value) {
 //  echo "kiave 1   ".$key ."   valore   ".'value'.'</br>';  
   foreach($value as $key2 => $value2) {
   //    echo "kiave  2  ".$key2 ."   valore   ".$value2.'</br>';  
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
  
   if ($z[0]=='string'){
   $model2->addRule($Field, $z[0],['max'=>$z[1]]);
   
   }
   else
   {
      $model2->addRule($Field, $z[0]);
   

   }
//   echo 'addRule (\''.$Field.','.'\''.$z[0].'-'.$z[1] .'\')';
       }
     // ,['data'=>$data,'pk'=>$pk,'tab'=>$tab]
      return $this->render('new',['tab'=>$tab,'pk' =>$pk,'fields'=>$fieldz,'model2'=>$model2]);
   }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
   public function actionSavenewdata(){
       $model= new \yii\base\DynamicModel([
       ]);
       $model->load(Yii::$app->request->post());
    
 
       $tab=($_POST['DynamicModel']['tab']);
       $pk=   Yii::$app->controller->module->Getpk($tab);
       $raw_q='( select ';
       $raw_q1=' (';
       $raw_g='insert into  '.$tab.'     ';
       $pk_val=0;
       foreach($_POST as $item){
              if (is_array($item) ) {
             foreach($item as $key => $value) {
                if ($key<>'tab' && $key<>'pk' && $key<>$pk && empty($value)==false){
            
               
               $raw_q1=$raw_q1.$key.',';
               $raw_q=$raw_q.((is_numeric($value)) ? $value : '\''.$value.'\'').' as ' .$key.',';
           
                }
                
           
             }
          }
 
       }
       $raw_q = rtrim($raw_q, ',');
       $raw_q1 = rtrim($raw_q1, ',');
       $raw_q=$raw_q.')';
       $raw_q1=$raw_q1.')';
 
$allrwasql=$raw_g.$raw_q1.$raw_q;
 $connection=Yii::$app->db;
 $command=$connection->createCommand($allrwasql);
 $command->execute();
 return $this->redirect(['dtab/doform','tab' => $tab]);
    }
  
  
  
  
  
   public function actionDel($tab,$pk,/*array $data*/$recid ) {

      $connection=Yii::$app->db;
      $command=$connection->createCommand('delete from '.$tab.' where '.$pk.'='.$recid);
      $command->execute();
      //return $this->render('doform' ,['tab' => $tab]);
      return $this->redirect(['dtab/doform','tab' => $tab]);
   }
      
   }
?>