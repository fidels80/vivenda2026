<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BlkinsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blkins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blkins-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Blkins', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'CC_CLIENTE',
            'agente',
            'Tipo_evento',
            'importato',
            //'Codice_progetto',
            //'descrizione',
            //'note',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
