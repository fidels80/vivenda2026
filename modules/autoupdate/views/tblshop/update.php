

<?php 
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\autoupdate\models\Tblbrand;
use app\modules\autoupdate\models\TblGroup;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\TlbShop */
/* @var $form yii\widgets\ActiveForm */
$brd = TblBrand::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listbrd = ArrayHelper::map($brd, 'id', 'Name');
$grp=TblGroup::find()
        ->select(['id as id', 'desk as  Name'])
        ->where(['brand_id'=>$model['brand_id']])
        ->asArray()
        ->all();
$listgrp = ArrayHelper::map($grp, 'id', 'Name');
$this->title = 'Update negozio: ' . $model->desk;
$this->params['breadcrumbs'][] = ['label' => 'Tlb Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';?>

<div class="tlb-shop-form">
<h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true ,'readOnly'=>true]) ?>

    <?= $form->field($model, 'desk')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'numcassa')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'brand_id')->widget(Select2::classname(), ['name' => 'brand', 'data' => $listbrd,
                            'options' => ['placeholder' => 'Seleziona azienda ...',],
                            'pluginOptions' => [
                                'allowClear' => false,
                                'disabled'=>true,
                            ],
                        ])->label('azienda'); ?>

    <?= $form->field($model, 'spec_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_grp_id')->widget(Select2::classname(),['name' => 'grp_id', 'data' => $listgrp,
                            'options' => ['placeholder' => 'Seleziona gruppo ...',],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Gruppi');  
     
                        ?>
    <?= $form->field($model, 'flag')->checkbox(['label' => 'Attivo']) ?>
<?= $form->field($model, 'version')->textInput(['maxlength' => true,'readOnly'=>true]) ?>
  <?= $form->field($model, 'upd')->checkbox(['label' => 'Aggiornamento Scaricato']) ?>
    <?= $form->field($model, 'data_up')->textInput(['maxlength' => true,'readonly'=>true]) ?>
<?= $form->field($model, 'licenza')->checkbox(['label' => 'Licenza Attiva']) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

