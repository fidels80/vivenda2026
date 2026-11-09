<?php

use app\models\user;
use kartik\grid\GridView;
//use app\model\Site;
use kartik\export\ExportMenu;

use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;

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


$gridColumns=[

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

        ],
        

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
        ['header' => 'Prezzo Vendita',
 'attribute' => 'prezzovendita',
        //'contentFormats'=> ['decimal',2],
        'class'=>'\kartik\grid\DataColumn',
             'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-black'],
            'vAlign' => 'middle',
            'width' => '40%',
  'value'=> function ($model, $key, $index, $widget) {
                return 
                number_format((float) $model->prezzovendita, 2, ',', '.');

            },
            // 'format'=>'currency',
     
    'pageSummary' => true,
        ]];

$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target' => ExportMenu::TARGET_BLANK,
    'pjaxContainerId' => 'kv-pjax-container',
    'showConfirmAlert' => false,
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
    'persistResize' => true,
    'resizeStorageKey' => Yii::$app->user->id . '-' . date('m') . 'sc',
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
       
            ],
    'columns' => $gridColumns,
     'panel' => [
        'type' => $ris['grid_color'],
        'heading' => '<i class="fas  fa-book"></i> Pubblicazioni per Marca',
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