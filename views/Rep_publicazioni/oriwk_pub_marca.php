<?php

use app\models\user;
use kartik\grid\GridView;
//use app\model\Site;

use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
//use app\models\Rep_publicazioni;
//use yii\data\SqlDataProvider;
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

$elecommesse = (
    new yii\db\Query())->select(['cd_DOsottocommessa'])->from('dorig')
    ->where(['cd_cf' => $ris['cd_cli']])
    ->distinct()
    ->all(Yii::$app->db2);

$elemarca = (
    new yii\db\Query())->select(['Cd_ARMarca'])->from('Rep_publicazioni')
    ->where(['cd_cf' => $ris['cd_cli']])
    ->distinct()
    ->all();

$this->title = 'Pubblicazioni Richieste';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rep-publicazioni-index">

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

    <?php Pjax::begin();?>
    <?php

/*$count=Rep_publicazioni::find()
->select(['cd_armarca','descrizione','Cd_DOSottoCommessa'])
->where(['cd_cf'=>$ris['cd_cli']])
->groupBy(['cd_armarca','descrizione','Cd_DOSottoCommessa'])
->count();
$dataProvider= new SqlDataProvider([
'sql' => 'SELECT  cd_armarca,descrizione,Cd_DOSottoCommessa,sum(qta) as moduli ,
avg(PrezzoUnitarioScontatoV) as przmedio,sum(qta*PrezzoUnitarioScontatoV) prezzovendita,cd_Cf
FROM [web_frontier].[dbo].[rep_publicazioni]
where cd_cf=:cf
group by cd_armarca,descrizione ,Cd_DOSottoCommessa,cd_Cf',
'params'=>[':cf'=>$ris['cd_cli']],

'totalCount' =>$count,

//1000,// $count,
]);
 */
//Rep_publicazioni::find()->where(['cd_cf' => $ris['cd_cli']])->all();
/*
(new yii\db\Query())->select(['cd_armarca,descrizione,Cd_DOSottoCommessa,sum(qta) as moduli ,
avg(PrezzoUnitarioScontatoV) as przmedio,sum(qta*PrezzoUnitarioScontatoV) prezzovendita'])->from('rep_publicazioni')
->where(['cd_cf' => $ris['cd_cli']])
->distinct()
->groupBy(['cd_armarca','descrizione' ,'Cd_DOSottoCommessa'])
->all();
$dataProvider=>totalcount=1000;
 */

//$dataProvider->setSort(['defaultOrder' => ['datacons' => SORT_ASC]]);
//$dataProvider->pagination = false;

