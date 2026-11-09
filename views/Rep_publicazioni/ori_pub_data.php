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

$elart = (new yii\db\Query())
    ->select(['cd_art'])

    ->from('doc_rows')
    ->where(['cd_cli' => $ris['cd_cli']])
    //->orwhere(['altcli' => $ris['cd_cli']])
    ->distinct()
    ->all();


$elecommesse=(
new yii\db\ Query())->select(['cd_DOsottocommessa'])->from('dorig')
    ->where(['cd_cf' => $ris['cd_cli']])
->distinct()
    ->all(Yii::$app->db2);

 


$this->title = 'Pubblicazioni Annuali';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rep-publicazioni-index">

   

    <?php Pjax::begin(); ?>
    <?php 
    $dataProvider->setSort(['defaultOrder' => ['datacons'=>SORT_ASC]]);
    $dataProvider->pagination  = false;
    
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumnsOptions' => ['resizeFromBody' => true],
    'persistResize' => true,
    'resizeStorageKey'=>Yii::$app->user->id . '-' . date('m').'sc',
    'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],

    'export' => [
        'showConfirmAlert' => false,
        'target' => GridView::TARGET_BLANK,
        GridView::PDF => [
            'label' => Yii::t('kvgrid', 'PDF'),
            'icon' => $isFa ? 'file-pdf-o' : 'floppy-disk',
            'iconOptions' => ['class' => 'text-danger'],
            'showHeader' => true,
            'showPageSummary' => true,
            'showFooter' => true,
            'showCaption' => true,
            'filename' => Yii::t('kvgrid', 'Portal pdf export'),
            'alertMsg' => Yii::t('kvgrid', 'The PDF export file will be generated for download.'),
            'options' => ['title' => Yii::t('kvgrid', 'Portable Document Format')],
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
             /*   'methods' => [
                    'SetHeader' => [
                        ['odd' => $pdfHeader, 'even' => $pdfHeader],
                    ],
                    'SetFooter' => [
                        ['odd' => $pdfFooter, 'even' => $pdfFooter],
                    ],
                ],*/
                'options' => [
                 //   'title' => $title,
                    'subject' => Yii::t('kvgrid', 'PDF'),
                    'keywords' => Yii::t('kvgrid', 'krajee, grid, export, yii2-grid, pdf'),
                ],
                'contentBefore' => '',
                'contentAfter' => '',
            ],
        ],
    ],
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

           // 'cd_cf',
           
            //'datacons',
             [
            'attribute' => 'datacons',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white'],
            'label' => 'Data Cons.',
            'width' => '15%',
            'options' => [
                'format' => 'd/m/YY',
            ],
            'value' => function ($model, $key, $index, $widget) {
                return  date("d/m/Y",strtotime($model->datacons)) ;
            },
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => ([
                'attribute' => 'data',
                'language' => 'it',
                'presetDropdown' => true,
                'convertFormat' => true,
                'pluginOptions' => [
                    'separator' => ' - ',
                    'language' => 'it',//,
                   // 'format' => 'D/M/YY',
                   // 'locale' => [
                   //     'format' => 'D/M/YY',
                  //  ],
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
            'attribute' => 'cd_Art',
            'visible' => true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
            'label' => 'Art.',
            'format' => 'text',
            'width' => '15%',
            'value' => function ($model, $key, $index, $widget) {
                return $model->cd_Art;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(doc_rows::find()
                ->select(['cd_art', '(cd_art+\' \'+descrizione) as desk'])
                ->where(['cd_art' => $elart])
                 ->distinct()
               -> asArray()->all(), 'cd_art', 'desk'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'descrizione'],

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
            'attribute' => 'Cd_DOSottoCommessa',
            'visible' => true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
            'label' => 'Commessa',
            'format' => 'text',
            'width' => '50%',
             'value' => function ($model, $key, $index, $widget) {
                return $model->Cd_DOSottoCommessa;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(
                /*doc_rows::find()
                ->select(['cd_art', '(cd_art+\' \'+descrizione) as desk'])
                ->where(['cd_art' => $elart])
                 ->distinct()
               -> asArray()->all()*/
              (new Query())->select(['cd_DOsottocommessa as cd_comm','descrizione as desk'])->from('DOSottoCommessa')
    ->where(['cd_DOsottocommessa' => $elecommesse])

    ->all(Yii::$app->db2)

               
               , 'cd_comm', 'desk'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'descrizione'],
            
            
            ]
            //'Cd_DO',
            //'PrezzoUnitarioScontatoV',
            //'Qta',
            //'PrezzoTotaleE',
            //'Cd_ARMarca',
            //'Id_DORig',

            //['class' => 'yii\grid\ActionColumn'],
        ],'panel' => [
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
