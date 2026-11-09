<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    
  <?php if (Yii::$app->session->hasFlash('limitutenti')): ?>

        <div class="alert alert-danger">
    SUPERATO Il LIMITE MASSIMO DI UTENTI ATTIVABILI!!!!!!
        </div>
   <?php endif;?>



   <?php  
   $usrid = Yii::$app->user->Id;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['level', 'cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
};
     if ($ris['level']==100){ 
    echo  Html::a('Create User', ['create'], ['class' => 'btn btn-success'])  ;
      }; 
      ?>
    
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'level',
   
            'cd_cli',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
