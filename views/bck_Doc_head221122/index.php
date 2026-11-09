<?php
use app\models\anacli;
use app\models\doctype;
//use yii\grid\GridView;
use app\models\user;
//use app\model\Site;
use kartik\grid\GridView;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Modal;
use yii\helpers\Url;


$x = Yii::$app->runAction('site/getexp');
$icon = new \thoulah\fontawesome\Icon();
//use kartik\icons\Icon;
//Icon::map($this, Icon::EL);

use yii\helpers\Html;

//yii::warning($x);
/* @var $this yii\web\View */
/* @var $searchModel app\models\Doc_headSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$listconf = ['1' => 'Confermato',
    '0' => 'Non Confermato',
];
$listrif = ['1' => 'Rifiutato',
    '0' => 'Non Rifiutato',
];

$this->title = ' ';
//$this->params['breadcrumbs'][] = $this->title;

$usrid = Yii::$app->user->Id;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['grid_color', 'cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}
$usrgrid = $ris['grid_color'];

//yii::warning($usrgrid);
$eldoc = (new yii\db\Query())
    ->select(['cd_doc'])

    ->from('doc_head')
    ->where(['cd_cli' => $ris['cd_cli']])
    ->orwhere(['altcli'=>$ris['cd_cli']])
    ->distinct()
    ->all();

$elecli = (new yii\db\Query())
    ->select(['cd_cli'])
    ->distinct()
    ->from('doc_head')
    ->where(['altcli' => $ris['cd_cli']])
    ->andWhere(['not', ['altcli' => null]])
    ->distinct()
    ->all();
$elecli[]['cd_cli'] = $ris['cd_cli'];
//yii::error($elecli);
//yii::error($eldoc);
$clif= ArrayHelper::map(
    anacli::find()
                ->select(['cd_cli', '(cd_cli+\' \'+Desk) as desk'])
                ->where(['IN','cd_cli' , $elecli])
                ->orderBy('cd_cli')->
                asArray()->all()
                , 'cd_cli', 'desk');
//yii::error($clif);


?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<div class="doc-head-index">

    <h1><?=Html::encode('Documenti')?></h1>

    <p>
        <?php //Html::a('Create Doc Head', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
	
	$isFa='file-pdf-o' ;
	echo
	GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,

    //'filterUrl' => ['Doc_headSearch[cd_doc]',
    //'cd_doc' => 'orc'],
    'resizableColumnsOptions' => ['resizeFromBody' => true],
  //  'persistResize' => true,
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
        //   ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        // 'cd_doc',
        ['label' => 'Dett.Doc',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white'],
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detailRowCssClass' => 'card-header bg-' . $usrgrid . ' text-black',
            // uncomment below and comment detail if you need to render via ajax
            // 'detailUrl' => Url::to(['/site/book-details']),
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand-row',
                    ['model' => $model]);
            },
           // 'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],

            'expandOneOnly' => true,
        ],

        [
            'attribute' => 'cd_doc',
            'visible' => true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white','style'=>'color:black;'],
            'label' => 'Tipo Doc.',
            'format' => 'text',
            'width' => '80px',
            'value' => function ($model, $key, $index, $widget) {
                return $model->cd_doc;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(doctype::find()
                ->select(['cd_doc', '(cd_doc+\' \'+descrizione) as desk'])
                ->where(['cd_doc' => $eldoc])
                ->orderBy('cd_doc')->
                asArray()->all(), 'cd_doc', 'desk'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'descrizione'],

        ],  
         ['attribute' => 'numdoc',
        'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white','style'=>'color:black;'],
        'label' => 'Num. Doc.',
        // 'header' => 'Tipo Documento'
        'width' => '150px'],
        [
            'attribute' => 'data',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white','style'=>'color:black;'],
            'label' => 'Data Doc.',
            'width' => '225px',
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
     
        ['attribute' => 'cd_cli',
            'label' => 'Intestatario',
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white','style'=>'color:black;'],
            'format' => 'text',
            'width' => '300px',
            'visible' => true,
            'value' => function ($model, $key, $index, $widget) {

                $ris2 = anacli::find()->where(['cd_cli' => $model->cd_cli])->one();
                return $ris2->Desk;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' =>$clif
           
              
                ,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'descrizione'],
        ],

        //'data',

        
        // 'cd_cli',
        /*  ['attribute'=>'cd_pg',
        'label' => 'Tipo Pag.',
        'headerOptions' => ['class' => 'card-header bg-'.$usrgrid.' text-white'],
        'width'=>'150px'],*/

        //'confermato',
        ['attribute' => 'confermato',
            //  'hiddenFromExport' => true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white','style'=>'color:black;'],
            'format' => 'raw',
            'width' => '50px',
            //'options' => ['width' => '10x','value'=>$model->confermato],
            //   'class' => '\kartik\grid\CheckboxColumn',
            'class' => '\kartik\grid\BooleanColumn',
            'trueLabel' => 'SI',
            'falseLabel' => 'No',
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model->confermato == 1) {
                    return ['style' => 'background-color:green'];
                }

            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => $listconf,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Confermato'],
            'encodeLabel' => false,

        ],
        //'rifiutato',
        ['attribute' => 'rifiutato',
  
            //    'hiddenFromExport' => true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black','style'=>'color:black;'],
            'format' => 'raw',
            'width' => '50px',
            'class' => '\kartik\grid\BooleanColumn',
            'trueLabel' => 'SI',
            'falseLabel' => 'No',
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model->rifiutato == 1) {
                    return ['style' => 'background-color:red'];
                }

            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => $listrif,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Rifutato'],
            //'encodeLabel' => false
        ],

        ['label' => 'Note',
            'headerOptions' => 
            ['class' => 'card-header bg-' . $usrgrid . ' text-white','style'=>'color:black;'],
            'width' => '600px',
            'attribute' => 'note',
                'value'=>function ($model, $key, $index, $column) {
                    
if (strlen($model->note)>2) {
    return substr($model->note, 0, 60).'...';
}
else
{
  return $model->note;  
}
                }
        ],

        ['header' => 'Imponibile',
        //'contentFormats'=> ['decimal',2],
     //   'class'=>'\kartik\grid\DataColumn',
             'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-black','style'=>'color:black;'],
             //['class' => 'card-header bg-' . $usrgrid . ' text-white'],
           // 'vAlign' => 'middle',
            'width' => '50px',
            'attribute' => 'ImportoV',
   'format'=>'currency',
            'value' => function ($model, $key, $index, $widget) {
             $t = 0;
                $query =
                (new Query())->select(['TotImponibilee'])->from('DOTotali')
                ->where(['Id_DoTes' => $model['xid_testa']])->one(Yii::$app->db2);
                $t = $query['TotImponibilee'];
                return $t ; //gettype($t);  
                //number_format($t, 2, ',', '.');
            
             
            },
            'pageSummary' => true,

    /*'pageSummaryFormat'=>//['decimal',2]
    function ($data) {
        yii::error($data);
        return strval($data);
        //number_format($data, 2, ',', '');
    }*/
   
    ],
        ['header' => 'Imposta',
            'width' => '50px',
             'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-black','style'=>'color:black;'],
             //['class' => 'card-header bg-' . $usrgrid . ' text-white'],
       //     'vAlign' => 'middle',
            'format'=>'currency',
            'attribute' => 'ImportoV',
            'value' => function ($model, $key, $index, $widget) {
                $t = 0;
                $query =
                (new Query())->select(['totimpostae'])->from('DOTotali')
                ->where(['Id_DoTes' => $model['xid_testa']])->one(Yii::$app->db2);
                $t = $query['totimpostae'];
                return $t;//gettype($t);  
                //number_format($t, 2, ',', '.');
            },
       'pageSummary' => true,
     /*  'pageSummaryFormat'=> 
       function ($data) {
      yii::warning($data);
        return strval($data);
        //, 2, ',', '.');
      }*/
        ],

