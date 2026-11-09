<?php

namespace app\modules\chart;
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
    public $controllerNamespace = 'app\modules\chart\controllers';

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
    
    $this->_assetsUrl=str_replace('web','',Yii::$app->request->baseUrl).'modules/chart';
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

            $htm=$htm.   Html::a($tbl, ['/Chart/tabchart/dochart', 'tab' => $tbl]);
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


public function cripta($simple_string){

   // $simple_string ="SELECT tbl_brand.code AS azienda,tbl_brand.desk AS az_desk,tbl_shop.code AS negozio,tbl_shop.desk AS negozio_desk from tbl_shop LEFT JOIN tbl_brand ON tbl_brand.id=brand_id";
    // Display the original string
    // Store the cipher method
    $ciphering = "AES-128-CTR";
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    // Non-NULL Initialization Vector for encryption
    $encryption_iv = '1234567891011121';
    // Store the encryption key
    $encryption_key = "tecneosrl";
    // Use openssl_encrypt() function to encrypt the data
    $encryption = openssl_encrypt($simple_string, $ciphering,
                $encryption_key, $options, $encryption_iv);
                return $encryption;

}
public function decripta($simple_string){

    $decryption_iv = '1234567891011121';
   $ciphering = "AES-128-CTR";
   $iv_length = openssl_cipher_iv_length($ciphering);
 $options = 0;
 // Store the decryption key
 $decryption_key = "tecneosrl";
   
 // Use openssl_decrypt() function to decrypt the data
 $decryption=openssl_decrypt ($simple_string, $ciphering, 
         $decryption_key, $options, $decryption_iv);
   
 // Display the decrypted string
 return  $decryption;

}
}

