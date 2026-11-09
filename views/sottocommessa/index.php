<?php

use app\assets\DataTablesAsset;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

DataTablesAsset::register($this);

$this->title = 'Elenco commesse';

$dataUrl = Url::to(['sottocommessa/data']);
$openUrl = Url::to(['dorigh-ocp/index']);
$clientiUrl = Url::to(['sottocommessa/clienti']);
$righeUrl = Url::to(['sottocommessa/righe']);

$this->registerCssFile(Yii::getAlias('@web/plugins/tippy/tippy.css'));
$this->registerJsFile(Yii::getAlias('@web/plugins/tippy/tippy-bundle.umd.min.js'));
?>
<div class="sottocommessa-index">
    <div class="card shadow-sm mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter"></i> Filtri</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 col-sm-6">
                    <label>Data inizio (da)</label>
                    <?= DatePicker::widget([
                        'name' => 'f-datainizio-from',
                        'options' => ['placeholder' => 'gg/mm/aaaa', 'id' => 'f-datainizio-from'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd/mm/yyyy',
                            'todayHighlight' => true,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Data inizio (a)</label>
                    <?= DatePicker::widget([
                        'name' => 'f-datainizio-to',
                        'options' => ['placeholder' => 'gg/mm/aaaa', 'id' => 'f-datainizio-to'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd/mm/yyyy',
                            'todayHighlight' => true,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Data fine (da)</label>
                    <?= DatePicker::widget([
                        'name' => 'f-datafine-from',
                        'options' => ['placeholder' => 'gg/mm/aaaa', 'id' => 'f-datafine-from'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd/mm/yyyy',
                            'todayHighlight' => true,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Data fine (a)</label>
                    <?= DatePicker::widget([
                        'name' => 'f-datafine-to',
                        'options' => ['placeholder' => 'gg/mm/aaaa', 'id' => 'f-datafine-to'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd/mm/yyyy',
                            'todayHighlight' => true,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Cliente</label>
                    <?= Select2::widget([
                        'name' => 'f-cliente',
                        'options' => ['placeholder' => 'Cerca cliente...', 'id' => 'f-cliente'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'ajax' => [
                                'url' => $clientiUrl,
                                'dataType' => 'json',
                                'delay' => 250,
                                'data' => new JsExpression('function(params) { return { q: params.term || "" }; }'),
                                'processResults' => new JsExpression('function(data) { return { results: data.results }; }'),
                                'cache' => true,
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Descrizione</label>
                    <input type="text" id="f-descrizione" class="form-control form-control-sm" placeholder="Descrizione">
                </div>
                <div class="col-md-2 col-sm-6 d-flex align-items-end">
                    <button type="button" id="btn-reset" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table id="sottocommessa-table" class="table table-striped table-bordered table-hover w-100" style="width:100%;">
                <thead>
                    <tr>
                        <th>Sottocommessa</th>
                        <th>Descrizione</th>
                        <th>Cliente</th>
                        <th>Descrizione cliente</th>
                        <th>Data inizio</th>
                        <th>Data fine reale</th>
                        <th>Azione</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php
$js = <<<JS
var openUrl = '{$openUrl}';
var righeUrl = '{$righeUrl}';

var sottocommessaTable = $('#sottocommessa-table').DataTable({
    processing: true,
    serverSide: true,
    order: [[4, 'desc']],
    pageLength: 25,
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
    language: {
        search: 'Cerca:',
        lengthMenu: 'Mostra _MENU_ record',
        info: 'Mostra da _START_ a _END_ di _TOTAL_ record',
        infoEmpty: 'Nessun record',
        infoFiltered: '(filtrati da _MAX_ totali)',
        zeroRecords: 'Nessun risultato trovato',
        paginate: { first: 'Primo', last: 'Ultimo', next: 'Successivo', previous: 'Precedente' }
    },
    ajax: {
        url: '{$dataUrl}',
        type: 'GET',
        data: function (d) {
            d.DataInizioFrom = $('#f-datainizio-from').val();
            d.DataInizioTo = $('#f-datainizio-to').val();
            d.DataFineFrom = $('#f-datafine-from').val();
            d.DataFineTo = $('#f-datafine-to').val();
            d.Cliente = $('#f-cliente').val();
            d.Descrizione = $('#f-descrizione').val();
        }
    },
    columns: [
        { data: 'Cd_DOSottoCommessa' },
        { data: 'Descrizione' },
        { data: 'Cd_CF' },
        { data: 'DescrizioneCF' },
        { data: 'DataInizio' },
        { data: 'DataFineReale' },
        {
            data: 'Cd_DOSottoCommessa', orderable: false, searchable: false, className: 'text-center',
            render: function (data) {
                var sep = openUrl.indexOf('?') !== -1 ? '&' : '?';
                var href = openUrl + sep + 'Cd_DOSottoCommessa=' + encodeURIComponent(data);
                return '<a class="btn btn-xs btn-outline-primary btn-righe" data-cd="' + data + '" href="' + href + '"><i class="fas fa-folder-open"></i> Apri</a>';
            }
        }
    ]
});

$('#f-descrizione').on('keyup', function () {
    clearTimeout(window.sottocommessaTimer);
    window.sottocommessaTimer = setTimeout(function () { sottocommessaTable.ajax.reload(); }, 400);
});

$('#f-datainizio-from, #f-datainizio-to, #f-datafine-from, #f-datafine-to, #f-cliente').on('change', function () {
    sottocommessaTable.ajax.reload();
});

$('#btn-reset').on('click', function () {
    $('#f-datainizio-from, #f-datainizio-to, #f-datafine-from, #f-datafine-to, #f-descrizione').val('');
    $('#f-cliente').val(null).trigger('change');
    sottocommessaTable.search('').ajax.reload();
});

tippy('#sottocommessa-table', {
    target: '.btn-righe',
    allowHTML: true,
    interactive: true,
    placement: 'left',
    theme: 'light-border',
    onShow: function (instance) {
        var cd = instance.reference.getAttribute('data-cd');
        if (instance._loadedCd === cd) { return; }
        instance._loadedCd = cd;
        $.getJSON(righeUrl, { cd: cd }, function (res) {
            var html = '<strong>Righe presenti: ' + res.count + '</strong><hr class="my-1">';
            if (res.righe && res.righe.length) {
                html += '<table class="table table-sm table-striped mb-0"><thead><tr><th>Cliente finale</th><th>Data inizio</th><th>Data fine</th></tr></thead><tbody>';
                $.each(res.righe, function (i, row) {
                    html += '<tr><td>' + (row.x_cm || '') + '</td><td>' + (row.xdatainizio || '') + '</td><td>' + (row.xdatafine || '') + '</td></tr>';
                });
                html += '</tbody></table>';
            } else {
                html += '<em>Nessuna riga</em>';
            }
            instance.setContent(html);
        });
    }
});
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
