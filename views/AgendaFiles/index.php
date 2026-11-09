<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AgendafilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agenda Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-files-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Agenda Files', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_agenda',
            'descrizione',
            'nota',
            //'f_content',
            'nome_file',
            'estenzione',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
