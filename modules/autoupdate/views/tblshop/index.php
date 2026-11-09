<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\TblBrand;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\modules\autoupdate\models\TblGroup;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TlbShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$listdatas = ['1' => 'Si',
    '0' => 'No',
];
$this->title = 'negozi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tlb-shop-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea Negozio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            'code',
            'desk',
            [
                'attribute'=>'brand_id',
                'label'=>'Azienda',
                'filter'=>ArrayHelper::map(TblBrand::find()->asArray()->all(), 'id', 'desk'),//array("M"=>"M","F"=>"F"), // you can read from database directly
                'value' => function ($data) {
        $tmp=TblBrand::find() ->where(['id'=>$data['brand_id']]) ->one();       
if (isset($tmp['desk'])){
        return $tmp->desk;
                }else{
                return '';}
        }
            ],
                    [
                'attribute'=> 'brand_grp_id',
                'label'=>'Gruppi',
                'filter'=>ArrayHelper::map(TblGroup::find()->asArray()->all(), 'id', 'desk'),//array("M"=>"M","F"=>"F"), // you can read from database directly
                'value' => function ($data) {
        $tmp=TblGroup::find() ->where(['id'=>$data['brand_grp_id']]) ->one();       
         if (isset($tmp['desk'])   ) { 
        return $tmp->desk;
         }else {return '';}
        
        }
            ],
            'spec_path',
                      [
            'class' => 'yii\grid\CheckboxColumn',
            'header' =>'Aggiornamento_scaricato',
            'visible'=> true,
            
            'contentOptions' =>['style' => 'vertical-align:middle;width:30px'],

                'checkboxOptions' => function($model, $key, $index, $column)   {

             $bool =  $model->upd ;
             return ['checked' => $bool,'disabled'=>true];
                }
             ],
[
            'class' => 'yii\grid\CheckboxColumn',
            'header' =>'Aggiornamento_specifico_PV',
            'visible'=> true,
              
    'contentOptions' =>['style' => 'vertical-align:middle;width:30px'],

                'checkboxOptions' => function($model, $key, $index, $column)   {
            Yii::$app->session->setFlash('success', $model->desk );
             $bool =  $model->flag ;
                        
             return ['checked' => $bool,   'disabled'=>true];
                }
                
             ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
