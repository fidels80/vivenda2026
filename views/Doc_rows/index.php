<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\items;
/* @var $this yii\web\View */
/* @var $searchModel app\models\Doc_rowsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 
use yii\helpers\ArrayHelper;


$this->title = 'Doc Rows';
$this->params['breadcrumbs'][] = $this->title;
/*
$defaultExportConfig = [
    GridView::HTML => [
        'label' => Yii::t('kvgrid', 'HTML'),
        'icon' => $isFa ? 'file-text' : 'floppy-saved',
        'iconOptions' => ['class' => 'text-info'],
        'showHeader' => true,
        'showPageSummary' => true,
        'showFooter' => true,
        'showCaption' => true,
        'filename' => Yii::t('kvgrid', 'grid-export'),
        'alertMsg' => Yii::t('kvgrid', 'The HTML export file will be generated for download.'),
        'options' => ['title' => Yii::t('kvgrid', 'Hyper Text Markup Language')],
        'mime' => 'text/html',
        'config' => [
            'cssFile' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'
        ]
    ],
    GridView::CSV => [
        'label' => Yii::t('kvgrid', 'CSV'),
        'icon' => $isFa ? 'file-code-o' : 'floppy-open', 
        'iconOptions' => ['class' => 'text-primary'],
        'showHeader' => true,
        'showPageSummary' => true,
        'showFooter' => true,
        'showCaption' => true,
        'filename' => Yii::t('kvgrid', 'grid-export'),
        'alertMsg' => Yii::t('kvgrid', 'The CSV export file will be generated for download.'),
        'options' => ['title' => Yii::t('kvgrid', 'Comma Separated Values')],
        'mime' => 'application/csv',
        'config' => [
            'colDelimiter' => ",",
            'rowDelimiter' => "\r\n",
        ]
    ],
    GridView::TEXT => [
        'label' => Yii::t('kvgrid', 'Text'),
        'icon' => $isFa ? 'file-text-o' : 'floppy-save',
        'iconOptions' => ['class' => 'text-muted'],
        'showHeader' => true,
        'showPageSummary' => true,
        'showFooter' => true,
        'showCaption' => true,
        'filename' => Yii::t('kvgrid', 'grid-export'),
        'alertMsg' => Yii::t('kvgrid', 'The TEXT export file will be generated for download.'),
        'options' => ['title' => Yii::t('kvgrid', 'Tab Delimited Text')],
        'mime' => 'text/plain',
        'config' => [
            'colDelimiter' => "\t",
            'rowDelimiter' => "\r\n",
        ]
    ],
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
    GridView::PDF => [
        'label' => Yii::t('kvgrid', 'PDF'),
        'icon' => $isFa ? 'file-pdf-o' : 'floppy-disk',
        'iconOptions' => ['class' => 'text-danger'],
        'showHeader' => true,
        'showPageSummary' => true,
        'showFooter' => true,
        'showCaption' => true,
        'filename' => Yii::t('kvgrid', 'grid-export'),
        'alertMsg' => Yii::t('kvgrid', 'The PDF export file will be generated for download.'),
        'options' => ['title' => Yii::t('kvgrid', 'Portable Document Format')],
        'mime' => 'application/pdf',
        'config' => [
            'mode' => 'c',
            'format' => 'A4-L',
            'destination' => 'D',
            'marginTop' => 20,
            'marginBottom' => 20,
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
                    ['odd' => $pdfHeader, 'even' => $pdfHeader]
                ],
                'SetFooter' => [
                    ['odd' => $pdfFooter, 'even' => $pdfFooter]
                ],
            ],
            'options' => [
                'title' => $title,
                'subject' => Yii::t('kvgrid', 'PDF export generated by kartik-v/yii2-grid extension'),
                'keywords' => Yii::t('kvgrid', 'krajee, grid, export, yii2-grid, pdf')
            ],
            'contentBefore'=>'',
            'contentAfter'=>''
        ]
    ],
    GridView::JSON => [
        'label' => Yii::t('kvgrid', 'JSON'),
        'icon' => $isFa ? 'file-code-o' : 'floppy-open',
        'iconOptions' => ['class' => 'text-warning'],
        'showHeader' => true,
        'showPageSummary' => true,
        'showFooter' => true,
        'showCaption' => true,
        'filename' => Yii::t('kvgrid', 'grid-export'),
        'alertMsg' => Yii::t('kvgrid', 'The JSON export file will be generated for download.'),
        'options' => ['title' => Yii::t('kvgrid', 'JavaScript Object Notation')],
        'mime' => 'application/json',
        'config' => [
            'colHeads' => [],
            'slugColHeads' => false,
            'jsonReplacer' => null,
            'indentSpace' => 4
        ]
    ],
];


*/












