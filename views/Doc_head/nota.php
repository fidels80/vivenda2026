<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_head */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-head-form">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => ['class' => 'form'],
    ]); ?>

    <h5>Inserisci / Modifica la Nota</h5>
    <?= $form->field($model, 'id')->textInput(['hidden' => true])->label('') ?>
    <?= $form->field($model, 'xnota')->textarea(['rows' => 6, 'required' => true])->label('Nota') ?>

    <?= Html::submitButton('Salva', ['class' => 'btn btn-info', 'id' => 'btn-salva-nota']) ?>
    <?php ActiveForm::end(); ?>
</div>

<script>
(function () {
    if (typeof Swal === 'undefined') { return; }
    $('#btn-salva-nota').on('click', function (e) {
        var btn = this;
        if ($(btn).data('swal-ok')) { return; }
        e.preventDefault();
        Swal.fire({
            title: 'Conferma nota',
            text: 'Sei sicuro di voler confermare la nota?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sì, salva',
            cancelButtonText: 'Annulla'
        }).then(function (result) {
            if (result.isConfirmed) {
                $(btn).data('swal-ok', true).trigger('click');
            }
        });
    });
})();
</script>
