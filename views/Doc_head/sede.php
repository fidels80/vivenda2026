<?php

use app\models\anacli;
use app\models\CliDest;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$usrid = Yii::$app->user->Id;
$ris = null;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['email', 'cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}

$annmodel = (new \yii\db\Query())
    ->select(['altcli as id', 'Desk as Name'])
    ->from('relcli')
    ->leftJoin('ana_cli', 'relcli.altcli = ana_cli.cd_cli')
    ->where(['relcli.cd_cli' => $ris['cd_cli']])
    ->all();
$listdest = ArrayHelper::map($annmodel, 'id', 'Name');

/* @var $this yii\web\View */
/* @var $model app\models\Doc_head */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-head-form">
    <?php $form = ActiveForm::begin(); ?>

    <h5>Inserisci il Nuovo Intestatario</h5>
    <?= $form->field($model, 'id')->textInput(['hidden' => true])->label('') ?>

    <?= $form->field($model, 'altcli')->widget(Select2::classname(), [
        'data' => $listdest,
        'options' => ['placeholder' => 'Seleziona Intestatario'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Intestatario') ?>

    <?= Html::submitButton('Conferma', ['class' => 'btn btn-success', 'id' => 'btn-conferma-sede', 'data-no-confirm' => true]) ?>
    <?php ActiveForm::end(); ?>
</div>

<script>
(function () {
    if (typeof Swal === 'undefined') { return; }
    $('#btn-conferma-sede').on('click', function (e) {
        var btn = this;
        if ($(btn).data('swal-ok')) { return; }
        e.preventDefault();
        Swal.fire({
            title: 'Cambia intestatario',
            text: 'Sei sicuro di voler confermare il nuovo intestatario?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sì, conferma',
            cancelButtonText: 'Annulla',
            confirmButtonColor: '#28a745'
        }).then(function (result) {
            if (result.isConfirmed) {
                $(btn).data('swal-ok', true).trigger('click');
            }
        });
    });
})();
</script>