?>
<div class="doc-rows-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php //Html::a('Create Doc Rows', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php /* echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'doc_head_id',
           'cd_doc',
           'data',
           'numdoc',
           'cd_art',
            'descrizione',
            'um',
            'qta',
            'prezzo',
            //'sconto',
            //'note',
            //'cd_cli',
            //'xid_testa',
            //'xid_riga',
            'iva',

            ['class' => 'yii\grid\ActionColumn'],
        ],
       // 'resizableColumns'=>true,
      //  'showPageSummary' => true,
        'toolbar'=>[
            '{export}',
            '{toggleData}'
        ],
        'autoXlFormat'=>true,
    'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],
    'export'=>[
        'showConfirmAlert'=>false,
        'target'=>GridView::TARGET_BLANK
    ],
    ]); */?>






<?php echo 





GridView::widget([
    'dataProvider'=>$dataProvider, 'filterModel' => $searchModel,
    'autoXlFormat'=>true,
    'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],
    'export'=>[
        'showConfirmAlert'=>false,
        'target'=>GridView::TARGET_BLANK
    ],
    'columns'=>[
       // ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute'=>'cd_doc', 
            'format'=>'text', 
            'width'=>'5px', 
            'pageSummary'=>'Total'
        ],
        [
            'attribute'=>'cd_art', 
            'format'=>'text', 
            'width'=>'100px',
            'value' => function ($model, $key, $index, $widget) { 
                return $model->cd_art;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(items::find() 
            ->select(['codice', '(codice+\' \'+descrizione) as desk'])->
                orderBy('codice')->
                asArray()->all(), 'codice' , 'desk'), 
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'descrizione'],





        ],
        [
            'attribute'=>'descrizione', 
            'format'=>'text', 
           // 'xlFormat'=>'mmm\-dd\, yyyy',  // different date format
            'width'=>'180px'
        ],
        [
            'attribute'=>'qta', 
            'format'=>['decimal', 2],//['time', 'php:g:i a'], 
            'hAlign'=>'right', 
            'width'=>'5px', 
            'xlFormat'=>'0\.00E+00', // scientific
            'pageSummary'=>true
        ],

        [
            'attribute'=>'prezzo', 
            'format'=>['decimal', 2], 
            'hAlign'=>'right', 
            'width'=>'10px', 
            'pageSummary'=>true
        ],
       // [
            //'class'=>'kartik\grid\FormulaColumn', 
           // 'label'=>'Amount', 
          //  'format' => ['decimal', 2],
            //'value'=>function ($model, $key, $index, $widget) { 
            //    $p = compact('model', 'key', 'index');
             //   return $widget->col(4, $p) * $widget->col(5, $p) ;
            //}, 
           // 'hAlign'=>'right', 
           // 'width'=>'120px', 
           // 'pageSummary'=>true
        //],
 
    ],
    'pjax'=>true,
    'showPageSummary'=>true,
    'panel'=>[
        'type'=>'primary',
        'heading'=>'Products'
    ],
    'responsive'=>true,
    'hover'=>true, 
    'resizableColumns'=>true,
]);




































?>

    <?php //Pjax::end(); ?>

</div>
