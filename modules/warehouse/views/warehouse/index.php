<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\WhStoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wh Stores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wh-stores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Wh Stores', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            'desk',
            'address',
            'city',
            //'zone',
            //'nation',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
