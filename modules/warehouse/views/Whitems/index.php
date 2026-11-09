<?php
use app\modules\warehouse\models\whitems;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView as kgrid;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\WhitemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Whitems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="whitems-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Whitems', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  echo  kgrid::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'striped' => true,
        'hover' => true,
        'panel' => ['type' => 'primary', 'heading' => 'Items'],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

        //    'id',
            
            [
                'attribute' => 'code', 
                'width' => '250px',
                'value' => function ($data) {
                    $tmp=whitems::find() ->where(['id'=>$data['id']]) ->one();       
            if (isset($tmp['code'])){
                    return $tmp->code;
                            }else{
                            return '';}
                    } ,
                'filterType' => kgrid::FILTER_SELECT2,
                'filter' => ArrayHelper::map(whitems::find()->orderBy('id')->asArray()->all(), 'code', 'code'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Any category']
            ],
            [
                'attribute' => 'desk', 
                'width' => '250px',
                'value' => function ($data) {
                    $tmp=whitems::find() ->where(['id'=>$data['id']]) ->one();       
            if (isset($tmp['desk'])){
                    return $tmp->desk;
                            }else{
                            return '';}
                    } ,
                'filterType' => kgrid::FILTER_SELECT2,
                'filter' => ArrayHelper::map(whitems::find()->orderBy('id')->asArray()->all(), 'desk', 'desk'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Any category']
            ],
            
            'prop:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
