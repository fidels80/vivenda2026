<?php

namespace app\modules\presenze;
use yii;
use yii\web\JsExpression;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\db\Query;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
 
use yii\grid\GridView;
use kartik\sortinput\SortableInput;
use yii\helpers\Url;
/**
 * Dintable module definition class
 */
class Module extends \yii\base\Module
{
    private $_assetsUrl;
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\presenze\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    public function setAssetsUrl($value)

    {
    
    $this->_assetsUrl=$value;
    
    }
    
    
    public function registerCss($file, $media='all')
    
    {
    
    $href = $this->getAssetsUrl().'/css/'.$file;
    
    return '<link rel="stylesheet" type="text/css" href="'.$href.'" media="'.$media.'" />';
    
    }
    public function registerJSS($file, $media='all')
    
    {
    
    $href = $this->getAssetsUrl().'/js/'.$file;
    
    //return '<script type="text/javascript" src='.$href.'" ></script>';
    
return $href;

    }
    public function registerImage($file)
    
    {
    
    return $this->getAssetsUrl().'/images/'.$file;
    
    }
    
    public function getAssetsUrl()
    
    {
    
    if($this->_assetsUrl===null)
    
    $this->_assetsUrl=str_replace('web','',Yii::$app->request->baseUrl).'modules/Presenze';
    //'/autoupdate/modules/autoupdate'; //Yii::$app->request->baseUrl;//Yii::$app->getAssetManager()->publish(Yii::getPathOfAlias('module.assets'));
    
    return $this->_assetsUrl;
    
    }
    public function Getfields($tab){

        $connection = Yii::$app->db;//get connection
        $dbSchema = $connection->schema;
        $fields = $dbSchema->getTableSchema($tab)->getColumnNames();
        $htm='';
        foreach($fields as $field)
        {
            $htm=$htm. ( $field). ',';
        }
      //  $htm=$htm.$fields[1].' as m,'.$fields[1].' as c ,'.$fields[1].' as d'; 
        return $htm;
           
    }


    public function Getpk($tab){

        $connection = Yii::$app->db;//get connection
        $dbSchema = $connection->schema;
        $pk= $dbSchema->getTableSchema($tab)->primaryKey[0];
       
        return $pk;
    }

    public function Getfk($tab){

        $connection = Yii::$app->db;//get connection
        $dbSchema = $connection->schema;
       // $pk= $dbSchema->getTableSchema($tab)->primaryKey[0];
        yii::warning("chiavi");
        $fk=$dbSchema->getTableSchema($tab)->foreignKeys;
       // yii::warning( $fk);
        return $fk;
    }

    




    public function  GetTab(){

        $connection = Yii::$app->db;//get connection
        $dbSchema = $connection->schema;
        //or $connection->getSchema();
        $tables = $dbSchema->getTableNames();//returns array of tbl schema's
        
        //Yii::warning($tables);
        $htm='';
        foreach($tables as $tbl)
        {
           // $htm=$htm. ( $tbl). '<br/>';

            $htm=$htm.   Html::a($tbl, ['/Dintable/dtab/doform', 'tab' => $tbl]);
            $htm=$htm.'<br/>';
           // return Html::a('modifica', ['/autoupdate/tblshop/update', 'id' => $data['id']]);
            //$x= Yii::$app->controller->module->Getfields($tbl) ;
          //  $htm=$htm.$x;
        }
        return $htm;
    }

public function getfieldspec($tab){

    $connection = Yii::$app->db;//get connection
  $command=$connection->createCommand(" SHOW COLUMNS FROM  ".$tab);
//$f2=$rows->getColumnType();
$rows = $command->queryAll();
    return $rows;
}



public function getfieldspecdeail($tab,$field){

    $connection = Yii::$app->db;//get connection
  $command=$connection->createCommand(" SHOW COLUMNS FROM  ".$tab.'  where Field=\''.$field.'\'');
//$f2=$rows->getColumnType();
$rows = $command->queryAll();
    return $rows;
}



public function getfieldcovert($field){
    
$t='';
$arr=explode("(", $field, 2);
$convert='';
$t=$arr[0];

switch ($t){

 /*case  "int":
   $conver='integer';
   break;
*/
case  "varchar":
    yii::warning('so stringa');
        $convert='string';
        
case  "datetime":
        $convert='date';
      
 case "Date":
    $convert='date';       
case  "bit":
        $convert='boolean';
     
case "float"  :
    $convert='double';      
   
case  "int":
      $convert='mimmo';
  
default:
    $convert='string';
 
}

if($t=='int'){
    $convert='integer';
}
/*if($t=='Date'){
    $convert='string';
}*/
$arrconvert =array();
array_push($arrconvert,$convert);
array_push($arrconvert,$this->getBetween($field,'(',')'));
yii::warning($arrconvert);
return  $arrconvert;



}


 public function getBetween($string, $start = "", $end = ""){
    if (strpos($string, $start)) { // required if $start not exist in $string
        $startCharCount = strpos($string, $start) + strlen($start);
        $firstSubStr = substr($string, $startCharCount, strlen($string));
        $endCharCount = strpos($firstSubStr, $end);
        if ($endCharCount == 0) {
            $endCharCount = strlen($firstSubStr);
        }
        return substr($firstSubStr, 0, $endCharCount);
    } else {
        return '';
    }
}



public function genselect($tab){
   
    $connection = Yii::$app->db;//get connection
 if (!empty($tab)){
    $command=$connection->createCommand(" select distinct id, description  from  ".$tab.' order by id asc');
  //$f2=$rows->getColumnType();
  $rows = $command->queryAll();
  //->asarray();
  if(!empty($rows)){
   $reftab=array();
  foreach($rows as $item){
$reftab[$item['id']]=$item['description'];
}
  return $reftab;
}else {
    return array('0'=>'Failed') ;
  }
 
}
else {
    return array('0'=>'Failed');
}
}


function search_array ( $array, $key, $value )
{
   $return = array();   
    foreach ($array as $k=>$subarray){  
      if (isset($subarray[$key]) && $subarray[$key] == $value) {
        $return[$k] = $subarray;
        return $return;
      } 
    }
     
}
}

