<?php


use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\select2\Select2;
use app\models\TblBrand;
use app\models\Tblshop;


$brd = TblBrand::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listbrd = ArrayHelper::map($brd, 'id', 'Name');
$shp=Tblshop::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listshp = ArrayHelper::map($shp, 'id', 'Name');
/* @var $this yii\web\View */
/* @var $model app\models\Rlsbrdshp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rlsbrdshp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'brand_id')->widget(Select2::classname(), ['name' => 'brand', 'data' => $listbrd,
                            'options' => ['placeholder' => 'Seleziona azienda ...',],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('azienda'); ?>

    <?= $form->field($model, 'shop_id')->widget(Select2::classname(), ['name' => 'brand', 'data' => $listshp,
                            'options' => ['placeholder' => 'Seleziona gruppo ...',],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('NEgozi'); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
