<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
 //use yii\grid\GridView;
 
//use app\model\Site;
use app\models\user;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$usrid = Yii::$app->user->Id;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['grid_color'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}
$usrgrid = $ris['grid_color'];

yii::warning($usrgrid);
$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
   </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'filterUrl' => ['Doc_headSearch[cd_doc]',
        //'cd_doc' => 'orc'],
        'autoXlFormat'=>true,
    'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],
    
    'export'=>[
        'showConfirmAlert'=>false,
        'target'=>GridView::TARGET_BLANK
    ],

        'columns' => [
                     [
                'attribute'=>'id',
                 'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white'],
                'label' => 'id',
                'width'=>'200px',],
                  [
                'attribute'=>'userid',
                 'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white'],
                'label' => 'userid',
                'width'=>'200px',],
               [
                'attribute'=>'operazione',
                 'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white'],
                'label' => 'Operazione',
                'width'=>'200px',],
            [
                'attribute'=>'valore',
                 'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white'],
                'label' => 'Valore',
                'width'=>'200px',
                'format'=>'raw',
                'value'=>function ($model, $key, $index, $widget) {
                // return json_encode($model->valore, JSON_PRETTY_PRINT);
                //$js=json_decode($model->valore);
                return json_encode($model->valore,JSON_PRETTY_PRINT);
                //return   json_encode($model->valore ,JSON_PRETTY_PRINT);
                },
              ],

[
                'attribute'=>'old_valore',
                 'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white'],
                'label' => 'Oldvalore',
                'value'=>function ($model, $key, $index, $widget) {
                  // return json_encode($model->valore, JSON_PRETTY_PRINT);
                  //$js=json_decode($model->valore);
                  return json_encode($model->old_valore,JSON_PRETTY_PRINT);
                  //return   json_encode($model->valore ,JSON_PRETTY_PRINT);
                  },
                'width'=>'200px',]


    ,[
                'attribute'=>'timeins',
                 'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white'],
                'label' => 'Timeins', 
                'width'=>'200px',
                'options' => [
                    'format' => 'DD-MM-YYYY',
                    ],        
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([       
                  'attribute' => 'data',
                    'language' => 'it',
                  'presetDropdown' => true,
                  'convertFormat' => false,
                  'pluginOptions' => [
                    'separator' => ' - ',
                    'language' => 'it',
                    'format' => 'DD-MM-YYYY',
                    'locale' => [
                          'format' => 'DD-MM-YYYY'
                      ],
                      'ranges'=> [
 'Oggi' => ["moment().startOf('day')", "moment().add(1,'year').startOf('day')"],
 'Ultimo anno' => ["moment().startOf('day').subtract(1,'year')", "moment().startOf('day')"],
 'Ultimo mese' => ["moment().startOf('day').subtract(29, 'days')", "moment().endOf('day')"],
 'Prossimi 30 gg' => ["moment().endOf('day')", "moment().endOf('day').add(30, 'days')"],
 'Mese in Corso' => ["moment().startOf('month')", "moment().endOf('month')"],
 'Mese Passato' => ["moment().subtract(1, 'month').startOf('month')", "moment().subtract(1, 'month').endOf('month')"],
 'Tutto il prossimo mese' => ["moment().add(1, 'month').startOf('month')", "moment().add(1, 'month').endOf('month')"]
]
                  ],
                  'pluginEvents' => [
                    "apply.daterangepicker" => "function() { apply_filter('only_date') }",
                  ],
                ])
              ],    ['class' =>'yii\grid\ActionColumn',
            'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white'],
            'template'=>'{view}'],

        ]
]); ?>


</div>
