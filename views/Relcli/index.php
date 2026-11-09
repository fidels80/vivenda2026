<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\models\anacli;
$x = Yii::$app->runAction('site/getexp');
$icon = new \thoulah\fontawesome\Icon();

/* @var $this yii\web\View */
/* @var $searchModel app\models\RelcliSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Relazioni Clienti';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relcli-index">

    <h1> </h1>

    <p>
        <?= Html::a('Crea Relazioni', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    //'filterUrl' => ['Doc_headSearch[cd_doc]',
    //'cd_doc' => 'orc'],
    'autoXlFormat' => true,
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
            'cssFile'=>'https: //use.fontawesome.com/releases/v5.3.1/css/all.css',
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
                'subject' => Yii::t('kvgrid', 'PDF'),
                'keywords' => Yii::t('kvgrid', 'krajee, grid, export, yii2-grid, pdf')
            ],
            'contentBefore'=>'',
            'contentAfter'=>''
        ]
    ],
    ],

    'columns' => [        [
            'attribute' => 'cd_cli',
            'visible'=>true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white'],
            'label' => 'Cliente Padre',
            'format' => 'text',
            'width' => '150px',
            'value' => function ($model, $key, $index, $widget) {
            $tc=  anacli::find()->where(['cd_cli'=>$model->cd_cli])->one();
              
                return $tc->cd_cli.' -' .$tc->Desk;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(anacli::find()
                ->select(['cd_cli', '(cd_cli+\' \'+Desk) as desk'])
               // ->where(['cd_cli' => $eldoc])
                ->orderBy('cd_cli')->
                asArray()->all(), 'cd_cli', 'desk'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'descrizione'],

        ],
         [
            'attribute' => 'altcli',
            'visible'=>true,
            'headerOptions' => ['class' => 'card-header bg-' . $usrgrid . ' text-white'],
            'label' => 'Cliente Figlio',
            'format' => 'text',
            'width' => '150px',
            'value' => function ($model, $key, $index, $widget) {
            $tc=  anacli::find()->where(['cd_cli'=>$model->altcli])->one();
              
                return $tc->cd_cli.' -' .$tc->Desk;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(anacli::find()
                ->select(['cd_cli', '(cd_cli+\' \'+Desk) as desk'])
               // ->where(['cd_cli' => $eldoc])
                ->orderBy('cd_cli')->
                asArray()->all(), 'cd_cli', 'desk'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'descrizione'],

        ],
        
        
        
        ]
]);
?>
</div>
