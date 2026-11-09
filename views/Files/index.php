<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="files-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Files', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nome',
            'file',

            [
                'attribute'=>'file test ',
                'label'=>'link ai file',
               'value' => function ($data) {
               
            if (isset($data['file'])){
    
             return Html::a('scarica',['files/download','id' => $data->id,'file'=>$data->file ]);


                }else{
                return 'nessun file salvato';}
            },
            'format' => 'html',  
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

     

</div>
