<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblBrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'aziende';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-brand-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Brand', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php
    
    $searchModel = $dataProvider->search(Yii::$app->request->queryParams);
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $dataProvider->search(Yii::$app->request->queryParams),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            'desk',
            'defa_path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
