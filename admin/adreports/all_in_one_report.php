<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'All in One Report';
$pageIcon  = 'fa-th';

// Base URL so relative assets in header/footer resolve from this subdirectory.
$_docRoot  = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
$_selfDir  = rtrim(str_replace('\\', '/', dirname(__FILE__)), '/');
$_relative = str_replace($_docRoot, '', dirname($_selfDir));
$pageBase  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
           . '://' . $_SERVER['HTTP_HOST']
           . rtrim($_relative, '/') . '/';

include('../includes/check_session.php');
?>
<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<div class="hp-main">
<?php include('../includes/top_navigation.php'); ?>
<div class="hp-content">

<!-- ── Filter Card ─────────────────────────────────────────────────────────── -->
<div class="hp-card hp-filter-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-th"></i> All in One Report</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Publisher / Advertiser</label>
                    <select id="aio-type" class="form-control">
                        <option value="advertiser">Advertiser</option>
                        <option value="publisher">Publisher</option>
                        <option value="api">API</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Start Date</label>
                    <input type="text" id="start_date" class="form-control birthday" readonly>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">End Date</label>
                    <input type="text" id="end_date" class="form-control birthday" readonly>
                </div>
            </div>

            <div class="col-md-1 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Hour</label>
                    <select id="aio-hour" class="form-control">
                        <?php for ($i = 24; $i > 0; $i--): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-1 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="aio-submit" class="btn-submit-report" onclick="submitReport()">
                        <i class="fa fa-search"></i> Submit
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ── Error Banner ────────────────────────────────────────────────────────── -->
<div id="aio-error" style="display:none;margin-top:16px;">
    <div class="hp-card-body" style="padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
        <i class="fa fa-exclamation-triangle"></i> <span id="aio-error-msg"></span>
    </div>
</div>

<!-- ── Results Card ────────────────────────────────────────────────────────── -->
<div id="aio-results" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-table"></i> Output Records
                <small id="aio-result-title" style="font-size:12px;color:#a0aec0;margin-left:8px;"></small>
            </h4>
            <button onclick="aioDownloadCSV()" class="btn btn-sm btn-default" style="float:right;margin-top:-4px;">
                <i class="fa fa-download"></i> Download CSV
            </button>
        </div>
        <div id="aio-table-wrap" class="hp-card-body" style="padding:0;overflow-x:auto;"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<script>
$(document).ready(function () {
    // Datepicker init (daterangepicker is loaded via footer.php)
    $('#start_date, #end_date').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        locale           : { format: 'DD-MM-YYYY' }
    });
});

// ── Submit ──────────────────────────────────────────────────────────────────

function submitReport() {
    var start = $('#start_date').val();
    var end   = $('#end_date').val();

    if (!start || !end) {
        showError('Please select both Start Date and End Date.');
        return;
    }

    var $btn = $('#aio-submit');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    $('#aio-results').hide();
    $('#aio-error').hide();

    $.post('adreports/ajax.php', {
        action     : 'all_in_one_report',
        type       : $('#aio-type').val(),
        start_date : start,
        end_date   : end,
        hour       : $('#aio-hour').val()
    })
    .done(function (r) {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        if (!r || !r.success) {
            showError(r && r.error ? r.error : 'Unknown server error.');
            return;
        }
        renderResults(r);
        $('#aio-results').show();
    })
    .fail(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        showError('Request failed. Please check your connection and try again.');
    });
}

function showError(msg) {
    $('#aio-error-msg').text(msg);
    $('#aio-error').show();
}

// ── Render dispatcher ────────────────────────────────────────────────────────

function renderResults(r) {
    var labels = { advertiser: 'Advertiser', publisher: 'Publisher', api: 'API' };
    $('#aio-result-title').text((labels[r.type] || r.type) + ' — ' + r.start_date + ' to ' + r.end_date);

    var html;
    if      (r.type === 'advertiser') html = buildAdvertiserTable(r);
    else if (r.type === 'publisher')  html = buildPublisherTable(r);
    else                              html = buildApiTable(r);

    $('#aio-table-wrap').html(html);
    window._aioData = r;
}

// ── Style helpers ────────────────────────────────────────────────────────────

var TH   = 'style="background:#4a5568;color:#fff;text-align:center;white-space:nowrap;padding:8px 10px;"';
var TDC  = 'style="text-align:center;white-space:nowrap;padding:6px 10px;"';
var TDB  = 'style="text-align:center;white-space:nowrap;padding:6px 10px;font-weight:600;"';
var TFTD = 'style="background:#edf2f7;font-weight:700;text-align:center;white-space:nowrap;padding:6px 10px;"';
var EMPTY = '<p style="padding:32px;color:#a0aec0;text-align:center;">'
          + '<i class="fa fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;"></i>'
          + 'No data found for the selected filters.</p>';

function fmt(n)  { return parseFloat(n || 0).toFixed(2); }
function fmtN(n) { return parseInt(n   || 0).toLocaleString(); }

function wrapTable(id, colgroup, thead, tbody, tfoot, minWidth) {
    var style = minWidth ? ' style="font-size:12.5px;min-width:' + minWidth + ';"' : ' style="font-size:12.5px;"';
    return '<table id="' + id + '" class="table table-striped table-bordered"' + style + '>'
         + (colgroup || '') + '<thead>' + thead + '</thead>'
         + '<tbody>' + tbody + '</tbody>'
         + '<tfoot>' + tfoot + '</tfoot></table>';
}

// ── Advertiser table ─────────────────────────────────────────────────────────

