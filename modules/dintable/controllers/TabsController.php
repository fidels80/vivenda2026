<?php
namespace app\modules\dintable\controllers;
use yii;
use yii\web\Controller;
use app\models\Model;
use yii\db\Query;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
   class TabsController extends Controller {
      public function actionTab() {
         return $this->render('index');
      }
  


    public function Doform($tab)
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

return  [ 'model'=>$model,'tab'=> $tab,'fieldz'=>$fieldz,'columns' => $columns,'pk'=>$pk];
}   
}
}
      ?>