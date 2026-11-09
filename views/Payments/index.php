<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Html;

$pdfHeader = [
    'L' => [
        'content' => 'LEFT CONTENT (HEAD)',
    ],
    'C' => [
        'content' => 'CENTER CONTENT (HEAD)',
        'font-size' => 10,
        'font-style' => 'B',
        'font-family' => 'arial',
        'color' => '#333333',
    ],
    'R' => [
        'content' => 'RIGHT CONTENT (HEAD)',
    ],
    'line' => true,
];

$pdfFooter = [
    'L' => [
        'content' => 'LEFT CONTENT (FOOTER)',
        'font-size' => 10,
        'color' => '#333333',
        'font-family' => 'arial',
    ],
    'C' => [
        'content' => 'CENTER CONTENT (FOOTER)',
    ],
    'R' => [
        'content' => 'RIGHT CONTENT (FOOTER)',
        'font-size' => 10,
        'color' => '#333333',
        'font-family' => 'arial',
    ],
    'line' => true,
];

\Yii::$app->language = 'it';
$listconf = ['1' => 'Pagata',
    '0' => 'Non pagata',
];

//use app\model\user;
$usrid = Yii::$app->user->Id;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['grid_color', 'sidebar_color'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}
$usrgrid = $ris['grid_color'];
yii::error($ris['grid_color']);
if (!empty($ris['sidebar_color'])) {
    $sidebar_color = $ris['sidebar_color'];
} else {
    $sidebar_color = 'black';

}
$sidebar_color = 'black';

//yii::warning($usrgrid);
//$ris;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
//$this->params['breadcrumbs'][] = $this->title;





$gridColumns=[
        ['attribute' => 'Cd_PG',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:black;'],
            'label' => 'Cod.PG',
        ],
        // 'DataScadenza',

        [
            'attribute' => 'DataScadenza',
            //    'header' => 'Profit Margin<br>(%)',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:black;'],
            'label' => 'Data Scad.',
            'width' => '200px',
            'value' => function ($model, $key, $index, $widget) {

                return date('d/m/Y', (strtotime($model->DataScadenza)));

            },
            'options' => [
                'format' => 'd-m-Y',
            ],
            'exportMenuStyle' => ['numberFormat' => ['formatCode' => 'd-m-Y']],
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => ([
                'attribute' => 'DataScadenza',
                'presetDropdown' => true,
                'convertFormat' => false,
                'pluginOptions' => [
                    'separator' => ' - ',
                    'format' => 'DD-MM-YYYY',
                    'locale' => [
                        'format' => 'DD-MM-YYYY',
                    ],
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
            'attribute' => 'DataPagamento',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:black;'],
            'label' => 'Data Pg.',
            'width' => '200px',
            'value' => function ($model, $key, $index, $widget) {

                if (is_null($model->DataPagamento)) {
                    return null;
                } else {
                    return date('d/m/Y', (strtotime($model->DataPagamento)));
                }
            },
            'options' => [
                'format' => 'DD-MM-YYYY',
            ],
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => ([
                'attribute' => 'DataPagamento',
                'presetDropdown' => true,
                'convertFormat' => false,
                'pluginOptions' => [
                    'separator' => ' - ',
                    'format' => 'DD-MM-YYYY',
                    'locale' => [
                        'format' => 'DD-MM-YYYY',
                    ],
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
        //'DataFattura',
        [
            'attribute' => 'DataFattura',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:black;'],
            'label' => 'Data FT.',
            'width' => '200px',
            'value' => function ($model, $key, $index, $widget) {

                return date('d/m/Y', (strtotime($model->DataFattura)));

            },
            'options' => [
                'format' => 'DD-MM-YYYY',
            ],
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => ([
                'attribute' => 'DataFattura',
                'presetDropdown' => true,
                'convertFormat' => false,
                'pluginOptions' => [
                    'separator' => ' - ',
                    'format' => 'DD-MM-YYYY',
                    'locale' => [
                        'format' => 'DD-MM-YYYY',
                    ],
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

        ['attribute' => 'NumFattura',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:black;'],
            'label' => 'Num. Ft',
        ],
        ['attribute' => 'Protocollo',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:black;'],
            'label' => 'Protocollo',
        ],
        ['attribute' => 'Pagata',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white', 'style' => 'color:black;'],
            'width' => '50px',

            'class' => '\kartik\grid\BooleanColumn',
            'trueLabel' => 'SI',
            'falseLabel' => 'No',
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model->Pagata == 1) {
                    return ['style' => 'background-color:green'];
                }

            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => $listconf,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Pagata'],
        ],

        ['attribute' => 'NumEffetto',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:black;'],
            'label' => 'NumEffetto',
        ],
        ['attribute' => 'TotEffetti',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:black;'],
            'label' => 'TotEffetti',
        ],

        ['attribute' => 'ImportoV',
            'class' => '\kartik\grid\DataColumn',
            'format' => 'currency',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:black;'],
            'pageSummary' => true,

        ]
        ,
        ['attribute' => 'IncassoV',
            'class' => '\kartik\grid\DataColumn',
            'format' => 'currency',
            'vAlign' => 'middle',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black', 'style' => 'color:' . $sidebar_color . ';'],
            'value' => function ($model, $key, $index, $widget) {
                $t = 0;

                if ($model->Pagata == 0) {
                    $t = 0;
                } else {
                    $t = $model->IncassoV;
                }
                return $t;

            },


            'pageSummary' => true,
],

        ['class' => '\kartik\grid\ActionColumn',
            'width' => '50px',
            'header' => "Dett.",
            'headerOptions' => [ 'class' => 'card-header bg-' . $usrgrid ,'style' => 'color:black ;'],
            'template' => '{view}',
          'vAlign' => 'top',
        
        ],
    ];



$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target' => ExportMenu::TARGET_BLANK,
    'exportConfig' => [ExportMenu::FORMAT_EXCEL_X => false,
        ExportMenu::FORMAT_EXCEL => ['label' => 'Excel'],
    ],
    'pjaxContainerId' => 'kv-pjax-container',
    'showConfirmAlert' => false,
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
<div class="payments-index">

    <h1><?php // Html::encode('Scadenze') ?></h1>

    <p>
        <?php $isFa = '';
//Html::a('Create Payments', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    //'autoXlFormat'=>true,
    'resizableColumnsOptions' => ['resizeFromBody' => true],
    'persistResize' => true,
    'resizeStorageKey' => Yii::$app->user->id . '-' . date('m') . 'sc',
    'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],

    'export' => [
        'showConfirmAlert' => false,
        'target' => GridView::TARGET_BLANK,
        // 'fontAwesome' => true
    ], 
    'columns' => $gridColumns,
    'toolbar' => [
       // '{export}',
             '{toggleData}',
        $fullExportMenu,
     ['content'=>   
        Html::a('<i class="fas fa-redo"></i>', [''], [
                    'class' => 'btn btn-outline-secondary btn-default',
                    'title'=>Yii::t('kvgrid', 'Reset Grid'),
                    'data-pjax' => 0, 
                ]), ],
       
            ],
    'responsive' => true,
    //'hover'=>true,
    'resizableColumns' => true,

    'showPageSummary' => true,
    //   'pjax' => true,
    'panel' => [
        //'type' => $ris['grid_color'],
        'heading' => '<i class="fas  fa-piggy-bank"></i> Scadenze',
    ],
    'responsive' => true,
    'resizableColumns' => true,
    'showPageSummary' => true,
    'pjax' => false,
]);?>


</div>
