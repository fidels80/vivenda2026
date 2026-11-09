<?php
use app\controllers\RelusrformactionController;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\xmenu;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
$lxact = xmenu::find()
        ->select(['id as id', 'voce as  Name'])
        ->asArray()
        ->all();
$listxact = ArrayHelper::map($lxact, 'id', 'Name');
/* @var $this yii\web\View */
/* @var $model app\models\Xsubmenu */
/* @var $form yii\widgets\ActiveForm */
$t=RelusrformactionController::Getcontroller();
$perms=array_keys($t)    ;
$perms=str_replace('Controller', '', $perms);
$result = ArrayHelper::index($perms, 'id');
$result=[];
foreach( $perms as $valore)  
   {  
   $result[strtolower("/".$valore)] = "/".strtolower($valore);
   }  
?>

<div class="xsubmenu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'voce')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'azione')->textInput() ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'url')->widget(Select2::classname(), ['data' => $result,
                            'options' => ['placeholder' => 'Seleziona pagina da aprire ...', ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Url');  ?>

    <?= $form->field($model, 'id_menu')->widget(Select2::classname(), ['data' => $listxact,
                            'options' => ['placeholder' => 'Seleziona Menu padre ...', ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Menu Padre');  ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
