<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\Rep_publicazioniSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rep Publicazionis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rep-publicazioni-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Rep Publicazioni', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cd_cf',
            'cd_Art',
            'descrizione',
            'datacons',
            'Cd_DOSottoCommessa',
            //'Cd_DO',
            //'PrezzoUnitarioScontatoV',
            //'Qta',
            //'PrezzoTotaleE',
            //'Cd_ARMarca',
            //'Id_DORig',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
