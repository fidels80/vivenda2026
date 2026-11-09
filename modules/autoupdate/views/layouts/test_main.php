<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\app;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\xmenu;
use app\models\User;
use app\models\Xsubmenu;
//$livello=User::findIdentity(Yii::app()->user->id);
//echo $livello->Livello;

    //var_dump($l);
//var_dump($xm);
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
        'brandLabel' => 'Tecneo',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
   /* $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];*/
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems//$menuItems,
    ]);

        } else 
        {
        $xm = xmenu::find()->where(//[''=>\Yii::$app->user->identity->level])
        ['<=', 'level', \Yii::$app->user->identity->level])
        ->all();
    
//     $menuItems[] = ['label' => 'test', 'items'=> [
    
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
       unset($submenu);
       yii::warning($submenu);
      }else {
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
      
   //  $menuItems[] = ['label' => 'test', 'items'=> $testm];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $testm//$menuItems,
    ]);
    }

    NavBar::end();
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
        <p class="pull-left">&copy; Tecneo<?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
