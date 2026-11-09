
<script language="javascript"> 
/*function hidebtl() {
document.getElementById("openlmenu").style.display="none";
document.getElementById("btnmenu").style.display="none";
}
function DoPost(){
   $.post("/autoupdate/web/index.php?r=site%2Flogout"    );  //Your values here..

}
function openNav() {
  document.getElementById("mySidenav").style.width = "200px";
  document.getElementById("openlmenu").style.display="none";
document.getElementById("btnmenu").style.display="none";
}

/* Set the width of the side navigation to 0 */
/*function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("openlmenu").style.display="block";
document.getElementById("btnmenu").style.display="block";
}
*/
</script>


<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\xmenu;
use app\models\User;
use app\models\Xsubmenu;
use kartik\sidenav\SideNav;
AppAsset::register($this);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no"">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body onload="hidebtl();" >
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
     echo Yii::$app->controller->module->registerCss('module.css'); 
     Yii::warning(str_replace('web','',Yii::$app->request->baseUrl).'modules/Warehouse');
     $js= Yii::$app->controller->module->registerJSS('scripts.js'); 
     $this->registerJsFile($js);  
    
       ?>


<div id= 'mySidenav', class="sidebar">
 <?php  
$testm2[]=['label'=>'Home  ' , 'url'=>Yii::$app->request->baseUrl.'/index.php?r=Warehouse','icon' => 'home'];
if (Yii::$app->user->isGuest) {
    $testm2[] = ['label' => 'Signup', 'url' => ['/site/signup'],'icon' => 'home'];
    $testm2[] = ['label' => 'collegati', 'url' => ['/site/login'],'icon' => 'home'];
} 

else {
  $xm = xmenu::find()->andWhere(//[''=>\Yii::$app->user->identity->level])
        ['<=', 'level', \Yii::$app->user->identity->level])
        ->andWhere(['like','voce','Ware'])
        ->all();
  $testm2[]=['label'=>'Benvenuto '.\Yii::$app->user->identity->username, 'url'=>Yii::$app->request->baseUrl
  //str_replace('web','',Yii::$app->request->baseUrl)
  .'/index.php?r=Warehouse','icon' => 'user' ];         
  $mainmenu2 =$xm;// \common\models\Menu::find()->all();
   foreach ($mainmenu2 as $data)
{
  $xsm= Xsubmenu::find()->where(['=', 'id_menu', $data->id])
  ->all();
     if (count($xsm)>0){         
  foreach ($xsm as $datas)
{
 $url=[0=>$datas->url];
   if (strpos(json_encode($url), "Warehouse") !== false){
 $sbmenu[]=['label'=>$datas->voce,'url'=>$url,'icon' => 'wrench' ];
 }else
 {
    $sbmenu[]=['label'=>$datas->voce,'url'=>$url,'icon' => 'chevron-left' ];

 }
}
 $testm2[]=['label'=>$data->voce,'items'=>$sbmenu,'icon' => 'record' ];
 unset($sbmenu); 

}
else {
     $url=[0=>$data->url];
$testm2[]=['label'=>$data->voce,'url'=>$url,'icon' => 'wrench' ];
//array_merge($a, $b);
}     
}
//$testm2[]=['label' => Html::a('LOG OUT' ,['/site/logout'],['data-method' => 'post']),'icon' => 'cloud' ];
$testm2[]=['label' =>  'LOG OUT' ,'url'=> "javascript:DoPost()",'icon' => 'cloud'  ];
$testm2[]=['url'=>"javascript:closeNav()"  ,'label' =>  'Chiudi Menu','icon'=>'arrow-left'] ;
/*['label'=>'esci','url'=> [ 
  Html::beginForm(['/site/logout'], 'post')
. Html::submitButton(
    'Logout (' . Yii::$app->user->identity->username . ')',
    ['class' => 'btn btn-link logout']
)
. Html::endForm()
],'icon' => 'cloud'];*/
  
  
}
  echo SideNav::widget([
	'type' => SideNav::TYPE_DEFAULT,
	'heading' => ' ',
   'indItem' => '',
	'items' => $testm2
]);?>
</div>

<div  class="container">
 <div id='btnmenu'>
<button id='openlmenu'  class="btn btn-success"  onclick="openNav()" width=0><i class="glyphicon glyphicon-eject"></i>  Apri Menu Laterale</button>
        <?php  /* echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'class' => 'mainbody',
        ]) */?>
</div>


<!-- div class="mainbody"-->
        <?php  if (Yii::$app->user->isGuest) {
echo '<H1>non sei registrato</H1>';
          }else  { 
               echo $content;
           }?>
    <!--T/div-->
</div>

<footer class="tfooter">
    <div class="container">
        <p class="pull-top">&copy; My Company <?= date('Y') ?></p>

        
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
