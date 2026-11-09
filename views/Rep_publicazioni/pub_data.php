<?php

use yii\helpers\Html;
 
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\user;
//use app\model\Site;
 
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use app\models\doc_rows;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel app\models\Rep_publicazioniSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$usrid = Yii::$app->user->Id;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['grid_color', 'cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}
$usrgrid = $ris['grid_color'];


if ($cf<>'C000065'){
    $elart = (new yii\db\Query())
    ->select(['cd_art'])

    ->from('doc_rows')
    ->where(['cd_cli' => $ris['cd_cli']])
    //->orwhere(['altcli' => $ris['cd_cli']])
    ->distinct()
    ->all();
    }else {
 
        
 
        $elart = (new yii\db\Query())
    ->select(['cd_art'])

    ->from('doc_rows')
    ->where(['cd_cli' => $ris['cd_cli']])
    ->andWhere(['<>','cd_doc','OVC'])
    //->orwhere(['altcli' => $ris['cd_cli']])
    ->distinct()
    ->all();

    }




$elecommesse=(
new yii\db\Query())->select(['cd_DOsottocommessa'])->from('dorig')
    ->where(['cd_cf' => $ris['cd_cli']])
->distinct()
    ->all(Yii::$app->db2);

 


$this->title = 'Pubblicazioni Annuali';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rep-publicazioni-index">

   

    <?php Pjax::begin(); ?>
    <?php 
    $isFa='';
    $dataProvider->setSort(['defaultOrder' => ['datacons'=>SORT_ASC]]);
    $dataProvider->pagination  = false;
    yii::warning($dataProvider);
    // echo $this->render('_search', ['model' => $searchModel]); 
$gridColumns=
[
    [

        'attribute' => 'datacons',
        'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white'],
        'label' => 'Data Pubblicazione',
        'width' => '15%',
        'options' => [
            'format' => 'd/m/YY',
        ],
        'value' => function ($model, $key, $index, $widget) {
            return date("d/m/Y", strtotime($model->datacons));
        },
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => ([
            'attribute' => 'data',
            'language' => 'it',
            'presetDropdown' => true,
            'convertFormat' => true,
            'pluginOptions' => [
                'separator' => ' - ',
                'language' => 'it',
                'ranges' => [
                    'Oggi' => ["moment().startOf('day')", "moment().add(1,'year').startOf('day')"],
                    'Ultimo anno' => ["moment().startOf('day').subtract(1,'year')", "moment().startOf('day')"],
                    'Ultimo mese' => ["moment().startOf('day').subtract(29, 'days')", "moment().endOf('day')"],
                    'Prossimi 30 gg' => ["moment().endOf('day')", "moment().endOf('day').add(30, 'days')"],
                    'Mese in Corso' => ["moment().startOf('month')", "moment().endOf('month')"],
                    'Mese Passato' => ["moment().subtract(1, 'month').startOf('month')", "moment().subtract(1, 'month').endOf('month')"],
                    'Tutto il prossimo mese' => ["moment().add(1, 'month').startOf('month')", "moment().add(1, 'month').endOf('month')"],
                ],
            ],
            'pluginEvents' => [
                "apply.daterangepicker" => "function() { apply_filter('only_date') }",
            ],
        ]),
    ],

    [
        'attribute' => 'descrizione',
        'visible' => true,
        'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
        'label' => 'Descrizione',
        'format' => 'text',
        'width' => '50%',

    ]
    ,

    [
        'attribute' => 'nrgazzetta',
        'visible' => true,
        'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
        'label' => 'Nr Gazzetta',
        'format' => 'text',
        'width' => '25',
         'value' => function ($model, $key, $index, $widget) {
            return $model->nrgazzetta ??'' ;
        },

    ]
    ,

    [
        'attribute' => 'nrinserzione',
        'visible' => true,
        'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
        'label' => 'Nr. Inserzione',
        'format' => 'text',
        'width' => '25%',
               'value' => function ($model, $key, $index, $widget) {
            return $model->nrinserzione ??'' ;
        },


    ]
    ,
];



$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target' => ExportMenu::TARGET_BLANK ,
    'pjaxContainerId' => 'kv-pjax-container',
    'showConfirmAlert'=>false,
        'exportConfig' => [ ExportMenu::FORMAT_EXCEL_X => false,
    ExportMenu::FORMAT_EXCEL=> ['label'=>'Excel'],
],
    'exportContainer' => [
        'class' => 'btn-group mr-2 me-2',
    ],
    'dropdownOptions' => [
        'label' => 'Export',
        'class' => 'btn btn-outline-secondary btn-default',
        'itemsBefore' => [
            '<div class="dropdown-header">Esporta tutti i dati visibili</div>',
        ],
    ],
]);



 
?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumnsOptions' => ['resizeFromBody' => true],
  // 'persistResize' => true,
    'resizeStorageKey'=>Yii::$app->user->id . '-' . date('m').'sc',
    'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],
'toolbar' => [
       // '{export}',
        $fullExportMenu,
     ['content'=>   
        Html::a('<i class="fas fa-redo"></i>', [''], [
                    'class' => 'btn btn-outline-secondary btn-default',
                    'title'=>Yii::t('kvgrid', 'Reset Grid'),
                    'data-pjax' => 0, 
                ]), ],
       
    ]
,
   /* 'export' => [
 'fontAwesome'=>true,
 'filename '=>'Report_data',
     GridView::EXCEL => [
        'label' => Yii::t('kvgrid', 'Excel'),
        'icon' => $isFa ? 'file-excel-o' : 'floppy-remove',
        'iconOptions' => ['class' => 'text-success'],
        'showHeader' => true,
        'showPageSummary' => true,
        'showFooter' => true,
        'showCaption' => true,
        'filename' => Yii::t('kvgrid', 'grid-export'),
        'alertMsg' => Yii::t('kvgrid', 'The EXCEL export file will be generated for download.'),
        'options' => ['title' => Yii::t('kvgrid', 'Microsoft Excel 95+')],
        'mime' => 'application/vnd.ms-excel',
        'config' => [
            'worksheet' => Yii::t('kvgrid', 'ExportWorksheet'),
            'cssFile' => ''
        ]
    ],
    ],*/
    //'export' => true,
        'columns' =>$gridColumns,
        'panel' => [
        'type' => $ris['grid_color'],
        'heading' => '<i class="fas  fa-book"></i> Pubblicazioni per data',
    ],
    'responsive' => true,
    'resizableColumns' => true,
    'showPageSummary' => true,
    'pjax' => false,
    ]); ?>

    <?php Pjax::end(); ?>

</div>
