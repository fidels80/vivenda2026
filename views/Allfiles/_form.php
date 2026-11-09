<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Allfiles */
/* @var $form yii\widgets\ActiveForm */
$request = Yii::$app->request;
$get = $request->get();
?>

<div class="allfiles-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_padre')->textInput(['value' => $get['xid_testa'], 'hidden' => true])->label('') ?>

    <?php $form->field($model, 'origine')->textInput(['hidden' => true])->label('') ?>

    <?= $form->field($model, 'entita')->textInput([
        'maxlength' => true,
        'value' => $get['tab'],
        'hidden' => true,
    ])->label('') ?>

    <?= $form->field($model, 'files[]')->fileInput(['multiple' => true])->label('Seleziona File') ?>

    <div class="form-group">
        <?= Html::submitButton('Carica', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
(function () {
    if (typeof Swal === 'undefined') { return; }
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: 'La finestra si chiuderà da sola quando i file saranno inviati',
        showConfirmButton: false,
        timer: 4000
    });
})();
</script>
