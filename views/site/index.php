<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Commesse';

$elencoUrl = Url::to(['sottocommessa/index']);
?>
<style>
    .commessa-card {
        border: 1px solid #e3e6ea;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: #fff;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .commessa-card .cover {
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: #f0f2f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .commessa-card .cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .commessa-card .body {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .commessa-card .title {
        font-size: 1.1em;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .commessa-card .info {
        font-size: 0.9em;
        color: #555;
        margin-bottom: 4px;
    }
</style>

<div class="row d-flex align-items-center" style="gap: 10px; margin-bottom: 15px;">
    <?= Html::a('<i class="fas fa-list"></i> Elenco completo commesse', $elencoUrl, ['class' => 'btn btn-primary']) ?>
    <div style="flex-grow: 1; max-width: 400px;">
        <input type="text" id="filtro-descrizione" class="form-control form-control-sm" placeholder="Cerca per descrizione...">
    </div>
</div>

<div class="row" id="commesse-grid">
    <?php foreach ($sottocommesse as $sc): ?>
        <?= $this->render('_card', [
            'sc' => $sc,
            'cover' => $coverMap[$sc['Cd_DOSottoCommessa']] ?? null,
        ]) ?>
    <?php endforeach; ?>
</div>

<?php if (empty($sottocommesse)): ?>
    <p class="text-muted">Nessuna commessa trovata.</p>
<?php endif; ?>

<?php
$js = <<<JS
$('#filtro-descrizione').on('keyup', function () {
    var v = $(this).val().toLowerCase();
    $('#commesse-grid .card-wrapper').each(function () {
        var desc = String($(this).data('descrizione')).toLowerCase();
        $(this).toggle(desc.indexOf(v) !== -1);
    });
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
