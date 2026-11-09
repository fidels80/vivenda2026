<?php

use yii\helpers\Html;
use yii\helpers\Url;

$cd = $sc['Cd_DOSottoCommessa'];
$descrizione = $sc['Descrizione'];
$codiceStato = trim((string) ($sc['Cd_DOCommessaStato'] ?? ''));
$descrizioneStato = trim((string) ($sc['DescrizioneStato'] ?? ''));
$stato = $descrizioneStato !== '' ? $descrizioneStato : $codiceStato;
$dataInizio = $sc['DataInizio'] ? date('d/m/Y', strtotime($sc['DataInizio'])) : '';
$dataFinePresunta = !empty($sc['DataFinePresunta']) ? date('d/m/Y', strtotime($sc['DataFinePresunta'])) : '';

$url = Url::to(['dorigh-ocp/index', 'Cd_DOSottoCommessa' => $cd]);
?>
<div class="col-lg-4 col-md-6 mb-4 card-wrapper" data-descrizione="<?= Html::encode($descrizione) ?>">
    <div class="commessa-card">
        <div class="cover">
            <?php if (!empty($cover)): ?>
                <img src="<?= Html::encode(Yii::getAlias('@web') . $cover) ?>" alt="Copertina">
            <?php else: ?>
                <img src="<?= Html::encode(Yii::getAlias('@web') . '/images/roma-default.svg') ?>" alt="Roma">
            <?php endif; ?>
        </div>
        <div class="body">
            <div class="title"><?= Html::encode($cd) ?> - <?= Html::encode($descrizione) ?></div>
            <div class="info">Stato: <?= Html::encode($stato) ?></div>
            <div class="info">Data inizio: <?= Html::encode($dataInizio) ?></div>
            <div class="info">Data fine presunta: <?= Html::encode($dataFinePresunta) ?></div>
            <div style="margin-top: auto; padding-top: 15px;">
                <a href="<?= $url ?>" class="btn btn-primary" style="width: 100%; display: block; text-align: center;">
                    Dettagli
                </a>
            </div>
        </div>
    </div>
</div>
