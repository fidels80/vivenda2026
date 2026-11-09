<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Xaction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
$lxact = Xaction::find()
        ->select(['id as id', 'TIpo as  Name'])
        ->asArray()
        ->all();
$listxact = ArrayHelper::map($lxact, 'id', 'Name');

/* @var $this yii\web\View */
/* @var $model app\models\Xmenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xmenu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'voce')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'azione')->widget(Select2::classname(), ['data' => $listxact,
                            'options' => ['placeholder' => 'Seleziona azione ...', ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Azione'); ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'url')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
