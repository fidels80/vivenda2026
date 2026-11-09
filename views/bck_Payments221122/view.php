<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\doc_head;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */

$this->title ='Scadenza  Num ' .$model->NumFattura;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        
       // yii::warning($model->gethead());
         
        // Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /* Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
           // 'xid_testa',
           // 'cd_cli',
            'Cd_PG',
            'DataScadenza',
            'DataPagamento',
            'DataFattura',
        //    'NumFattura',
   ['attribute'=>'NumFattura',
   'format'=>'raw',
    'value'=>function ($model, $key) {

$doc=doc_head::find()->where(['xid_testa' => 
$model->xid_testa
])
    //->andWhere(['cd_cli_dest'=>$model->dest])
    ->asArray()
    ->one();
        yii::warning($doc);
        return  Html::a($model->NumFattura, ['doc_head/view', 'id' => $doc['id']]);
      //  return $model->NumFattura;
        
    }],

            'Protocollo',
            'Pagata',
            'NumEffetto',
            'TotEffetti',
            'ImportoV',
            'IncassoV',
        ],
    ]) ?>

</div>
