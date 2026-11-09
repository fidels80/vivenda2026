<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\xsubmenu;

use kartik\select2\Select2;
use app\models\xmenu;

/* @var $this yii\web\View */
/* @var $model app\models\Usrgrp */
/* @var $form yii\widgets\ActiveForm */
$moduli= xmenu::find()
     ->select(['voce as id', 'voce as  Name'])
      ->where(['>','len(voce)',1])
      ->andwhere(['<','level',100])
      ->AsArray()
      ->all();  
$smoduli = xsubmenu::find()
    ->select(['voce as id', 'voce as  Name'])
    ->where(['>', 'len(voce)', 1])
     ->andwhere(['<','level',100])
    ->AsArray()
    ->all();
$xmenus=array_merge($moduli,$smoduli);
 
$lst_menu=ArrayHelper::map($xmenus,'id','Name');
?>

<div class="usrgrp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descrizione')->textInput(['maxlength' => true]) ?>


<?php $row = unserialize($model->moduli);

//explode("|",$model->moduli);

echo $form->field($model, 'moduli', ['enableClientValidation' => false])->
    widget(Select2::classname(), [
    'data' => $lst_menu,

    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona gruppo ...', 'multiple' => true,
        'tags' => true,
        'value' => $row,
        'maximumInputLength' => 10,

    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);
$row = unserialize($model->reports);

// explode("|", $model->reports);
yii::error($row);
echo $form->field($model, 'reports', ['enableClientValidation' => false])->
    widget(Select2::classname(), [
    'data' => $data,

    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona gruppo ...', 'multiple' => true,
        'tags' => true,
        'value' => $row,
        'maximumInputLength' => 10,

    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);
?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
