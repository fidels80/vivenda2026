<?php

use app\assets\DataTablesAsset;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

DataTablesAsset::register($this);
$this->registerCss(<<<CSS
.dt-buttons .btn { margin: 0 0.25rem; }
.commessa-cover-box { position: relative; min-height: 240px; border: 1px solid #dee2e6; border-radius: .25rem; background: #f8f9fa; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 10px; }
.commessa-cover-box img { display: block; max-width: 100%; max-height: 340px; width: auto; height: auto; object-fit: contain; }
.ocp-gantt { border: 1px solid #dee2e6; border-radius: .25rem; background: #fff; }
.ocp-gantt-scroll { max-height: 560px; overflow: auto; }
.ocp-gantt-header { display: flex; position: sticky; top: 0; z-index: 3; background: #f4f6f9; border-bottom: 1px solid #dee2e6; min-height: 34px; }
.ocp-gantt-label-col { flex: 0 0 230px; width: 230px; padding: 8px 10px; font-weight: 600; border-right: 1px solid #dee2e6; }
.ocp-gantt-track-col { position: relative; flex: 1 1 auto; min-width: 320px; }
.ocp-gantt-axis-label { position: absolute; top: 8px; transform: translateX(-50%); font-size: 11px; color: #6c757d; white-space: nowrap; }
.ocp-gantt-row { display: flex; border-bottom: 1px solid #f1f3f5; min-height: 42px; }
.ocp-gantt-row:hover { background: #f8f9fa; }
.ocp-gantt-label { flex: 0 0 230px; width: 230px; padding: 6px 10px; border-right: 1px solid #dee2e6; overflow: hidden; }
.ocp-gantt-label .cliente { font-size: 12px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ocp-gantt-label .articolo { font-size: 10px; color: #6c757d; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ocp-gantt-track { position: relative; flex: 1 1 auto; min-width: 320px; min-height: 42px; }
.ocp-gantt-tick { position: absolute; top: 0; bottom: 0; border-left: 1px dashed #e9ecef; }
.ocp-gantt-bar { position: absolute; top: 11px; height: 20px; border-radius: 4px; background: #007bff; border: 1px solid #0056b3; cursor: pointer; min-width: 3px; box-shadow: 0 1px 2px rgba(0,0,0,.15); }
.ocp-gantt-bar:hover { background: #0056b3; }
.ocp-gantt-bar.selected { background: #28a745; border-color: #1e7e34; }
.gantt-detail-table th { width: 160px; }
CSS);

$this->title = 'Campagne Pubblicitarie (OCP)';

$dataUrl = Url::to(['dorigh-ocp/data']);
$dmsUrl = Url::to(['dorigh-ocp/dms-docs']);
$downloadUrl = Url::to(['dorigh-ocp/dms-download']);
$ganttUrl = Url::to(['dorigh-ocp/gantt']);
$uploadUrl = Url::to(['dorigh-ocp/upload-cover']);
$articoliUrl = Url::to(['dorigh-ocp/articoli']);
$clientiFinaliUrl = Url::to(['dorigh-ocp/clienti-finali']);
$commessaDetailUrl = Url::to(['dorigh-ocp/commessa-detail']);
$indexUrl = Url::to(['/site/index']);
$cd = $cd ?? '';
$cdJs = \yii\helpers\Json::encode($cd);
$webBase = Yii::getAlias('@web');
?>
<div class="dorigh-ocp-index">
    <div class="card shadow-sm mb-3" id="commessa-detail-card" style="display:none;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <i class="fas fa-info-circle"></i> Dettaglio commessa
                <span id="commessa-detail-title" class="text-muted"></span>
            </h3>
            <div class="d-flex align-items-center">
                <?= Html::a('<i class="fas fa-home"></i> Torna all\'index', $indexUrl, ['class' => 'btn btn-sm btn-outline-secondary mr-2', 'title' => 'Torna all\'index']) ?>
                <button type="button" id="btn-upload-cover" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-image"></i> Carica copertina
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="commessa-detail-message"></div>
            <div class="row align-items-stretch">
                <div class="col-md-6 mb-3 mb-md-0">
                    <table class="table table-sm table-bordered mb-0 h-100">
                        <tbody id="commessa-detail-fields"></tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="commessa-cover-box h-100">
                        <img id="commessa-cover-img" src="" alt="Copertina commessa" style="display:none;">
                        <div id="commessa-cover-empty" class="text-muted text-center">
                            <i class="fas fa-image fa-2x mb-2"></i>
                            <div>Nessuna copertina caricata</div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="mt-3"><i class="fas fa-folder-open"></i> Archivio documenti commessa</h5>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered w-100 mb-0">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Data</th>
                            <th>Descrizione</th>
                            <th>Riferimento</th>
                        </tr>
                    </thead>
                    <tbody id="commessa-dms-body"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter"></i> Filtri</h3>
        </div>
        <div class="card-body">
            <input type="hidden" id="f-sottocommessa" value="">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <label>Articolo</label>
                    <?= Select2::widget([
                        'name' => 'f-articolo',
                        'options' => ['placeholder' => 'Cerca articolo...', 'id' => 'f-articolo'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'ajax' => [
                                'url' => $articoliUrl,
                                'dataType' => 'json',
                                'delay' => 250,
                                'data' => new JsExpression('function(params) { return { q: params.term || "" }; }'),
                                'processResults' => new JsExpression('function(data) { return { results: data.results }; }'),
                                'cache' => true,
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label>Descrizione</label>
                    <input type="text" id="f-descrizione" class="form-control form-control-sm" placeholder="Descrizione">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label>Cliente finale</label>
                    <?= Select2::widget([
                        'name' => 'f-xcf',
                        'options' => ['placeholder' => 'Cerca cliente...', 'id' => 'f-xcf'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'ajax' => [
                                'url' => $clientiFinaliUrl,
                                'dataType' => 'json',
                                'delay' => 250,
                                'data' => new JsExpression('function(params) { return { q: params.term || "" }; }'),
                                'processResults' => new JsExpression('function(data) { return { results: data.results }; }'),
                                'cache' => true,
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="col-lg-2 col-md-6 d-flex align-items-end">
                    <button type="button" id="btn-reset" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-invoice"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-tabs px-3 pt-3" id="ocp-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="ocp-tab-svolte-link" data-toggle="tab" href="#ocp-tab-svolte" role="tab" aria-controls="ocp-tab-svolte" aria-selected="true">Svolte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ocp-tab-future-link" data-toggle="tab" href="#ocp-tab-future" role="tab" aria-controls="ocp-tab-future" aria-selected="false">Future</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ocp-tab-gantt-link" data-toggle="tab" href="#ocp-tab-gantt" role="tab" aria-controls="ocp-tab-gantt" aria-selected="false">Gantt</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="ocp-tab-svolte" role="tabpanel" aria-labelledby="ocp-tab-svolte-link">
                    <div class="table-responsive p-3">
                        <table id="dorigh-ocp-table-svolte" class="table table-striped table-bordered table-hover w-100" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Sottocommessa</th>
                                    <th>Descrizione Sottocommessa</th>
                                    <th>Articolo</th>
                                    <th>Descrizione</th>
                                    <th>Qta</th>
                                    <th>Cliente finale</th>
                                    <th>Data Inizio</th>
                                    <th>Data Fine</th>
                                    <th>Centro media</th>
                                    <th>Foto professionali</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="ocp-tab-future" role="tabpanel" aria-labelledby="ocp-tab-future-link">
                    <div class="table-responsive p-3">
                        <table id="dorigh-ocp-table-future" class="table table-striped table-bordered table-hover w-100" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Sottocommessa</th>
                                    <th>Descrizione Sottocommessa</th>
                                    <th>Articolo</th>
                                    <th>Descrizione</th>
                                    <th>Qta</th>
                                    <th>Cliente finale</th>
                                    <th>Data Inizio</th>
                                    <th>Data Fine</th>
                                    <th>Centro media</th>
                                    <th>Foto professionali</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="ocp-tab-gantt" role="tabpanel" aria-labelledby="ocp-tab-gantt-link">
                    <div class="p-3">
                        <div id="gantt-message"></div>
                        <div id="gantt-summary" class="small text-muted mb-2"></div>
                        <div id="ocp-gantt" class="ocp-gantt" style="display:none;">
                            <div class="ocp-gantt-scroll">
                                <div class="ocp-gantt-header">
                                    <div class="ocp-gantt-label-col">Cliente finale</div>
                                    <div class="ocp-gantt-track-col" id="gantt-axis"></div>
                                </div>
                                <div id="gantt-rows"></div>
                            </div>
                        </div>
                        <div id="gantt-detail" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dms-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-folder-open"></i> Foto professionali</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="dms-table" class="table table-striped table-bordered table-hover w-100" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Entità</th>
                            <th>File</th>
                            <th>Data</th>
                            <th>Descrizione</th>
                            <th>Riferimento</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="upload-cover-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-image"></i> Carica copertina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" id="cover-file" accept="image/*" class="form-control">
                <div id="cover-message" class="mt-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <button type="button" id="btn-save-cover" class="btn btn-primary">Carica</button>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$('#f-sottocommessa').val({$cdJs});

function esc(value) {
    return $('<div>').text(value === null || value === undefined ? '' : value).html();
}

function currentFilters() {
    function value(selector) {
        var v = $(selector).val();
        return v === null || v === undefined ? '' : v;
    }
    return {
        Cd_DOSottoCommessa: value('#f-sottocommessa'),
        Cd_AR: value('#f-articolo'),
        Descrizione: value('#f-descrizione'),
        x_cf: value('#f-xcf')
    };
}

var webBase = '{$webBase}';
function coverUrl(path, bustCache) {
    if (!path) return '';
    var url = webBase + (path.charAt(0) === '/' ? '' : '/') + path;
    if (bustCache) {
        url += (url.indexOf('?') === -1 ? '?' : '&') + 't=' + Date.now();
    }
    return url;
}

var downloadBaseUrl = '{$downloadUrl}';
function dmsFileLink(row) {
    var name = row.FileName || '';
    var id = row.Id_DmsDocument;
    if (!name) {
        name = 'Documento ' + (id || '');
    }
    if (id === undefined || id === null || id === '') {
        return esc(name);
    }
    var separator = downloadBaseUrl.indexOf('?') === -1 ? '?' : '&';
    return '<a href="' + downloadBaseUrl + separator + 'id=' + encodeURIComponent(id) +
        '" title="Scarica ' + esc(name) + '">' + esc(name) + '</a>';
}

function dorighButtons() {
    return [
        {
            extend: 'copyHtml5',
            text: '<i class="fa-solid fa-copy"></i> Copia',
            className: 'btn btn-secondary',
            titleAttr: 'Copia'
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa-solid fa-file-excel"></i> Excel',
            className: 'btn btn-success',
            titleAttr: 'Excel'
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa-solid fa-file-pdf"></i> PDF',
            className: 'btn btn-danger',
            titleAttr: 'PDF'
        },
        {
            extend: 'csvHtml5',
            text: '<i class="fa-solid fa-file-csv"></i> CSV',
            className: 'btn btn-info',
            titleAttr: 'CSV'
        },
        {
            extend: 'print',
            text: '<i class="fa-solid fa-print"></i> Stampa',
            className: 'btn btn-primary',
            titleAttr: 'Stampa'
        }
    ];
}

var dorighColumns = [
    { data: 'Cd_DOSottoCommessa' },
    { data: 'SottoCommessaDescrizione' },
    { data: 'Cd_AR' },
    { data: 'Descrizione' },
    {
        data: 'Qta', className: 'text-right',
        render: function (data) {
            if (data === null || data === undefined) return '';
            return Number(data).toLocaleString('it-IT', { maximumFractionDigits: 2 });
        }
    },
    { data: 'x_cf' },
    { data: 'xdatainizio' },
    { data: 'xdatafine' },
    { data: 'x_cm' },
    {
        data: 'Id_DORig', orderable: false, searchable: false, className: 'text-center',
        render: function (data, type, row) {
            if (!row.HasDocs) {
                return '';
            }
            return '<button class="btn btn-xs btn-outline-primary btn-dms" title="Foto professionali" data-id="' + data + '"><i class="fas fa-paperclip"></i></button>';
        }
    }
];

function createDorighTable(selector, periodo) {
    return $(selector).DataTable({
        processing: true,
        serverSide: true,
        order: [],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        dom: 'Bfrtip',
        buttons: dorighButtons(),
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
                var f = currentFilters();
                d.Cd_DOSottoCommessa = f.Cd_DOSottoCommessa;
                d.Cd_AR = f.Cd_AR;
                d.Descrizione = f.Descrizione;
                d.x_cf = f.x_cf;
                d.periodo = periodo;
            }
        },
        columns: dorighColumns.slice()
    });
}

var dorighTables = {
    svolte: createDorighTable('#dorigh-ocp-table-svolte', 'svolte'),
    future: createDorighTable('#dorigh-ocp-table-future', 'future')
};

function reloadDorighTables() {
    dorighTables.svolte.ajax.reload();
    dorighTables.future.ajax.reload();
}

var dmsId = null;
var dmsTable = null;
function openDms(id) {
    dmsId = id;
    if (!dmsTable) {
        dmsTable = $('#dms-table').DataTable({
            processing: true,
            pageLength: 10,
            order: [],
            language: {
                search: 'Cerca:',
                zeroRecords: 'Nessun documento collegato',
                info: 'Mostra da _START_ a _END_ di _TOTAL_ documenti',
                infoEmpty: 'Nessun documento',
                paginate: { first: 'Primo', last: 'Ultimo', next: 'Successivo', previous: 'Precedente' }
            },
            ajax: {
                url: '{$dmsUrl}',
                data: function (d) { d.id = dmsId; },
                dataSrc: 'data'
            },
            columns: [
                { data: 'EntityTable' },
                {
                    data: 'FileName',
                    render: function (data, type, row) {
                        if (type !== 'display') return data || '';
                        return dmsFileLink(row);
                    }
                },
                { data: 'DocumentDate' },
                { data: 'Descrizione' },
                { data: 'NumeroRif' }
            ]
        });
    } else {
        dmsTable.ajax.reload();
    }
    $('#dms-modal').modal('show');
}

$('#dorigh-ocp-table-svolte tbody, #dorigh-ocp-table-future tbody').on('click', '.btn-dms', function () {
    openDms($(this).data('id'));
});

$('#f-descrizione').on('keyup', function () {
    clearTimeout(window.dorighTimer);
    window.dorighTimer = setTimeout(function () {
        reloadDorighTables();
        invalidateGantt();
    }, 400);
});

var commessaDetailUrl = '{$commessaDetailUrl}';

function loadCommessaDetail() {
    var cd = $.trim($('#f-sottocommessa').val());
    if (!cd) {
        $('#commessa-detail-card').hide();
        return;
    }
    $('#commessa-detail-card').show();
    $('#commessa-detail-title').text(cd);
    $('#commessa-detail-message').html('<div class="text-muted">Caricamento...</div>');
    $('#commessa-detail-fields').empty();
    $('#commessa-dms-body').empty();
    $('#commessa-cover-img').attr('src', '').hide();
    $('#commessa-cover-empty').show();
    $.getJSON(commessaDetailUrl, { cd: cd }, function (res) {
        if (!res.success) {
            $('#commessa-detail-message').html('<div class="alert alert-warning mb-0">' + res.message + '</div>');
            return;
        }
        var d = res.detail;
        var fields = [
            ['Codice', d.Cd_DOSottoCommessa],
            ['Descrizione', d.Descrizione],
            ['Stato', $.trim(d.DescrizioneStato || '') || $.trim(d.Cd_DOCommessaStato || '')],
            ['Data inizio', d.DataInizio],
            ['Data fine presunta', d.DataFinePresunta],
            ['Data fine reale', d.DataFineReale],
            ['Note', d.NoteDoSottoCommessa]
        ];
        var tbody = $('#commessa-detail-fields');
        $.each(fields, function (i, f) {
            var tr = $('<tr>');
            tr.append($('<th class="w-25">').text(f[0]));
            tr.append($('<td>').text(f[1] === null || f[1] === undefined ? '' : f[1]));
            tbody.append(tr);
        });

        if (res.cover) {
            $('#commessa-cover-img').attr('src', coverUrl(res.cover)).show();
            $('#commessa-cover-empty').hide();
        }

        $('#commessa-detail-message').empty();
        var docs = $('#commessa-dms-body');
        if (!res.documents || res.documents.length === 0) {
            docs.append($('<tr>').append($('<td colspan="4" class="text-center text-muted">').text('Nessun documento collegato')));
            return;
        }
        $.each(res.documents, function (i, doc) {
            var tr = $('<tr>');
            tr.append($('<td>').html(dmsFileLink(doc)));
            tr.append($('<td>').text(doc.DocumentDate || ''));
            tr.append($('<td>').text(doc.Descrizione || ''));
            tr.append($('<td>').text(doc.NumeroRif || ''));
            docs.append(tr);
        });
    }).fail(function () {
        $('#commessa-detail-message').html('<div class="alert alert-danger mb-0">Errore di comunicazione.</div>');
    });
}

loadCommessaDetail();

$('#f-articolo, #f-xcf').on('change', function () {
    reloadDorighTables();
    invalidateGantt();
});

$('#btn-reset').on('click', function () {
    $('#f-descrizione').val('');
    $('#f-articolo').val(null).trigger('change');
    $('#f-xcf').val(null).trigger('change');
    loadCommessaDetail();
    dorighTables.svolte.search('').ajax.reload();
    dorighTables.future.search('').ajax.reload();
    invalidateGantt();
});

// ------------------------------------------------------------------
// Gantt
// ------------------------------------------------------------------
var ganttUrl = '{$ganttUrl}';
var ganttLoaded = false;
var ganttLoading = false;
var ganttRequest = 0;
var ganttData = null;

function parseIsoDate(value) {
    if (!value) return null;
    var parts = String(value).split('-');
    if (parts.length !== 3) return null;
    var d = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10), 12, 0, 0);
    return isNaN(d.getTime()) ? null : d;
}

function addDays(date, days) {
    var d = new Date(date.getTime());
    d.setDate(d.getDate() + days);
    return d;
}

function dayDiff(a, b) {
    return Math.round((b.getTime() - a.getTime()) / 86400000);
}

var mesiBrevi = ['gen', 'feb', 'mar', 'apr', 'mag', 'giu', 'lug', 'ago', 'set', 'ott', 'nov', 'dic'];
function fmtShort(date) {
    return ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date.getMonth() + 1)).slice(-2);
}
function fmtMonth(date) {
    return mesiBrevi[date.getMonth()] + ' ' + String(date.getFullYear()).slice(-2);
}
function fmtLong(date) {
    return ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date.getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
}
function datePercent(date, start, end) {
    var total = end.getTime() - start.getTime();
    if (total <= 0) return 0;
    return ((date.getTime() - start.getTime()) / total) * 100;
}

function buildGanttTicks(start, end) {
    var ticks = [];
    var days = dayDiff(start, end);
    var cur;
    if (days <= 60) {
        var step = days <= 21 ? 3 : 7;
        for (var d = 0; d <= days; d += step) {
            var day = addDays(start, d);
            ticks.push({ date: day, label: fmtShort(day) });
        }
        if (!ticks.length || dayDiff(ticks[ticks.length - 1].date, end) > 0) {
            ticks.push({ date: end, label: fmtShort(end) });
        }
    } else if (days <= 240) {
        cur = new Date(start.getFullYear(), start.getMonth(), 1, 12);
        if (cur < start) cur = new Date(start.getFullYear(), start.getMonth() + 1, 1, 12);
        while (cur <= end) {
            ticks.push({ date: cur, label: fmtMonth(cur) });
            cur = new Date(cur.getFullYear(), cur.getMonth() + 1, 1, 12);
        }
    } else if (days <= 900) {
        cur = new Date(start.getFullYear(), start.getMonth(), 1, 12);
        while (cur.getMonth() % 3 !== 0) cur = new Date(cur.getFullYear(), cur.getMonth() + 1, 1, 12);
        if (cur < start) cur = new Date(cur.getFullYear(), cur.getMonth() + 3, 1, 12);
        while (cur <= end) {
            ticks.push({ date: cur, label: fmtMonth(cur) });
            cur = new Date(cur.getFullYear(), cur.getMonth() + 3, 1, 12);
        }
    } else {
        cur = new Date(start.getFullYear() + 1, 0, 1, 12);
        while (cur <= end) {
            ticks.push({ date: cur, label: String(cur.getFullYear()) });
            cur = new Date(cur.getFullYear() + 1, 0, 1, 12);
        }
    }
    return ticks;
}

function showGanttDetail(item) {
    var rows = [
        ['Cliente finale', item.cliente || ''],
        ['Centro media', item.centro_media || ''],
        ['Sottocommessa', item.Cd_DOSottoCommessa || ''],
        ['Articolo', item.Cd_AR || ''],
        ['Descrizione', item.Descrizione || ''],
        ['Data inizio', item.start_label || ''],
        ['Data fine', item.end_label || '']
    ];
    var html = '<div class="card card-outline card-primary mb-0"><div class="card-header py-2"><h5 class="card-title mb-0"><i class="fas fa-info-circle"></i> Dettaglio Gantt</h5></div><div class="card-body py-2"><table class="table table-sm table-bordered mb-0 gantt-detail-table"><tbody>';
    $.each(rows, function (i, r) {
        html += '<tr><th>' + esc(r[0]) + '</th><td>' + esc(r[1]) + '</td></tr>';
    });
    html += '</tbody></table></div></div>';
    $('#gantt-detail').html(html);
}

function renderGantt(res) {
    ganttData = res;
    $('#gantt-detail').empty();

    if (!res.success) {
        $('#ocp-gantt').hide();
        $('#gantt-summary').empty();
        $('#gantt-message').html('<div class="alert alert-warning mb-0">' + esc(res.message || 'Dati non disponibili') + '</div>');
        return;
    }

    var start = parseIsoDate(res.range.start);
    var end = parseIsoDate(res.range.end);
    if (!start || !end) {
        $('#ocp-gantt').hide();
        $('#gantt-message').html('<div class="alert alert-warning mb-0">Intervallo di date non valido.</div>');
        return;
    }
    if (end.getTime() <= start.getTime()) {
        end = addDays(start, 1);
    }

    var summary = ['Periodo: <strong>' + fmtLong(start) + '</strong> - <strong>' + fmtLong(end) + '</strong>'];
    if (res.commessa) {
        summary.push('Commessa <strong>' + esc(res.commessa.cd) + '</strong> - ' + esc(res.commessa.descrizione));
        if (res.commessa.stato) summary.push('Stato: ' + esc(res.commessa.stato));
        summary.push('Fine ' + (res.commessa.end_source === 'reale' ? 'reale' : 'presunta'));
    }
    if (res.truncated) summary.push('<span class="text-warning">Prime ' + res.limit + ' righe visualizzate</span>');
    $('#gantt-summary').html(summary.join(' &middot; '));

    var ticks = buildGanttTicks(start, end);
    var axisHtml = '';
    $.each(ticks, function (i, tick) {
        var left = datePercent(tick.date, start, end);
        var transform = left < 2 ? 'translateX(0)' : (left > 98 ? 'translateX(-100%)' : 'translateX(-50%)');
        axisHtml += '<div class="ocp-gantt-tick" style="left:' + left.toFixed(3) + '%"></div>';
        axisHtml += '<span class="ocp-gantt-axis-label" style="left:' + left.toFixed(3) + '%;transform:' + transform + '">' + esc(tick.label) + '</span>';
    });
    $('#gantt-axis').html(axisHtml);

    if (!res.items || !res.items.length) {
        $('#ocp-gantt').hide();
        $('#gantt-message').html('<div class="alert alert-info mb-0">Nessuna riga con date valide per il Gantt.</div>');
        return;
    }

    var ticksPerRow = '';
    $.each(ticks, function (i, tick) {
        ticksPerRow += '<div class="ocp-gantt-tick" style="left:' + datePercent(tick.date, start, end).toFixed(3) + '%"></div>';
    });

    var rowsHtml = '';
    $.each(res.items, function (i, item) {
        var itemStart = parseIsoDate(item.start);
        var itemEnd = parseIsoDate(item.end);
        if (!itemStart || !itemEnd) return;

        var left = datePercent(itemStart, start, end);
        var width = datePercent(itemEnd, start, end) - left;
        if (width < 0.4) width = 0.4;

        var cliente = item.cliente || '(cliente non indicato)';
        var title = cliente + '\\n' + item.start_label + ' - ' + item.end_label;
        if (item.Cd_AR) title += '\\n' + item.Cd_AR + ' - ' + (item.Descrizione || '');

        rowsHtml += '<div class="ocp-gantt-row">' +
            '<div class="ocp-gantt-label" title="' + esc(title) + '">' +
            '<div class="cliente">' + esc(cliente) + '</div>' +
            '<div class="articolo">' + esc(item.Cd_AR || '') + (item.Descrizione ? ' - ' + esc(item.Descrizione) : '') + '</div>' +
            '</div>' +
            '<div class="ocp-gantt-track">' + ticksPerRow +
            '<div class="ocp-gantt-bar" data-index="' + i + '" style="left:' + left.toFixed(3) + '%;width:' + width.toFixed(3) + '%" title="' + esc(title) + '"></div>' +
            '</div></div>';
    });

    $('#gantt-rows').html(rowsHtml);
    $('#gantt-message').empty();
    $('#ocp-gantt').show();
}

function ganttFilters() {
    var f = currentFilters();
    return {
        cd: f.Cd_DOSottoCommessa,
        Cd_DOSottoCommessa: f.Cd_DOSottoCommessa,
        Cd_AR: f.Cd_AR,
        Descrizione: f.Descrizione,
        x_cf: f.x_cf
    };
}

function loadGantt(force) {
    if (ganttLoaded && !force) return;
    var requestId = ++ganttRequest;
    ganttLoading = true;
    $('#gantt-message').html('<div class="text-muted">Caricamento...</div>');
    $('#ocp-gantt').hide();
    $.getJSON(ganttUrl, ganttFilters())
        .done(function (res) {
            if (requestId !== ganttRequest) return;
            ganttLoading = false;
            ganttLoaded = true;
            renderGantt(res);
        })
        .fail(function () {
            if (requestId !== ganttRequest) return;
            ganttLoading = false;
            $('#gantt-message').html('<div class="alert alert-danger mb-0">Errore di comunicazione.</div>');
        });
}

function invalidateGantt() {
    ganttLoaded = false;
    if ($('#ocp-tab-gantt').hasClass('active')) {
        clearTimeout(window.ganttTimer);
        window.ganttTimer = setTimeout(function () { loadGantt(true); }, 350);
    }
}

$('#gantt-rows').on('click', '.ocp-gantt-bar', function () {
    var index = $(this).data('index');
    if (!ganttData || !ganttData.items || !ganttData.items[index]) return;
    $('#gantt-rows .ocp-gantt-bar').removeClass('selected');
    $(this).addClass('selected');
    showGanttDetail(ganttData.items[index]);
});

$('#ocp-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr('href');
    if (target === '#ocp-tab-gantt') {
        loadGantt();
    } else if (target === '#ocp-tab-future') {
        dorighTables.future.columns.adjust();
    } else if (target === '#ocp-tab-svolte') {
        dorighTables.svolte.columns.adjust();
    }
});

// upload copertina in modale
$('#btn-upload-cover').on('click', function () {
    $('#cover-message').html('');
    $('#cover-file').val('');
    $('#upload-cover-modal').modal('show');
});

$('#btn-save-cover').on('click', function () {
    var cd = $('#f-sottocommessa').val();
    var fileInput = document.getElementById('cover-file');
    if (!fileInput.files || !fileInput.files.length) {
        $('#cover-message').html('<div class="alert alert-warning">Seleziona un immagine.</div>');
        return;
    }
    var formData = new FormData();
    formData.append('cd_dosottocommessa', cd);
    formData.append('image', fileInput.files[0]);
    var csrfParam = $('meta[name=csrf-param]').attr('content');
    var csrfToken = $('meta[name=csrf-token]').attr('content');
    if (csrfParam && csrfToken) {
        formData.append(csrfParam, csrfToken);
    }
    $.ajax({
        url: '{$uploadUrl}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                if (res.image_path) {
                    $('#commessa-cover-img').attr('src', coverUrl(res.image_path, true)).show();
                    $('#commessa-cover-empty').hide();
                }
                $('#cover-message').html('<div class="alert alert-success">' + res.message + '</div>');
                setTimeout(function () { $('#upload-cover-modal').modal('hide'); }, 800);
            } else {
                $('#cover-message').html('<div class="alert alert-danger">' + res.message + '</div>');
            }
        },
        error: function () {
            $('#cover-message').html('<div class="alert alert-danger">Errore di comunicazione.</div>');
        }
    });
});
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
