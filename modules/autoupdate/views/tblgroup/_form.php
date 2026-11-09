<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TblBrand;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
$brd = TblBrand::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listbrd = ArrayHelper::map($brd, 'id', 'Name');
/* @var $this yii\web\View */
/* @var $model app\models\TblGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_id')->widget(Select2::classname(), ['name' => 'brand', 'data' => $listbrd,
                            'options' => ['placeholder' => 'Seleziona azienda ...',],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('azienda'); ?>

    <?= $form->field($model, 'grp_path')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'flag')->checkbox(['label' => 'Attivo']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
