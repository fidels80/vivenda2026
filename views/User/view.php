<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
         </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        //    'id',
            'username',
       //     'auth_key',
        //    'password_hash',
         //   'password_reset_token',
            'email:email',
      //      'status',
           // 'created_at',
           // 'updated_at',
            'level',
            'utente_maxiaffissioni:boolean',
            'grid_color','sidebar_color','file'
        ],
    ]) ?>
    <?php /*echo 'test';
    echo $model->password_hash;
    echo $model->auth_key;
    echo Yii::$app->getSecurity()->decryptByPassword
            ($model->password_hash,$model->auth_key);*/?>

</div>
