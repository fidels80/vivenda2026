<?php
use app\assets\DataTablesAsset;
use app\models\anacli;
use app\models\doctype;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

DataTablesAsset::register($this);
$this->registerCss(<<<CSS
.dt-buttons .btn { margin: 0 0.25rem; }
#doc-head-table { table-layout: fixed; width: 100% !important; }
#doc-head-table > thead > tr > th,
#doc-head-table > tbody > tr:not(.child) > td,
#doc-head-table > tfoot > tr > th {
    min-width: 0;
    overflow: hidden;
    white-space: normal;
    overflow-wrap: anywhere;
}
#doc-head-table > thead > tr > th:nth-child(2)  { width: 6%; }
#doc-head-table > thead > tr > th:nth-child(3)  { width: 6%; }
#doc-head-table > thead > tr > th:nth-child(4)  { width: 7%; }
#doc-head-table > thead > tr > th:nth-child(5)  { width: 13%; }
#doc-head-table > thead > tr > th:nth-child(6)  { width: 10%; }
#doc-head-table > thead > tr > th:nth-child(7)  { width: 4%; }
#doc-head-table > thead > tr > th:nth-child(8)  { width: 4%; }
#doc-head-table > thead > tr > th:nth-child(9)  { width: 20%; }
#doc-head-table > thead > tr > th:nth-child(10) { width: 8%; }
#doc-head-table > thead > tr > th:nth-child(11) { width: 7%; }
#doc-head-table th.dt-note,
#doc-head-table td.dt-note {
    white-space: normal;
    overflow-wrap: anywhere;
}
#doc-head-table td.child {
    min-width: 0;
    overflow: visible;
    white-space: normal;
}
#doc-head-table td.child table {
    table-layout: auto;
    width: 100%;
}
#doc-head-table td.child table th,
#doc-head-table td.child table td {
    min-width: 0;
    overflow: visible;
    white-space: normal;
}
CSS
);