function buildAdvertiserTable(r) {
    if (!r.rows || !r.rows.length) return EMPTY;

    var th = '<tr><th ' + TH + '>Advertiser</th>';
    $.each(r.ops, function (i, op) { th += '<th ' + TH + '>' + op + '</th>'; });
    th += '<th ' + TH + '>Total</th></tr>';

    var tbody = '';
    $.each(r.rows, function (i, row) {
        var tr = '<td style="padding:6px 10px;font-weight:600;">' + row.name + '</td>';
        $.each(row.ops, function (j, op) {
            tr += '<td ' + TDC + '>' + (op.count === 0 && op.amount === 0
                ? '0'
                : '$' + fmt(op.amount) + ' || ' + fmtN(op.count)) + '</td>';
        });
        tr += '<td ' + TDB + '>$' + fmt(row.total_amount) + ' || ' + fmtN(row.total_count) + '</td>';
        tbody += '<tr>' + tr + '</tr>';
    });

    var t  = r.totals;
    var tf = '<tr><td ' + TFTD + ' style="background:#edf2f7;font-weight:700;text-align:left;padding:6px 10px;">Total</td>';
    $.each(t.ops, function (i, op) {
        tf += '<td ' + TFTD + '>' + (op.count === 0 && op.amount === 0
            ? '0'
            : '$' + fmt(op.amount) + ' || ' + fmtN(op.count)) + '</td>';
    });
    tf += '<td ' + TFTD + '>$' + fmt(t.total_amount) + ' || ' + fmtN(t.total_count) + '</td></tr>';

    return wrapTable('aio-tbl', '', th, tbody, tf, '700px');
}

// ── Publisher table ──────────────────────────────────────────────────────────

function buildPublisherTable(r) {
    if (!r.rows || !r.rows.length) return EMPTY;

    var th = '<tr><th ' + TH + '>Publisher</th>';
    $.each(r.ops, function (i, op) { th += '<th ' + TH + '>' + op + '</th>'; });
    th += '<th ' + TH + '>Total</th></tr>';

    var tbody = '';
    $.each(r.rows, function (i, row) {
        var tr = '<td style="padding:6px 10px;font-weight:600;">' + row.name + '</td>';
        $.each(row.ops, function (j, v) { tr += '<td ' + TDC + '>' + fmtN(v || 0) + '</td>'; });
        tr += '<td ' + TDB + '>' + fmtN(row.total || 0) + '</td>';
        tbody += '<tr>' + tr + '</tr>';
    });

    var t  = r.totals;
    var tf = '<tr><td ' + TFTD + ' style="background:#edf2f7;font-weight:700;text-align:left;padding:6px 10px;">Total</td>';
    $.each(t.ops, function (i, v) { tf += '<td ' + TFTD + '>' + fmtN(v || 0) + '</td>'; });
    tf += '<td ' + TFTD + '>' + fmtN(t.total || 0) + '</td></tr>';

    return wrapTable('aio-tbl', '', th, tbody, tf, '700px');
}

// ── API table ────────────────────────────────────────────────────────────────

function buildApiTable(r) {
    if (!r.rows || !r.rows.length) return EMPTY;

    var th = '<tr><th ' + TH + '>Partner</th>';
    $.each(r.totals.countries, function (i, c) { th += '<th ' + TH + '>' + c.label + '</th>'; });
    th += '<th ' + TH + '>Total</th></tr>';

    var tbody = '';
    $.each(r.rows, function (i, row) {
        var tr = '<td style="padding:6px 10px;font-weight:600;">' + row.partner + '</td>';
        $.each(row.countries, function (j, c) {
            tr += '<td ' + TDC + '>' + (c.count === 0
                ? '0'
                : fmtN(c.count) + ' || $' + fmt(c.amount)) + '</td>';
        });
        tr += '<td ' + TDB + '>' + fmtN(row.total_count) + ' || $' + fmt(row.total_amount) + '</td>';
        tbody += '<tr>' + tr + '</tr>';
    });

    var t  = r.totals;
    var tf = '<tr><td ' + TFTD + ' style="background:#edf2f7;font-weight:700;text-align:left;padding:6px 10px;">Total</td>';
    $.each(t.countries, function (i, c) {
        tf += '<td ' + TFTD + '>' + (c.count === 0
            ? '0'
            : fmtN(c.count) + ' || $' + fmt(c.amount)) + '</td>';
    });
    tf += '<td ' + TFTD + '>' + fmtN(t.total_count) + ' || $' + fmt(t.total_amount) + '</td></tr>';

    return wrapTable('aio-tbl', '', th, tbody, tf, '');
}

// ── CSV Download ─────────────────────────────────────────────────────────────

function aioDownloadCSV() {
    var $tbl = $('#aio-tbl');
    if (!$tbl.length) return;
    var lines = [];
    $tbl.find('tr').each(function () {
        var cols = [];
        $(this).find('th, td').each(function () {
            cols.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
        });
        lines.push(cols.join(','));
    });
    var d    = window._aioData;
    var name = 'aio_' + (d ? d.type + '_' + d.start_date + '_' + d.end_date : 'export') + '.csv';
    var blob = new Blob([lines.join('\n')], { type: 'text/csv;charset=utf-8;' });
    var url  = URL.createObjectURL(blob);
    var a    = document.createElement('a');
    a.href = url; a.download = name;
    document.body.appendChild(a); a.click();
    document.body.removeChild(a); URL.revokeObjectURL(url);
}
</script>
