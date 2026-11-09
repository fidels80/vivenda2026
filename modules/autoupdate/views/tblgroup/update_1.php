<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TblBrand;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Tblshop;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
$brd = TblBrand::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listbrd = ArrayHelper::map($brd, 'id', 'Name');

$shp= 
        new ActiveDataProvider([
      'query' => 
        Tblshop::find()
        ->select(['id','code','desk','flag','upd','data_up'])
        ->where(['brand_id'=>$model['brand_id']])
        ->andwhere(['brand_grp_id'=>$model['id']])
     //   ->asarray()
        ]);
/* @var $this yii\web\View */
/* @var $model app\models\TblGroup */

$this->title = 'Update Tbl Group: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

<div class="tbl-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'desk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_id')->widget(Select2::classname(), ['name' => 'brand', 'data' => $listbrd,
                            'options' => ['placeholder' => 'Seleziona azienda ...',],
                            'pluginOptions' => [
                                'allowClear' => true,'readonly'=>true
                            ],
                        ])->label('azienda'); ?>

    <?= $form->field($model, 'grp_path')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'flag')->checkbox(['label' => 'Attivo']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

     
    
    <?= GridView::widget([
        'dataProvider' => $shp,
        //'filterModel' => $searchModel,
        'columns' => [
         
            'code',
            [  'attribute'=>'desk',
                'label'=>'Descrizione'],
            [  'attribute'=>'flag',
                'label'=>'Aggiornamento_specifico_PV'],
            [  'attribute'=>'upd',
                'label'=>'Aggiornamento_scaricato'],
            [  'attribute'=>'data_up',
                'label'=>'Data Download aggiornamento'],
            [
                'format' => 'raw',

                'value' => function($data) {
                return Html::a('modifica',['tblshop/update','id' => $data['id'] ]);
  

                }

            ]
       
            
            
            ],
    ]); ?>
</div>

 
