<?php
use app\modules\warehouse\models\whprop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView as kgrid;
/* @var $this yii\web\View */
/* @var $searchModel app\models\WhpropSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Whprops';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="whprop-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Whprop', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('vedi famiglie', ['_family'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('family',['whprop/family' ]);?>
    </p>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



<?php  echo kgrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
   // 'showPageSummary' => true,
    'pjax' => true,
    'striped' => true,
    'hover' => true,
    'panel' => ['type' => 'primary', 'heading' => 'Items Properties'],
    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'father', 
            'width' => '310px',
            'value' => function ($data) {
                $tmp=whprop::find() ->where(['id'=>$data['father']]) ->one();       
        if (isset($tmp['desk'])){
                return $tmp->desk;
                        }else{
                        return '';}
                }
            ,
            'filterType' => kgrid::FILTER_SELECT2,
            'filter' => ArrayHelper::map(whprop::find()->orderBy('id')->asArray()->all(), 'id', 'desk'), 
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Any supplier'],
            'group' => true,  // enable grouping
        ],
        [
            'attribute' => 'code', 
            'width' => '250px',
            'value' => function ($data) {
                $tmp=whprop::find() ->where(['id'=>$data['id']]) ->one();       
        if (isset($tmp['code'])){
                return $tmp->code;
                        }else{
                        return '';}
                } ,
            'filterType' => kgrid::FILTER_SELECT2,
            'filter' => ArrayHelper::map(whprop::find()->orderBy('id')->asArray()->all(), 'code', 'desk'), 
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Any category']
        ],
        [
            'attribute' => 'desk',
            'value'=>'desk',
           // 'pageSummary' => 'Page Summary',
           // 'pageSummaryOptions' => ['class' => 'text-right'],
        ],
        
    ],
]);?>

    <?php Pjax::end(); ?>

</div>
