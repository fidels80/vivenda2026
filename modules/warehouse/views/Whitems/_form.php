<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\sortable\Sortable;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Whitems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="whitems-form">

<?php
/*
Modal::begin([
                                'header'=>'<h4>Clienti</h4>',
                                'id' => 'cli'.$tmpid,
                                'size'=>'modal-lg', //classe bootstrap
                                ]);
                                echo "<div id='modalContent'></div>";
                                Modal::end();               
                                $this->registerJs( "
                                $('#modalcli_$tmpid').click(function (){
                                $('#cli$tmpid').modal('show')
                                .find('#modalContent')
                                .load($(this).attr('value'));
                                });"
                                 );
                                 $url=Url::to(['clienti/update','id' => $model->ID]);
                                 echo Html::button('Modifica',['value'=>$url,'class' => 'btn btn-success','id'=>'modalcli_'.$tmpid]);

                                 */?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desk')->textInput(['maxlength' => true]) ?>

    <?php /*$form->field($model, 'prop')->textarea(['rows' => 6])*/ ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
