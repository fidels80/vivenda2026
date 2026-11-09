<?php

use app\models\allfiles;
use app\models\Anacli;
use app\models\doc_rows;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$usrid = Yii::$app->user->Id;
$usr_ris = null;
if ($usrid !== null) {
    $usr_ris = (new \yii\db\Query())
        ->select(['email', 'gruppo', 'cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}

$settaconf = 0;
foreach ($model->rowsall as $value) {
    $query2 = (new \yii\db\Query())
        ->select(['f_row'])
        ->from('doc_rows')
        ->where(['f_row' => $value->xid_riga])
        ->one();

    if (isset($query2['f_row'])) {
        $settaconf = 1;
    }
}
if ($settaconf == 1) {
    $model->setAttribute('confermato', 1);
}

if ($model->cd_doc == 'FTV' || $model->cd_doc == 'FTE') {
    $model->setAttribute('confermato', 1);
}

$this->title = Html::encode($model->cd_doc . ' Num: ' . $model->numdoc . ' del ' . $model->data);
$this->params['breadcrumbs'][] = ['label' => 'Elenco Documenti', 'url' => ['index']];
\yii\web\YiiAsset::register($this);
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<div class="doc-head-view">

    <div class="card shadow-sm mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-file-invoice"></i> <?= $this->title ?></h3>
            <?php if ($model->confermato == 1): ?>
                <span class="badge badge-success"><i class="fas fa-check"></i> Documento Confermato</span>
            <?php elseif ($model->rifiutato == 1): ?>
                <span class="badge badge-danger"><i class="fas fa-times"></i> Documento Rifiutato</span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php if ($model->confermato != 1 && $model->rifiutato != 1): ?>
                <?php if ($usr_ris['gruppo'] != 'users'): ?>
                <div class="d-flex flex-wrap" style="gap: 0.5rem;">
                    <?php
                    $tmpid = 2;
                    Modal::begin([
                        'id' => 'cli' . $tmpid,
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                    $this->registerJs("
                      $('#modalcli_$tmpid').click(function (){
                        $('#cli$tmpid').modal('show').find('#modalContent').load($(this).attr('value'));
                      });");
                    $url = Url::to(['sede', 'id' => $model->id]);
                    echo Html::button('<i class="fas fa-exchange-alt"></i> Cambia Intestatario', [
                        'value' => $url,
                        'class' => 'btn btn-warning',
                        'id' => 'modalcli_' . $tmpid,
                    ]);

                    $tmpid = 3;
                    Modal::begin([
                        'id' => 'cli' . $tmpid,
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                    $this->registerJs("
                      $('#modalcli_$tmpid').click(function (){
                        $('#cli$tmpid').modal('show').find('#modalContent').load($(this).attr('value'));
                      });");
                    $url = Url::to(['nannota', 'id' => $model->id]);
                    echo Html::button('<i class="fas fa-sticky-note"></i> Aggiungi Nota', [
                        'value' => $url,
                        'class' => 'btn btn-info',
                        'id' => 'modalcli_' . $tmpid,
                    ]);

                    $tmpid = 1;
                    Modal::begin([
                        'id' => 'cli' . $tmpid,
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                    $this->registerJs("
                      $('#modalcli_$tmpid').click(function (){
                        $('#cli$tmpid').modal('show').find('#modalContent').load($(this).attr('value'));
                      });");
                    $url = Url::to(['nrifiuta', 'id' => $model->id]);
                    echo Html::button('<i class="fas fa-times"></i> Rifiuta', [
                        'value' => $url,
                        'class' => 'btn btn-danger',
                        'id' => 'modalcli_' . $tmpid,
                    ]);

                    echo Html::beginForm(['conferma', 'id' => $model->id], 'post', ['class' => 'd-inline', 'id' => 'form-conferma']);
                    echo Html::submitButton('<i class="fas fa-check"></i> Conferma', [
                        'class' => 'btn btn-success',
                        'id' => 'btn-conferma',
                        'data-no-confirm' => true,
                    ]);
                    echo Html::endForm();
                    ?>
                </div>
                <?php else: ?>
                    <div class="text-muted">Documento in attesa di conferma.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Dettaglio Documento</h3>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => '',
                                'label' => 'Richiedente',
                                'value' => function ($model) {
                                    $ints = yii::$app->db2
                                        ->createCommand('select top 1 dotes.cd_cf,dotes.Cd_CF,dotes.Cd_CFSede,dotes.Cd_CFDest,
                                            dotes.numerodoc,1,CFSede.Descrizione,CFSede.EMail as sdMail,
                                            CFContatto.email as cfcemail,cfcontatto.emailpec
                                            from dotes
                                            left join CFSede on CFSede.Cd_Cf=dotes.Cd_CF and CFSede.Cd_CFSede=dotes.Cd_CFSede
                                            left join CFContatto on CFContatto.Cd_CF=dotes.Cd_CF and CFContatto.Cd_CFDest=dotes.Cd_CFDest
                                            where dotes.id_dotes=:id_Dotes')
                                        ->bindValues([':id_Dotes' => $model->xid_testa]);
                                    $intesta = $ints->queryAll();
                                    try {
                                        $richiedente = (new \yii\db\Query())
                                            ->select(['email'])
                                            ->from('user')
                                            ->where(['email' => $intesta[0]['sdMail']])
                                            ->orWhere(['email' => $intesta[0]['cfcemail']])
                                            ->orWhere(['email' => $intesta[0]['emailpec']])
                                            ->one();
                                        return $richiedente['email'] ?? null;
                                    } catch (Exception $e) {
                                        return null;
                                    }
                                },
                            ],
                            'cd_doc',
                            'data',
                            'numdoc',
                            [
                                'attribute' => 'cd_cli',
                                'value' => function ($model) {
                                    $dm = anacli::find()
                                        ->select(['cd_cli', 'Desk as Name'])
                                        ->where(['cd_cli' => $model->cd_cli])
                                        ->asArray()
                                        ->one();
                                    return $dm['cd_cli'] . '-' . $dm['Name'];
                                },
                            ],
                            [
                                'attribute' => 'altcli',
                                'value' => function ($model) {
                                    $dm = anacli::find()
                                        ->select(['Desk as Name'])
                                        ->where(['cd_cli' => $model->altcli])
                                        ->asArray()
                                        ->one();
                                    return $dm['Name'] ?? null;
                                },
                            ],
                            'cd_pg',
                            'sconto',
                            'note',
                            'xnota',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-paperclip"></i> File</h3>
                    <?php
                    $tmpid = 0;
                    Modal::begin([
                        'id' => 'cli' . $tmpid,
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                    $this->registerJs("
                      $('#modalcli_$tmpid').click(function (){
                        $('#cli$tmpid').modal('show').find('#modalContent').load($(this).attr('value'));
                      });");
                    $url = Url::to(['allfiles/ajupd', 'xid_testa' => $model->xid_testa, 'tab' => 'DOTES']);
                    if ($model->confermato != 1 && $model->rifiutato != 1 && $usr_ris['gruppo'] != 'users') {
                        echo Html::button('<i class="fas fa-upload"></i> Carica File', [
                            'value' => $url,
                            'class' => 'btn btn-success btn-sm',
                            'id' => 'modalcli_' . $tmpid,
                        ]);
                    }
                    ?>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-sm mb-0">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th style="width:60px;">Origine</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model->filesall as $value): ?>
                                <?php if ($value['entita'] == 'DOTES'): ?>
                                    <tr>
                                        <td>
                                            <?= Html::a($value['nomefile'], [
                                                'allfiles/genfile',
                                                'id' => $value['id'],
                                                'file' => str_replace(' ', '_', $value['nomefile']),
                                            ]) ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($value['origine'] == 'S'): ?>
                                                <?= Yii::$app->fontawesome->name('user', 'solid')->fill('#003865') ?>
                                            <?php else: ?>
                                                <?= Yii::$app->fontawesome->name('server', 'solid')->fill('#003865') ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if (count($model->filesall) == 0): ?>
                                <tr><td colspan="2" class="text-muted">Nessun file</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> Righe Documento</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm mb-0">
                    <thead>
                        <tr>
                            <th style="width:50px;">Evaso</th>
                            <th style="width:250px;">Descrizione</th>
                            <?php
                            $usrcfid = $usr_ris['cd_cli'];
                            $cfprice = Anacli::find()->select(['showprices', 'show_ins_nrgaz'])->where(['cd_cli' => $usrcfid])->one();
                            if ($usrcfid <> 'C004207') {
                                echo '<th>Data Pubblicazione</th>';
                            } else {
                                echo '<th>Editore</th>';
                            }
                            if ($cfprice['show_ins_nrgaz'] == 1) {
                                echo '<th>Nr. Gazzetta</th>';
                                echo '<th>Nr. Inserzione</th>';
                            }
                            if ($cfprice['showprices'] == 1) {
                                if ($usrcfid <> 'C004207') {
                                    echo '<th>U.M.</th>';
                                }
                                echo '<th style="width:50px;">Qta</th>';
                                echo '<th style="width:100px;">Prz.Unit</th>';
                                echo '<th style="width:100px;">Prezzo Tot</th>';
                                echo '<th style="width:20px;">Sconto</th>';
                                echo '<th style="width:100px;">Prezzo Scont.</th>';
                                echo '<th style="width:50px;">Al. Iva</th>';
                                if ($usrcfid == 'C004207') {
                                    echo '<th style="width:100px;">Prezzo Ivato</th>';
                                }
                            }
                            echo '<th>File</th>';
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->rowsall as $value): ?>
                            <tr>
                                <td class="text-center">
                                    <?php if (!is_null($value['f_row'])): ?>
                                        <?php
                                        $eva = doc_rows::find()->where(['xid_riga' => $value['f_row']])->one();
                                        echo Html::a(
                                            Yii::$app->fontawesome->name('arrow-left', 'solid')->fill('#003865'),
                                            ['doc_head/view', 'id' => $eva['doc_head_id']]
                                        );
                                        ?>
                                    <?php else: ?>
                                        <?= Yii::$app->fontawesome->name('hourglass', 'solid')->fill('#003865') ?>
                                    <?php endif; ?>
                                    ||
                                    <?php
                                    $eva = doc_rows::find()->where(['f_row' => $value['xid_riga']])->one();
                                    if (isset($eva['doc_head_id'])) {
                                        echo Html::a(
                                            Yii::$app->fontawesome->name('arrow-right', 'solid')->fill('#003865'),
                                            ['doc_head/view', 'id' => $eva['doc_head_id']]
                                        );
                                    } else {
                                        echo Yii::$app->fontawesome->name('hourglass', 'solid')->fill('#003865');
                                    }
                                    ?>
                                </td>
                                <td><?= $value['descrizione'] ?></td>
                                <?php
                                $xarts = yii::$app->db2
                                    ->createCommand('select * from ADB_VIVENDASRL.dbo.ar where cd_ar=:art')
                                    ->bindValues([':art' => $value['cd_art']]);
                                $txarts = $xarts->queryAll();

                                if ($usrcfid <> 'C004207') {
                                    echo '<td>';
                                    if ($value['cd_doc'] <> 'FTV') {
                                        if (date("d/m/Y", strtotime($value['datacons'])) <> '01/01/1970') {
                                            echo date("d/m/Y", strtotime($value['datacons']));
                                        }
                                    }
                                    echo '</td>';
                                } else {
                                    echo '<td>';
                                    if (isset($txarts[0]['Cd_ARMarca'])) {
                                        echo $txarts[0]['Cd_ARMarca'];
                                    }
                                    echo '</td>';
                                }

                                if ($cfprice['show_ins_nrgaz'] == 1) {
                                    echo '<td>' . ($value['nrgazzetta'] ?? '') . '</td>';
                                    echo '<td>' . $value['nrinserzione'] . '</td>';
                                }

                                $ints = yii::$app->db2
                                    ->createCommand('select dorig.*,round((dorig.PrezzoTotaleV/100)*Aliquota.Aliquota,2) as ivadaagg
                                        from ADB_VIVENDASRL.dbo.dorig
                                        left join aliquota on aliquota.cd_aliquota=dorig.cd_aliquota
                                        where id_dorig=:id_dorig')
                                    ->bindValues([':id_dorig' => $value['xid_riga']]);
                                $prz = $ints->queryAll();

                                if ($cfprice['showprices'] == 1) {
                                    if ($usrcfid <> 'C004207') {
                                        echo '<td>' . $value['um'] . '</td>';
                                    }
                                    echo '<td>' . number_format($value['qta'], 2) . '</td>';
                                    echo '<td>';
                                    if (isset($prz[0]['PrezzoUnitarioV'])) {
                                        echo number_format($prz[0]['PrezzoUnitarioV'], 2, ',', '.') . ' €';
                                    }
                                    echo '</td>';
                                    echo '<td>';
                                    if (isset($prz[0]['PrezzoUnitarioV'])) {
                                        echo number_format($value['qta'] * $prz[0]['PrezzoUnitarioV'], 2, ',', '.') . ' €';
                                    }
                                    echo '</td>';
                                    echo '<td>';
                                    if (isset($prz[0]['ScontoRiga'])) {
                                        echo $prz[0]['ScontoRiga'] . '%';
                                    }
                                    echo '</td>';
                                    echo '<td>' . number_format($value['prezzo'], 2, ',', '.') . ' €</td>';
                                    echo '<td>' . $value['iva'] . '</td>';
                                    if ($usrcfid == 'C004207') {
                                        echo '<td>' . number_format($value['prezzo'] + $prz[0]['ivadaagg'], 2, ',', '.') . ' €</td>';
                                    }
                                }

                                echo '<td>';
                                if ($usr_ris['cd_cli'] <> 'C001443') {
                                    $subvalue = allfiles::find()
                                        ->where(['entita' => 'DORIG'])
                                        ->andWhere(['id_padre' => $value->xid_riga])
                                        ->one();
                                    if (isset($subvalue['nomefile'])) {
                                        echo Html::a($subvalue['nomefile'], [
                                            'allfiles/genfile',
                                            'id' => $subvalue['id'],
                                            'file' => str_replace(' ', '_', $subvalue['nomefile']),
                                        ]);
                                    }
                                } else {
                                    $subvalue = allfiles::find()
                                        ->where(['entita' => 'DORIG'])
                                        ->andWhere(['id_padre' => $value->xid_riga])
                                        ->one();
                                    if (isset($subvalue['nomefile'])) {
                                        echo Html::a(
                                            strstr($subvalue['nomefile'], '_', true) . '_' . str_replace(' ', '_', $value['descrizione']),
                                            [
                                                'allfiles/genfile',
                                                'id' => $subvalue['id'],
                                                'file' => strstr($subvalue['nomefile'], '_', true) . '_' . str_replace(' ', '_', $value['descrizione']),
                                            ]
                                        );
                                    }
                                }
                                echo '</td>';
                                ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php
if ($model->confermato == 1) {
    $this->registerJs("Swal.fire({toast:true, position:'top-end', icon:'success', title:'Documento Confermato!', showConfirmButton:false, timer:4000});");
} elseif ($model->rifiutato == 1) {
    $this->registerJs("Swal.fire({toast:true, position:'top-end', icon:'error', title:'Documento Rifiutato!', showConfirmButton:false, timer:4000});");
}

$this->registerJs("
$('#btn-conferma').on('click', function(e){
    var btn = this;
    if ($(btn).data('swal-ok')) { return; }
    e.preventDefault();
    Swal.fire({
        title: 'Conferma documento',
        text: 'Sei sicuro di voler CONFERMARE il documento?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sì, conferma',
        cancelButtonText: 'Annulla',
        confirmButtonColor: '#28a745'
    }).then(function(result){
        if (result.isConfirmed) {
            $(btn).data('swal-ok', true).trigger('click');
        }
    });
});
", \yii\web\View::POS_READY);
