<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\TblBrand;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-group-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            'desk',
          [
                'attribute'=>'brand_id',
                'label'=>'Azienda',
                'filter'=>ArrayHelper::map(TblBrand::find()->asArray()->all(), 'id', 'desk'),//array("M"=>"M","F"=>"F"), // you can read from database directly
                'value' => function ($data) {
        $tmp=TblBrand::find() ->where(['id'=>$data['brand_id']]) ->one();       
        return $tmp->desk;
                }
            ],
            'grp_path',
               [
                    'label'=>'Forza Download',
                        'format' => 'raw',
                    'value' => function($data) {
                        return Html::a('applica', ['tblgroup/forzadown', 'idgrp' => $data['id']]);
                    }
                ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
