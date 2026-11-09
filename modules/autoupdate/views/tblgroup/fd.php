<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 use kartik\sortinput\SortableInput;
use yii\helpers\Html;
use app\models\TblBrand;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use app\models\tlbshop;
use kartik\sortable\Sortable;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\TblGroup;

$brd = TblBrand::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listbrd = ArrayHelper::map($brd, 'id', 'Name');
//$model=TblGroup::find()->where('1=2')->one();

$grp = TblGroup::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listgrp = ArrayHelper::map($grp, 'id', 'Name');
?>

<div class="tbl-group-form">
    <?php echo "form in test usare con cautela!!";?>
<?php $form = ActiveForm::begin(); ?>

    
     <?=
        $form->field($model, 'id')->widget(Select2::classname(), ['name' => 'grp', 'data' => $listgrp,
            'options' => ['placeholder' => 'Seleziona gruppo ...',],
            'pluginOptions' => [
                'allowClear' => true, 'readonly' => true
            ],
        ])->label('Gruppo');
        ?>
     <?= Html::submitButton('Forza Download', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Update', ['forzadown', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php $form = ActiveForm::end(); ?>
</div>