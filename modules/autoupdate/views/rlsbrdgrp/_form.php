<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\select2\Select2;
use app\models\TblBrand;
use app\models\TblGroup;

/* @var $this yii\web\View */
/* @var $model app\models\Rlsbrdgrp */
/* @var $form yii\widgets\ActiveForm */
$brd = TblBrand::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listbrd = ArrayHelper::map($brd, 'id', 'Name');
$grp=TblGroup::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listgrp = ArrayHelper::map($grp, 'id', 'Name');
?>

<div class="rlsbrdgrp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'brand_id')->widget(Select2::classname(), ['name' => 'brand', 'data' => $listbrd,
                            'options' => ['placeholder' => 'Seleziona azienda ...',],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Azienda'); ?>

    <?= $form->field($model, 'group_id')->widget(Select2::classname(), ['name' => 'brand', 'data' => $listgrp,
                            'options' => ['placeholder' => 'Seleziona Gruppo ...',],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Gruppo'); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
