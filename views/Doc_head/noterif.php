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

    <h5>Inserisci Motivazioni Rifiuto</h5>
    <?= $form->field($model, 'id')->textInput(['hidden' => true])->label('') ?>
    <?= $form->field($model, 'rifiutato_nota')->textarea(['rows' => 6, 'required' => true])->label('Motivazioni Rifiuto') ?>

    <?= Html::submitButton('Rifiuta', ['class' => 'btn btn-danger', 'id' => 'btn-rifiuta']) ?>
    <?php ActiveForm::end(); ?>
</div>

<script>
(function () {
    if (typeof Swal === 'undefined') { return; }
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'warning',
        title: 'Il mancato inserimento delle note prevede il mancato annullamento della richiesta',
        showConfirmButton: false,
        timer: 5000
    });
    $('#btn-rifiuta').on('click', function (e) {
        var btn = this;
        if ($(btn).data('swal-ok')) { return; }
        e.preventDefault();
        Swal.fire({
            title: 'Annulla documento',
            text: 'Sei sicuro di voler ANNULLARE il documento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sì, annulla',
            cancelButtonText: 'Indietro',
            confirmButtonColor: '#dc3545'
        }).then(function (result) {
            if (result.isConfirmed) {
                $(btn).data('swal-ok', true).trigger('click');
            }
        });
    });
})();
</script>
