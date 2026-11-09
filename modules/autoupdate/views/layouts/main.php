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

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="'.Yii::$app->homeUrl.'images/logo.png" style="display:inline; vertical-align: top; height:32px;">Tecneo', //Html::img('@web/images/logo.png', ['alt'=>Yii::$app->name]),//'TECNEO',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
  /*  $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    
   * */
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'collegati', 'url' => ['/site/login']];
    echo Nav::widget([
      //  'brandlabel' => Html::img('@web/images/logo.png', ['alt'=>Yii::$app->name]),
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
        
    } 
    else {
                $xm = xmenu::find()->where(//[''=>\Yii::$app->user->identity->level])
        ['<=', 'level', \Yii::$app->user->identity->level])
        ->all();
        $testm[]=['label'=>'Benvenuto '.\Yii::$app->user->identity->username, 'url'=>''];         
        $mainmenu =$xm;// \common\models\Menu::find()->all();
         foreach ($mainmenu as $data)
      {
        $xsm= Xsubmenu::find()->where(['=', 'id_menu', $data->id])
        ->all();
           if (count($xsm)>0){         
        foreach ($xsm as $datas)
      {
       $url=[0=>$datas->url];
       $sbmenu[]=['label'=>$datas->voce,'url'=>$url];
      }
       $testm[]=['label'=>$data->voce,'items'=>$sbmenu];
       unset($sbmenu); 
     
      }
      else {
           $url=[0=>$data->url];
      $testm[]=['label'=>$data->voce,'url'=>$url];
      //array_merge($a, $b);
      }     
      }
                $testm[] = 
        $menuItems[] =  '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'; 
      
              
                  
      
     
  //   Yii::warning($menuItems);
    echo Nav::widget([
      //  'brandlabel' => Html::img('@web/images/logo.png', ['alt'=>Yii::$app->name]),
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $testm,
    ]);
    NavBar::end();
     }
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