/* @var $this yii\web\View */
/* @var $searchModel app\models\Doc_headSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$listconf = ['1' => 'Confermato', '0' => 'Non Confermato'];
$listrif = ['1' => 'Rifiutato', '0' => 'Non Rifiutato'];

$this->title = ' ';

$usrid = Yii::$app->user->Id;
$ris = null;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['grid_color', 'cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}
$usrgrid = $ris['grid_color'] ?? 'black';
$cdCli = $ris['cd_cli'] ?? null;

$eldoc = (new yii\db\Query())
    ->select(['cd_doc'])
    ->from('doc_head')
    ->where(['cd_cli' => $cdCli])
    ->orWhere(['altcli' => $cdCli])
    ->distinct()
    ->all();

$elecli = (new yii\db\Query())
    ->select(['cd_cli'])
    ->distinct()
    ->from('doc_head')
    ->where(['altcli' => $cdCli])
    ->andWhere(['not', ['altcli' => null]])
    ->all();
$elecli[]['cd_cli'] = $cdCli;

$clif = ArrayHelper::map(
    anacli::find()
        ->select(['cd_cli', '(cd_cli+\' \'+Desk) as desk'])
        ->where(['IN', 'cd_cli', $elecli])
        ->orderBy('cd_cli')
        ->asArray()
        ->all(),
    'cd_cli',
    'desk'
);

switch ($doctipo) {
    case 'prv':
        $tipdoc = 'Preventivi';
        break;
    case 'ord':
        $tipdoc = 'Ordini';
        break;
    case 'ftv':
        $tipdoc = 'Fatture';
        break;
    case 'all':
    default:
        $tipdoc = 'Documenti';
        break;
}

$doctypeList = ArrayHelper::map(
    doctype::find()
        ->select(['cd_doc', '(cd_doc+\' \'+descrizione) as desk'])
        ->where(['cd_doc' => $eldoc])
        ->orderBy('cd_doc')
        ->asArray()
        ->all(),
    'cd_doc',
    'desk'
);

$dataUrl = Url::to(['doc_head/data']);
$expandUrl = Url::to(['doc_head/expand', 'id' => '__ID__']);
$viewUrl = Url::to(['doc_head/view', 'id' => '__ID__']);
$exportUrl = Url::to(['doc_head/export']);
$indexUrl = Url::to(['/site/index']);
?>
<div class="doc-head-index">
    <h1><?= Html::encode($tipdoc) ?></h1>

    <div class="card shadow-sm mb-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter"></i> Filtri</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <label>Tipo Doc.</label>
                    <select id="f-cd_doc" class="form-control form-control-sm">
                        <option value="">Tutti</option>
                        <?php foreach ($doctypeList as $k => $v): ?>
                            <option value="<?= Html::encode($k) ?>"><?= Html::encode($v) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6">
                    <label>Intestatario</label>
                    <select id="f-cd_cli" class="form-control form-control-sm">
                        <option value="">Tutti</option>
                        <?php foreach ($clif as $k => $v): ?>
                            <option value="<?= Html::encode($k) ?>"><?= Html::encode($v) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Num. Doc.</label>
                    <input type="text" id="f-numdoc" class="form-control form-control-sm" placeholder="Numero">
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Richiedente (cod.)</label>
                    <input type="text" id="f-dest" class="form-control form-control-sm" placeholder="Codice">
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Confermato</label>
                    <select id="f-confermato" class="form-control form-control-sm">
                        <option value="">Tutti</option>
                        <?php foreach ($listconf as $k => $v): ?>
                            <option value="<?= Html::encode($k) ?>"><?= Html::encode($v) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-2 col-sm-6">
                    <label>Rifiutato</label>
                    <select id="f-rifiutato" class="form-control form-control-sm">
                        <option value="">Tutti</option>
                        <?php foreach ($listrif as $k => $v): ?>
                            <option value="<?= Html::encode($k) ?>"><?= Html::encode($v) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Data da</label>
                    <input type="date" id="f-data-from" class="form-control form-control-sm">
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>Data a</label>
                    <input type="date" id="f-data-to" class="form-control form-control-sm">
                </div>
                <div class="col-md-3 col-sm-6 d-flex align-items-end">
                    <button type="button" id="btn-reset" class="btn btn-outline-secondary btn-sm mr-2">
                        <i class="fas fa-redo"></i> Reset
                    </button>
 
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-book"></i> <?= Html::encode($tipdoc) ?></h3>
            <?= Html::a('<i class="fas fa-home"></i> Torna all\'index', $indexUrl, ['class' => 'btn btn-sm btn-outline-secondary', 'title' => 'Torna all\'index']) ?>
        </div>
        <div class="card-body table-responsive p-0">
            <table id="doc-head-table" class="table table-striped table-bordered table-hover w-100" style="width:100%;">
                <thead>
                    <tr>
                        <th style="width:40px;"></th>
                        <th>Tipo Doc.</th>
                        <th>Num.Doc.</th>
                        <th>Data Doc.</th>
                        <th>Intestatario</th>
                        <th>Richiedente</th>
                        <th>Conf.</th>
                        <th>Rif.</th>
                        <th class="dt-note">Note</th>
                        <th>Imponibile</th>
                        <th>Imposta</th>
                        <th style="width:40px;">Dett.</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="9" class="text-right">Totale pagina</th>
                        <th id="foot-imponibile" class="text-right"></th>
                        <th id="foot-imposta" class="text-right"></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php
$fc = Yii::$app->request->get('filtra_confermato', '');
$fr = Yii::$app->request->get('filtra_rifiutato', '');

$js = <<<JS
function escapeHtml(s) {
    if (s === null || s === undefined) return '';
    return String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function fmtEur(v) {
    v = Number(v || 0);
    return v.toLocaleString('it-IT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
}

var docHeadTable = $('#doc-head-table').DataTable({
    processing: true,
    serverSide: true,
    order: [],
    pageLength: 25,
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
    autoWidth: false,
    dom: 'Bfrtip',
    buttons: [
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
    ],
    language: {
        search: 'Cerca:',
        lengthMenu: 'Mostra _MENU_ record',
        info: 'Mostra da _START_ a _END_ di _TOTAL_ record',
        infoEmpty: 'Nessun record',
        infoFiltered: '(filtrati da _MAX_ totali)',
        zeroRecords: 'Nessun risultato trovato',
        paginate: {
            first: 'Primo',
            last: 'Ultimo',
            next: 'Successivo',
            previous: 'Precedente'
        }
    },
    ajax: {
        url: '{$dataUrl}',
        type: 'GET',
        data: function (d) {
            d.doctipo = '{$doctipo}';
            d.filtra_confermato = '{$fc}';
            d.filtra_rifiutato = '{$fr}';
            d.cd_doc = $('#f-cd_doc').val();
            d.cd_cli = $('#f-cd_cli').val();
            d.numdoc = $('#f-numdoc').val();
            d.dest = $('#f-dest').val();
            d.confermato = $('#f-confermato').val();
            d.rifiutato = $('#f-rifiutato').val();
            d.data_from = $('#f-data-from').val();
            d.data_to = $('#f-data-to').val();
        }
    },
    columns: [
        {
            data: null, orderable: false, searchable: false, className: 'text-center',
            render: function (data, type, row) {
                return '<button class="btn btn-xs btn-outline-primary btn-expand" data-id="' + row.id + '"><i class="fas fa-plus"></i></button>';
            }
        },
        { data: 'cd_doc' },
        { data: 'numdoc' },
        { data: 'data' },
        { data: 'cd_cli' },
        { data: 'dest' },
        {
            data: 'confermato', className: 'text-center',
            render: function (data) {
                return data == 1 ? '<span class="badge badge-success">SI</span>' : '<span class="badge badge-secondary">No</span>';
            }
        },
        {
            data: 'rifiutato', className: 'text-center',
            render: function (data) {
                return data == 1 ? '<span class="badge badge-danger">SI</span>' : '<span class="badge badge-secondary">No</span>';
            }
        },
        {
            data: 'note', className: 'dt-note',
            render: function (data) {
                if (!data) return '';
                var t = data.length > 60 ? data.substring(0, 60) + '…' : data;
                return '<span title="' + escapeHtml(data) + '">' + escapeHtml(t) + '</span>';
            }
        },
        {
            data: 'imponibile', orderable: false, className: 'text-right',
            render: function (data) { return fmtEur(data); }
        },
        {
            data: 'imposta', orderable: false, className: 'text-right',
            render: function (data) { return fmtEur(data); }
        },
        {
            data: null, orderable: false, searchable: false, className: 'text-center',
            render: function (data, type, row) {
                return '<a href="' + '{$viewUrl}'.replace('__ID__', encodeURIComponent(row.id)) + '" title="Visualizza"><i class="fas fa-eye"></i></a>';
            }
        }
    ],
    footerCallback: function (tfoot, data, start, end, display) {
        var api = this.api();
        var totals = api.ajax.json() ? (api.ajax.json().totals || {}) : {};
        $('#foot-imponibile').html(fmtEur(totals.imponibile || 0));
        $('#foot-imposta').html(fmtEur(totals.imposta || 0));
    }
});

$('#f-cd_doc, #f-cd_cli, #f-confermato, #f-rifiutato, #f-data-from, #f-data-to').on('change', function () {
    docHeadTable.ajax.reload();
});

var searchTimer = null;
$('#f-numdoc, #f-dest').on('keyup', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function () { docHeadTable.ajax.reload(); }, 400);
});

$('#btn-reset').on('click', function () {
    $('#f-cd_doc, #f-cd_cli, #f-confermato, #f-rifiutato').val('');
    $('#f-numdoc, #f-dest').val('');
    $('#f-data-from, #f-data-to').val('');
    docHeadTable.search('').ajax.reload();
});

$('#btn-export').on('click', function () {
    var q = $.param({
        doctipo: '{$doctipo}',
        cd_doc: $('#f-cd_doc').val(),
        cd_cli: $('#f-cd_cli').val(),
        numdoc: $('#f-numdoc').val(),
        dest: $('#f-dest').val(),
        confermato: $('#f-confermato').val(),
        rifiutato: $('#f-rifiutato').val(),
        data_from: $('#f-data-from').val(),
        data_to: $('#f-data-to').val(),
        search: docHeadTable.search()
    });
    window.open('{$exportUrl}' + '&' + q, '_blank');
});

$('#doc-head-table tbody').on('click', '.btn-expand', function () {
    var btn = $(this);
    var tr = btn.closest('tr');
    var row = docHeadTable.row(tr);
    var id = btn.data('id');
    if (row.child.isShown()) {
        row.child.hide();
        btn.find('i').removeClass('fa-minus').addClass('fa-plus');
        return;
    }
    btn.find('i').removeClass('fa-plus').addClass('fa-minus');
    $.ajax({ url: '{$expandUrl}'.replace('__ID__', encodeURIComponent(id)), dataType: 'html' })
        .done(function (html) { row.child(html).show(); })
        .fail(function () {
            row.child.hide();
            btn.find('i').removeClass('fa-minus').addClass('fa-plus');
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'error', title: 'Errore', text: 'Impossibile caricare il dettaglio.' });
            }
        });
});
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
