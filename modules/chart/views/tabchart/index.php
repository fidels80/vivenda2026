<?php 
 use yii\helpers\Html;
 use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView as kgrid;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;




$js= Yii::$app->controller->module->registerJSS('scripts.js'); 
     $this->registerJsFile($js);  
     $rows=[];
     $connection = Yii::$app->db;//get connection
if ($type==null){  
     $command=$connection->createCommand(" select * from  ".$tab);
   //$f2=$rows->getColumnType();
}
else{
 // $decryption_iv = '1234567891011121';
 // $ciphering = "AES-128-CTR";
//  $iv_length = openssl_cipher_iv_length($ciphering);
//$options = 0;
// Store the decryption key
//$decryption_key = "tecneosrl";
  
// Use openssl_decrypt() function to decrypt the data
//$decryption=openssl_decrypt ($tab, $ciphering, 
//        $decryption_key, $options, $decryption_iv);
  
// Display the decrypted string
$decryption=Yii::$app->controller->module->decripta($tab);
//echo "Decrypted String: " . $decryption;
$command=$connection->createCommand( $decryption);

//  
}
try {
  
  $rows = $command->queryAll();
} catch (Exception $e) {
  $rows= ['Caught exception: '];
  array_push($rows,  $e->getMessage());
  echo 'Caught exception: '.$e->getMessage();
}
  $jchart= json_encode( $rows );

//echo $tab;
//print_R( $pk);

 //echo $jchart;
$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($rows));
fclose($fp);

?>
<div id="pivotContainer">The component will appear here</div>
<script src="https://cdn.flexmonster.com/flexmonster.js"></script>

<script>
     jsonData=<?=json_encode( $rows )?>;
    var pivot = new Flexmonster({
        container: "pivotContainer",
        componentFolder: "https://cdn.flexmonster.com/",
        toolbar: true,
        report: {
        dataSource: {
	        data: jsonData
	    },
        options: {
      grid: {
        type: "flat"
      },
      configuratorActive: false,
      "filters": {
    "string": {
        "members": true,
        "query": ["equal", "not_equal"],
        "valueQuery": ["top", "bottom"]
    }
}
    }
       
    }
    });
</script>
 