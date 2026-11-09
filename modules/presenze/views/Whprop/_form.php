<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\warehouse\models\whprop;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Whprop */
/* @var $form yii\widgets\ActiveForm */

$prop = whprop::find()
        ->select(['id as id', 'CONCAT(code,\'  \',desk) as  Name'])
     //   -> andFilterWhere(['like', 'IDAnagrafica', $idaz])
         ->asArray()
        ->all();
$listprop = ArrayHelper::map($prop, 'id', 'Name');


?>

<div class="whprop-form">

    <?php $form = ActiveForm::begin();
     ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desk')->textInput(['maxlength' => true]) ?>

    <?php echo
    $form->field($model, 'father')->widget(Select2::classname(), [
        'data' => $listprop,
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
     ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
