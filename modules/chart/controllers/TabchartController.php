<?php
namespace app\modules\chart\controllers;
use yii;
use yii\web\Controller;
use app\models\Model;
use yii\db\Query;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
   class TabchartController extends Controller {
      public function actionGreet() {
         return $this->render('form');
      }
 


public function actionDochart($tab,$type= null){


   return $this->render('index',['tab'=> $tab,'type'=>$type]);//,
//   [ 'model'=>$model,'tab'=> $tab,'fieldz'=>$fieldz,'columns' => $columns,'pk'=>$pk]


}
public function actionCripta($simple_string){

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
   return urlencode($encryption);

}

public function actionDecripta($simple_string){

    $decryption_iv = '1234567891011121';
   $ciphering = "AES-128-CTR";
   $iv_length = openssl_cipher_iv_length($ciphering);
 $options = 0;
 // Store the decryption key
 $decryption_key = "tecneosrl";
   
 // Use openssl_decrypt() function to decrypt the data
 $decryption=openssl_decrypt (urldecode($simple_string), $ciphering, 
         $decryption_key, $options, $decryption_iv);
   
 // Display the decrypted string
 return  $decryption;

}
      
   }
?>