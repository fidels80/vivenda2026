<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnacliSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anaclis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anacli-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Anacli', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cd_cli',
            'Desk',
            'address',
            'localita',
            'cap',
            //'cd_nazione',
            //'PartitaIva',
            //'CodiceFiscale',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
