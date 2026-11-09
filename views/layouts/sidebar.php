<?php 

use app\models\xm;
use app\mpdel\site;
use yii\helpers;
use yii\helpers\Url;

//$x=new  site->Bleft();
\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$publishedRes = Yii::$app->assetManager->publish('@vendor/hail812/yii2-adminlte3/src/web/js');
$this->registerJsFile($publishedRes[1].'/control_sidebar.js', 
['depends' => '\hail812\adminlte3\assets\AdminLteAsset']);

$x=Yii::$app->runAction('site/bleft');
//yii::warning($x);
$usrid = Yii::$app->user->Id;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['sidebar_color','file','lastlogin'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}
$usrgrid = $ris['sidebar_color'];
//yii::warning($usrid);
?>

<style>
/*.main-sidebar, .main-sidebar::before {
  width: 200px;
}
body:not(.sidebar-mini-md) .content-wrapper, body:not(.sidebar-mini-md) .main-footer,
body:not(.sidebar-mini-md) .main-header {
  margin-left: 200px;
}

.sidebar-collapse .main-sidebar, .sidebar-collapse .main-sidebar::before {
  margin-left: 0px;
}
*/
</style>

<?php echo '<aside class="main-sidebar sidebar-dark-primary bg-'.$usrgrid.' elevation-3 ">'; ?>
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?php  echo Yii::getAlias('@web').'/uploads/logo.png'?>" 
        alt="Vivenda Logo" class=" img-circle elevation-3" width="50" height="50" style="opacity: .8">
        <span class="brand-text font-weight-light">Vivenda</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar layout-navbar-fixed ">
        <!-- Sidebar
        <img src="<?=$assetDir?>/img/user2-160x160.jpg" 
                class="img-circle elevation-2" alt="User Image">

        user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
         <?php
//echo
//'<img src="../web/uploads/' . $model->id . '_' . str_replace(' ', '_', $model->file) . 
//'"  class="img-circle elevation-2" alt="User Image" width="50" height="50"';
       
  //          ?>
            

<img src="<?php
if (!empty($ris['file'])){
echo Yii::getAlias('@web').'/uploads/'.$usrid . '_' . str_replace(' ', '_', $ris['file']);
}else {
    echo $assetDir.'/img/user2-160x160.jpg';
}
?>" 
             
                 alt="User Image">
            </div>
            <div class="info">
                <a href="<?=Url::toRoute(['/user/update', 'id' => Yii::$app->user->id])?>
                " class="d-block"><?php echo \yii\helpers\Html::encode( 
                   Yii::$app->user->identity->username) ?>
                 <!--    <br>
                    Ultimo Acceso:<br><?php echo date_format(date_create($ris['lastlogin']),"d/m/Y H:i") ?> -->   
        </a></div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' =>$x/* [
                    [
                        'label' => 'Starter Pages',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info">3</span>',
                        'items' => [
                            ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
                            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
                            ['label' => 'Inactivgesasdase Page', 'iconStyle' => 'far'],
                        ]
                    ],
                    ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                    ['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                    ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
                    ['label' => 'Level1'],
                    [
                        'label' => 'Level1',
                        'items' => [
                            ['label' => 'Level2', 'iconStyle' => 'far'],
                            [
                                'label' => 'Level2',
                                'iconStyle' => 'far',
                                'items' => [
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
                                ]
                            ],
                            ['label' => 'Level2', 'iconStyle' => 'far']
                        ]
                    ],
                    ['label' => 'Level1'],
                    ['label' => 'LABELS', 'header' => true],
                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                
                
                $x ,
                
                    ['label'=>'stocazzo','url'=>'/locazioni','target'=>'_blank']
            ],*/,
        
            ]);
            ?>
         
    </nav>
        <!-- /.sidebar-menu -->
        
    </div>
    <!-- /.sidebar -->

</aside>

    