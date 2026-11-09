<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\autoupdate\models\TblBrand;
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
        ->asArray()
        ->all();
$listgrp = ArrayHelper::map($grp, 'id', 'Name');
$datac = TblGroup::find()
        ->select(['id as value', 'desk as label', 'id as id'])
        ->asArray()
        ->all();
?>

<div class="tlb-shop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desk')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'numcassa')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'brand_id')->widget(Select2::classname(), ['name' => 'brand', 'data' => $listbrd,
                            'options' => ['placeholder' => 'Seleziona azienda ...','id' => 'lvl-0'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('azienda'); ?>

    <?= $form->field($model, 'spec_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_grp_id')->
                      /*          widget(Select2::classname(), ['name' => 'brand', 'data' => $listgrp,
                            'options' => ['placeholder' => 'Seleziona gruppo ...',],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Gruppi'); */
                                widget(DepDrop::classname(), [
                'data' => $datac,
                'options' => ['placeholder' => 'carico ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => true],'value' =>[ $model->brand_grp_id]],
                'pluginOptions' => [
                    'depends' => ['lvl-0'],
                    'url' => Url::to(['/tblgroup/list']),
                    //   'params' => ['lvl-0'],
                    'loadingText' => 'caricamento dati ...',
                ]
            ]);
       //     */
                        ?>
    <?= $form->field($model, 'flag')->checkbox(['label' => 'Attivo']) ?>
<?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model, 'upd')->checkbox(['label' => 'Aggiornamento Scaricato']) ?>
    <?= $form->field($model, 'data_up')->textInput(['maxlength' => true,'readonly'=>true]) ?>
    <?= $form->field($model, 'licenza')->checkbox(['label' => 'Licenza Attiva']) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