/*

               [
            'hiddenFromExport' => true,
            'vAlign' => 'middle',
            'width' => '50px',
            'header' => "Mail",
            'format'=>'raw',
            'value'=> function ($model, $key, $index, $widget) {
                   
                   $tmpid =$model->xid_testa;
Modal::begin([
    //'header'=>'<h4>Clienti</h4>',
    'id' => 'cli' . $tmpid,
    'size' => 'modal-lg', //classe bootstrap
]);
echo "<div id='modalContent'></div>";
Modal::end();
$this->registerJs("
  $('#modalcli_$tmpid').click(function (){
  $('#cli$tmpid').modal('show')
  .find('#modalContent')
  .load($(this).attr('value'));
  });"
);
$url = Url::to(['site/contatti', 
'id' => $model->xid_testa,
'render'=> 'ajax'
//   'mod'->$model
]);

                   
                   
                   
                   
                   
                  //  return Html::a ( '<span class="fas fa-at" aria-hidden="true"></span>',
                   //  ['site/contatti', 'id' => $model->id],['id' => 'modalcli_' . $tmpid],

return   Html::button('<span class="fas fa-at" aria-hidden="true"></span>',
 ['value' => $url,
    'class' => 'btn btn-info', 'id' => 'modalcli_' . $tmpid]);


                 //   ['title' =>  'Copy'] );
                },
                  
            'headerOptions' => ['class' => 'skip-export-pdf card-header bg-' . $usrgrid . ' text-white'],
            ],   


            */
                    ['class' => '\kartik\grid\ActionColumn',
            //  'hiddenFromExport' => true,
            
            'width' => '50px',
            'header' => "Dett.",
           'headerOptions' => ['class' =>  'card-header bg-'.$usrgrid.' text-black','style'=>'color:black;'],
            'template' => '{view}'], 

    ],

    'panel' => [
        'type' => $ris['grid_color'],
        'heading' => '<i class="fas  fa-book"></i> Documenti',
    ],
    'responsive' => true,
    'resizableColumns' => true,
    'showPageSummary' => true,
    'pjax' => false,
]);?>
</div>
