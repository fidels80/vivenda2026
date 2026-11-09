<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;







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



























\Yii::$app->language ='it';
$listconf = ['1' => 'Pagata',
    '0' => 'Non pagata',
];

//use app\model\user;
$usrid = Yii::$app->user->Id;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['grid_color'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}
$usrgrid=$ris['grid_color'];

//yii::warning($usrgrid);
//$ris;


/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-index">

    <h1><?php // Html::encode('Scadenze') ?></h1>

    <p>
        <?php 
        //Html::a('Create Payments', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'autoXlFormat'=>true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],
        'resizableColumnsOptions' => ['resizeFromBody' => true],
       // 'persistResize' => true,
        'resizeStorageKey'=>Yii::$app->user->id . '-' . date('m').'sc',
        'panel'=>[
            'type'=>$usrgrid,
            'heading'=>'<i class="fas  fa-piggy-bank"></i> Scadenze'
        ],
        'export'=>[
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK,
           // 'fontAwesome' => true
        ],   'exportConfig' => [
        'html' => [],
        'csv' => [],
        'txt' => [],
        'xls' => [],
        'pdf' => [[
            'label' => Yii::t('kvgrid', 'PDF'),
            'icon' => $isFa ? 'file-pdf-o' : 'floppy-disk',
            'iconOptions' => ['class' => 'text-danger'],
            'showHeader' => false,
            'showPageSummary' => true,
            'showFooter' => false,
            'showCaption' => true,
            'filename' => Yii::t('kvgrid', 'Portal pdf export'),
            'alertMsg' => Yii::t('kvgrid', 'The PDF export file will be generated for download.'),
            'options' => ['title' =>'Portable Document Format'],
            'mime' => 'application/pdf',
            'config' => [
                'mode' => 'c',
                'format' => 'A4-L',
                'destination' => 'D',
                'marginTop' => 20,
                'marginBottom' => 20,
                'cssFile' => 'https: //use.fontawesome.com/releases/v5.3.1/css/all.css',
                'cssInline' => '.kv-wrap{padding:20px;}' .
                '.kv-align-center{text-align:center;}' .
                '.kv-align-left{text-align:left;}' .
                '.kv-align-right{text-align:right;}' .
                '.kv-align-top{vertical-align:top!important;}' .
                '.kv-align-bottom{vertical-align:bottom!important;}' .
                '.kv-align-middle{vertical-align:middle!important;}' .
                '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
                '.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
                '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
                'methods' => [
                   'SetHeader' => [
                        ['odd' => '$pdfHeader', 'even' => 'even'],
                    ],
                   'SetFooter' => [
                        ['odd' => '$pdfFooter', 'even' => 'evenft'],
                    ],
                ],
                'options' => [
                    'title' => 'scadenze',
                    'subject' => Yii::t('kvgrid', 'PDF'),
                    'keywords' => Yii::t('kvgrid', 'krajee, grid, export, yii2-grid, pdf'),
                ],
                'contentBefore' => 'Creato da Portale',
                'contentAfter' => 'sssssssssssssss',
                'SetHeader' => ['Krajee Privacy Policy||Generated On: ' . date("r")],
            ],
        ],],
        'json' => [],
    ],
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'xid_testa',
            //'cd_cli',
            ['attribute'=>'Cd_PG',
        	'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white','style'=>'color:black;'],
          'label'=>'Cod.PG'
          ],
           // 'DataScadenza',

            [
                'attribute'=>'DataScadenza',
                //	'header' => 'Profit Margin<br>(%)', 
	'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-white','style'=>'color:black;'],
                'label' => 'Data Scad.', 
                'width'=>'200px',
                'value'=> function ($model, $key, $index, $widget) {
                    
            
                    return   date('d/m/Y',(strtotime($model->DataScadenza)));
                
            },
                'options' => [
                    'format' => 'd-m-Y',
                    ],        
                    'exportMenuStyle' => ['numberFormat' => ['formatCode' => 'd-m-Y']] ,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([       
                  'attribute' => 'DataScadenza',
                  'presetDropdown' => true,
                  'convertFormat' => false,
                  'pluginOptions' => [
                    'separator' => ' - ',
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
              ],


           // 'DataPagamento',
            [
                'attribute'=>'DataPagamento',
                	'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-white','style'=>'color:black;'],
                'label' => 'Data Pg.', 
                'width'=>'200px',
                'value'=> function ($model, $key, $index, $widget) {
                    
            if (is_null($model->DataPagamento)){
                return null;
            }else{
                    return   date('d/m/Y',(strtotime($model->DataPagamento)));
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
              ],
            //'DataFattura',
            [
                'attribute'=>'DataFattura',
                	'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-white','style'=>'color:black;'],
                'label' => 'Data FT.', 
                'width'=>'200px',
                'value'=> function ($model, $key, $index, $widget) {
                    
            
                    return   date('d/m/Y',(strtotime($model->DataFattura)));
                
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
              ],



       
                        ['attribute'=>'NumFattura',
        	'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white','style'=>'color:black;'],
          'label'=> 'Num. Ft'
          ],
                          ['attribute'=>'Protocollo',
        	'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white','style'=>'color:black;'],
          'label'=> 'Protocollo'
          ],
           // 'Pagata',

            ['attribute'=>'Pagata', 
            	'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-white','style'=>'color:black;'],
            'width'=>'50px',
           
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
            //'encodeLabel' => false

        
            ],

     
           
                                  ['attribute'=>   'NumEffetto',
        	'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-white','style'=>'color:black;'],
          'label'=>    'NumEffetto'
          ],
                                ['attribute'=> 'TotEffetti',
        	'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-black','style'=>'color:black;'],
          'label'=>  'TotEffetti',
          ],

            ['attribute'=>'ImportoV',
//            'format'=>['decimal',2],
//'value'=>function ($model, $key, $index, $widget) {
//return 
//number_format($model->ImportoV, 2, ',', '');
//},
//'class' => '\kartik\grid\DataColumn',
'format'=>'currency',
            	'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-black','style'=>'color:black;'],
            'pageSummary' => true,
            
       /*     'pageSummaryFormat'=> 
       function ($data) {
      yii::warning($data);
        return strval($data);
        //, 2, ',', '.');
      },*/
            ]
            ,
            ['attribute'=> 'IncassoV', 
            'format'=>'currency',
        //    'value'=>function ($model, $key, $index, $widget) {
        //        return 
        //        number_format($model->IncassoV, 2, ',', '.');
        //        },
              	'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-black','style'=>'color:black;'],
     'value'=>function ($model, $key, $index, $widget){
        if ($model->Pagata==0){
            return null;
            }else{
                return $model->IncassoV;
            }



     },
            'pageSummary' => true,
          /*  'pageSummaryFormat'=> 
            function ($data) {
       //    yii::warning($data);
             return strval($data);
             //, 2, ',', '.');
           }*/],

            [ 'class' => '\kartik\grid\ActionColumn',
            //  'hiddenFromExport' => true,
            'width' => '50px',
            'header' => "Dett.",
            'headerOptions' => ['class' => 'skip-export-pdf card-header bg-' . $usrgrid . ' text-white','style'=>'color:black;'],
            'template' => '{view}'  ],
        ],'responsive'=>true,
        //'hover'=>true, 
        'resizableColumns'=>true,
        
        'showPageSummary'=>true,
      //   'pjax' => true,
    ]); ?>


</div>