// echo $this->render('_search', ['model' => $searchModel]);
yii::warning($dataProvider);
foreach ($dataProvider as $key) {
    # code...
    yii::warning($key);
}
$formatter = new \yii\i18n\Formatter;
$isFa='';
?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'resizableColumnsOptions' => ['resizeFromBody' => true],
   // 'persistResize' => true,
   // 'resizeStorageKey' => Yii::$app->user->id . '-' . date('m') . 'sc',
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
     /*   [
            'label' => 'Marca',
            'attribute' => 'Cd_ARMarca',
            'visible' => true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
            'width' => '10%',
            


           /* 'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(
                /*doc_rows::find()
                ->select(['cd_art', '(cd_art+\' \'+descrizione) as desk'])
                ->where(['cd_art' => $elart])
                ->distinct()
                -> asArray()->all()
                (new Query())->select(['Cd_ARMarca as cd_mar', 'Descrizione as desk'])->from('armarca')
                ->where(['Cd_ARMarca' => $elemarca])

                ->all(Yii::$app->db2)

                , 'cd_mar', 'desk'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'descrizione'],

        ],
*/
        [
            'label' => 'Descrizione',
            'attribute' => 'descrizione',
            'visible' => true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
            'width' => '60%',
            'group' => false,

'groupFooter' => function ($model, $key, $index, $widget) { // Closure method
                return [
                   // 'mergeColumns' => [[1,2]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        0 => 'Totale ->' . $model->descrizione . '',
                       1 => GridView::F_SUM,
                         2 => (GridView::F_SUM),
                          //4 => GridView::F_AVG,
                   //     3 =>(GridView::F_SUM),
                      //  6 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        1 => ['format' => 'number', 'decimals' => 0,'decPoint'=>',','thousandSep'=>'.'],
                       2 => ['format' => 'number', 'decimals' => 2,'decPoint'=>',', 'thousandSep'=>'.'],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        1 => ['style' => 'font-variant:small-caps','class' => 'highlighted'],
                        2 => ['style' => 'text-align:left','class' => 'highlighted1'],
                        3 => ['style' => 'text-align:left','class' => 'highlighted'],
                        //6 => ['style' => 'text-align:right'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'info table-info','style' => 'font-weight:bold;']
                ];
            },

        ]
        ,

    /*    [
            'attribute' => 'Cd_DOSottoCommessa',
            'visible' => true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
            'label' => 'Commessa',
            'format' => 'text',
            'width' => '10%',
            'value' => function ($model, $key, $index, $widget) {
                return $model->Cd_DOSottoCommessa;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(
                /*doc_rows::find()
                ->select(['cd_art', '(cd_art+\' \'+descrizione) as desk'])
                ->where(['cd_art' => $elart])
                ->distinct()
                -> asArray()->all()
                (new Query())->select(['cd_DOsottocommessa as cd_comm', 'descrizione as desk'])->from('DOSottoCommessa')
                ->where(['cd_DOsottocommessa' => $elecommesse])

                ->all(Yii::$app->db2)

                , 'cd_comm', 'desk'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'descrizione'],

        ],
  */
      //  'moduli',
        ['header' => 'Moduli',
 'attribute' => 'moduli',
        //'contentFormats'=> ['decimal',2],
    //    'class'=>'\kartik\grid\DataColumn',
             'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black',
             'style'=>'color: black;'],
       //     'vAlign' => 'middle',
            'width' => '20%',
   'format'=>'integer',
    'pageSummary' => true,
],
       // 'przmedio',
/*['header' => 'Prezzo Medio',
 'attribute' => 'przmedio',
        //'contentFormats'=> ['decimal',2],
        'class'=>'\kartik\grid\DataColumn',
             'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black',
             'style'=>'color: black; width: 15%;'],
            'vAlign' => 'middle',
            'width' => '20%',
   'format'=>'currency',
    'pageSummary' => true,

],
*/
        //'prezzovendita',
        ['header' => 'Prezzo Vendita',
 'attribute' => 'prezzovendita',
        //'contentFormats'=> ['decimal',2],
        'class'=>'\kartik\grid\DataColumn',
             'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
            'vAlign' => 'middle',
            'width' => '40%',
  //'value'=> function ($model, $key, $index, $widget) {
    //            return 
  //    /          number_format((float) $model->prezzovendita, 2, ',', '.');
//
 //           },
             'format'=>'currency',
     
    'pageSummary' => true,
],
    ], 'panel' => [
        'type' => $ris['grid_color'],
        'heading' => '<i class="fas  fa-book"></i> Pubblicazioni  ',
    ],
    'responsive' => true,
    //'resizableColumns' => true,
    'showPageSummary' => true,
   // 'pjax' => false,
]);?>

    <?php Pjax::end();?>

</div>
<script>
$( document ).ready(function() {
    console.log( "ready!" );
 // $(document).html(function(i, html){
 //   return html.replace("TOTALE", "cane");
//});  
 $('div').contents().filter(function(){
       return this.nodeType == Node.TEXT_NODE && this.textContent.trim()=='€';
     }).remove();
     $tm= $('.highlighted1').text()
     console.log($tm);
     $('.highlighted1').text()=$tm+"€";
 //$(document).html().replace('1','fff');

});
</script>