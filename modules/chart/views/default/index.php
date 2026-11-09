<div class="Dintable-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
<script>
function eseguiq(){
var f =document.getElementById("query").value ; 
console.log(f);
var c="<?=Yii::$app->request->url ?>/tabchart/cripta";
var d="<?=Yii::$app->request->url ?>/tabchart/";

var dd="<?=Yii::$app->request->url ?>/tabchart/decripta";
$.get(c, {simple_string: f  }, function (data) {
console.log(data);
 en=data;
pippo='';
$('#resp3').append(en);
k=$.get(dd,{simple_string:en},function(data){
   // console.log(data);
   $('#resp2').append(data);

});
console.log(k);

h ="<a href="+d+"dochart&tab="+en+"&type=raw>test</a>";
//+"&tab="+en+"&type=1"">linkgenerato</a>";http://localhost/autoupdate/web/index.php?r=Chart%2Ftabchart%2Fdochart&tab=rel_usr_form_action
$('#resp').append(h);
});
                                                       

}
    </script>




 
 


<input  id='query' class="form-control mr-sm-2" name="query" type="text" placeholder="query"
    aria-label="query">
   
</Br>
<button class="btn btn-outline-success my-2 my-sm-0" onclick="eseguiq();" >Squera</button>
<button onclick="resetsq();" class="btn btn-outline-secondary ml-2">RESET</button>
</br>
</br>
<div id="resp"></div>
<div id="resp2"></div>
<div id="resp3"></div>
</br>
<?php 
use yii\helpers\Html;
$simple_string ="SELECT tbl_brand.code AS azienda,tbl_brand.desk AS az_desk,tbl_shop.code AS negozio,tbl_shop.desk AS negozio_desk from
 tbl_shop LEFT JOIN tbl_brand ON tbl_brand.id=brand_id";
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
            echo $encryption;
            echo '</br>';
            echo '</br>'; echo '</br>';
            echo '</br>';
echo Html::a('query1', ['/Chart/tabchart/dochart', 'tab' => $encryption

,'type'=>'raw']);?>

</br>

<?php 
$js= Yii::$app->controller->module->registerJSS('scripts.js'); 
$this->registerJsFile($js); 
 
  echo Yii::$app->request->url;
 if (Yii::$app->user->isGuest) {

 }else {
     echo Html::a('tabulars', ['/chart/dochart' ]);
    echo '</br>';
    echo '</br>';
    echo '</br>';
    echo '</br>';
    echo '</br>';
    echo Yii::$app->controller->module->GetTab();; 

//echo GetTab();
echo '</br>';
echo '</br>';
echo '</br>';
echo '</br>';
$simple_string ="SELECT tbl_brand.code AS azienda,tbl_brand.desk AS az_desk,tbl_shop.code AS negozio,tbl_shop.desk AS negozio_desk from tbl_shop LEFT JOIN tbl_brand ON tbl_brand.id=brand_id";
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
/*$encryption = openssl_encrypt($simple_string, $ciphering,
            $encryption_key, $options, $encryption_iv);
*/
$encryption_key=Yii::$app->controller->module->cripta($simple_string);


echo Html::a('queryaa', ['/Chart/tabchart/dochart', 'tab' => $encryption

,'type'=>'raw']);
 }
 
?>

