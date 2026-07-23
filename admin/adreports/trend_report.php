<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Trend Report';
$pageIcon  = 'fa-bar-chart';

$_docRoot  = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
$_selfDir  = rtrim(str_replace('\\', '/', dirname(__FILE__)), '/');
$_relative = str_replace($_docRoot, '', dirname($_selfDir));
$pageBase  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
           . '://' . $_SERVER['HTTP_HOST']
           . rtrim($_relative, '/') . '/';

include('../includes/check_session.php');

$conn = null;
ob_start();
try { require_once dirname(__DIR__) . '/includes/config.php'; } catch (Throwable $e) {}
ob_get_clean();

if (defined('DB_HOST')) {
    try {
        $conn = new PDO(
            'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8',
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) { $conn = null; }
}

$countries = [];
if ($conn) {
    $res = $conn->query(
        "SELECT DISTINCT country_name, operator_tbl.country_id
         FROM commondb.country_tbl
         INNER JOIN commondb.operator_tbl ON country_tbl.country_id = operator_tbl.country_id
         ORDER BY country_name"
    );
    if ($res) $countries = $res->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<div class="hp-main">
<?php include('../includes/top_navigation.php'); ?>
<div class="hp-content">

<!-- ── Filter Card ─────────────────────────────────────────────────────────── -->
<div class="hp-card hp-filter-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-bar-chart"></i> Trend Report</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Country</label>
                    <select id="tr-country" class="form-control">
                        <option value="">-- Select Country --</option>
                        <?php foreach ($countries as $c): ?>
                            <option value="<?= (int)$c['country_id'] ?>"><?= htmlspecialchars($c['country_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Operator</label>
                    <select id="tr-operator" class="form-control" disabled>
                        <option value="">-- Select Country First --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Publisher / Advertiser</label>
                    <select id="tr-type" class="form-control" disabled>
                        <option value="">-- Select Operator First --</option>
                        <option value="publisher">Publisher</option>
                        <option value="advertiser">Advertiser</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Name</label>
                    <select id="tr-name" class="form-control" disabled>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Start Date</label>
                    <input type="text" id="tr-start" class="form-control birthday" readonly>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">End Date</label>
                    <input type="text" id="tr-end" class="form-control birthday" readonly>
                </div>
            </div>

        </div>
        <div class="row" style="margin-top:8px;">

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Display</label>
                    <select id="tr-display" class="form-control">
                        <option value="clicks">Clicks</option>
                        <option value="activation">Activation</option>
                        <option value="churn">Churn</option>
                        <option value="cr">CR%</option>
                        <option value="cb">Callback</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="tr-submit" class="btn-submit-report" onclick="trSubmit()" disabled>
                        <i class="fa fa-search"></i> Submit
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ── Error Banner ────────────────────────────────────────────────────────── -->
<div id="tr-error" style="display:none;margin-top:16px;">
    <div style="padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
        <i class="fa fa-exclamation-triangle"></i> <span id="tr-error-msg"></span>
    </div>
</div>

<!-- ── Results Card ────────────────────────────────────────────────────────── -->
<div id="tr-results" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-table"></i> Output Records
                <small id="tr-result-title" style="font-size:12px;color:#a0aec0;margin-left:8px;"></small>
            </h4>
        </div>
        <div id="tr-table-wrap" class="hp-card-body" style="padding:0;overflow-x:auto;"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<script>
$(document).ready(function () {
    $('#tr-start, #tr-end').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        locale           : { format: 'DD-MM-YYYY' },
        startDate        : moment()
    }).on('apply.daterangepicker', trCheckReady);
    trCheckReady();

    $('#tr-country').on('change', function () {
        var cid = $(this).val();
        $('#tr-operator').prop('disabled', true).html('<option value="">Loading...</option>');
        $('#tr-type').prop('disabled', true).html('<option value="">-- Select Operator First --</option><option value="publisher">Publisher</option><option value="advertiser">Advertiser</option>');
        $('#tr-name').prop('disabled', true).html('<option value="all">All</option>');
        trCheckReady();
        if (!cid) { $('#tr-operator').html('<option value="">-- Select Country First --</option>'); return; }

        $.post('adreports/ajax.php', { action: 'report_get_operators', country_id: cid })
        .done(function (r) {
            if (!r.success || !r.operators.length) {
                $('#tr-operator').html('<option value="">No operators found</option>'); return;
            }
            var opts = '<option value="">-- Select Operator --</option>';
            $.each(r.operators, function (i, op) {
                opts += '<option value="' + op.operator_id + '">' + op.operator + '</option>';
            });
            $('#tr-operator').html(opts).prop('disabled', false);
        })
        .fail(function () {
            $('#tr-operator').html('<option value="">-- Failed to load --</option>');
        });
    });

    $('#tr-operator').on('change', function () {
        $('#tr-type').prop('disabled', !$(this).val());
        $('#tr-name').prop('disabled', true).html('<option value="all">All</option>');
        trCheckReady();
    });

    $('#tr-type').on('change', function () {
        $('#tr-name').prop('disabled', true).html('<option value="all">Loading...</option>');
        trCheckReady();
        var opId = $('#tr-operator').val();
        var type = $(this).val();
        if (!opId || !type) { $('#tr-name').html('<option value="all">All</option>'); return; }

        $.post('adreports/ajax.php', { action: 'report_get_names', operator_id: opId, type: type })
        .done(function (r) {
            var opts = '<option value="all">All</option>';
            if (r.success && r.items && r.items.length) {
                $.each(r.items, function (i, item) {
                    opts += '<option value="' + item.id + '">' + item.name + '</option>';
                });
            }
            $('#tr-name').html(opts).prop('disabled', false);
        })
        .fail(function () {
            $('#tr-name').html('<option value="all">All</option>').prop('disabled', false);
        });
    });

    $('#tr-display').on('change', trCheckReady);
});

function trCheckReady() {
    var ok = !!($('#tr-operator').val() && $('#tr-type').val() && $('#tr-start').val() && $('#tr-end').val());
    $('#tr-submit').prop('disabled', !ok);
}

function trSubmit() {
    $('#tr-error').hide();
    $('#tr-results').hide();

    var $btn = $('#tr-submit');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

    $.post('adreports/ajax.php', {
        action      : 'adreport_trend',
        operator_id : $('#tr-operator').val(),
        type        : $('#tr-type').val(),
        id          : $('#tr-name').val() || 'all',
        start_date  : $('#tr-start').val(),
        end_date    : $('#tr-end').val(),
        display     : $('#tr-display').val()
    })
    .done(function (r) {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        if (!r || !r.success) {
            $('#tr-error-msg').text(r && r.error ? r.error : 'Unknown server error.');
            $('#tr-error').show(); return;
        }
        trRender(r);
        $('#tr-results').show();
    })
    .fail(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        $('#tr-error-msg').text('Request failed. Please check your connection and try again.');
        $('#tr-error').show();
    });
}

function trRender(r) {
    var dispLabels = { activation:'Activation', churn:'Churn', clicks:'Clicks', cr:'CR%', cb:'Callback' };
    var typeLabel  = r.type.charAt(0).toUpperCase() + r.type.slice(1);
    $('#tr-result-title').text(
        typeLabel + ' — ' + r.operator + ' — ' + (dispLabels[r.display] || r.display) +
        ' — ' + r.start_date + ' to ' + r.end_date
    );

    if (!r.rows || !r.rows.length) {
        $('#tr-table-wrap').html(
            '<p style="padding:32px;color:#a0aec0;text-align:center;">'
          + '<i class="fa fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;"></i>'
          + 'No data found for the selected filters.</p>'
        );
        return;
    }

    // Collect unique hours present in data, sorted
    var hourSet = {};
    $.each(r.rows, function (i, row) { hourSet[parseInt(row.hr)] = true; });
    var hours = Object.keys(hourSet).map(Number).sort(function (a, b) { return a - b; });

    // Build date → { hr: val } map
    var dateMap = {};
    var dateOrder = [];
    $.each(r.rows, function (i, row) {
        var dt = row.dt, hr = parseInt(row.hr), val = row.val;
        if (!dateMap[dt]) { dateMap[dt] = {}; dateOrder.push(dt); }
        dateMap[dt][hr] = val;
    });

    var isCr = r.is_cr;

    function fmtVal(v) {
        if (v === undefined || v === null) return isCr ? '0.00%' : '0';
        return isCr ? parseFloat(v).toFixed(2) + '%' : parseInt(v).toLocaleString();
    }

    var TH  = 'style="background:#4a5568;color:#fff;text-align:center;white-space:nowrap;padding:7px 4px;font-size:12px;"';
    var TDC = 'style="text-align:center;white-space:nowrap;padding:5px 3px;font-size:12px;"';
    var TDB = 'style="text-align:center;white-space:nowrap;padding:5px 4px;font-size:12px;font-weight:600;"';
    var TF  = 'style="background:#edf2f7;font-weight:700;text-align:center;white-space:nowrap;padding:5px 3px;font-size:12px;"';

    // colgroup sets widths at the browser level (DataTables also reads these)
    var colgroup = '<colgroup><col style="width:90px;">';
    $.each(hours, function () { colgroup += '<col style="width:36px;">'; });
    colgroup += '<col style="width:60px;"></colgroup>';

    // Header row
    var thead = '<tr><th ' + TH + ' style="background:#4a5568;color:#fff;text-align:center;white-space:nowrap;padding:7px 4px;font-size:12px;width:90px;">Date</th>';
    $.each(hours, function (i, hr) {
        thead += '<th ' + TH + ' style="background:#4a5568;color:#fff;text-align:center;white-space:nowrap;padding:7px 2px;font-size:12px;width:36px;">' + hr + '</th>';
    });
    thead += '<th ' + TH + ' style="background:#4a5568;color:#fff;text-align:center;white-space:nowrap;padding:7px 4px;font-size:12px;width:60px;">Total</th></tr>';

    // Body rows
    var tbody = '';
    var colTotals = {};
    $.each(hours, function (i, hr) { colTotals[hr] = 0; });
    var grandTotal = 0;

    $.each(dateOrder, function (i, dt) {
        var rowTotal = 0;
        var tds = '';
        $.each(hours, function (j, hr) {
            var raw = dateMap[dt][hr];
            var num = parseFloat(raw || 0);
            colTotals[hr] += num;
            rowTotal += num;
            tds += '<td ' + TDC + '>' + fmtVal(raw) + '</td>';
        });
        grandTotal += rowTotal;
        tbody += '<tr><td ' + TDC + '>' + dt + '</td>' + tds + '<td ' + TDB + '>' + fmtVal(isCr ? 0 : rowTotal) + '</td></tr>';
    });

    // Footer totals (skip total-of-totals for CR as it's not meaningful)
    var tfoot = '<tr><td ' + TF + '>Total</td>';
    $.each(hours, function (i, hr) {
        tfoot += '<td ' + TF + '>' + (isCr ? '' : parseInt(colTotals[hr]).toLocaleString()) + '</td>';
    });
    tfoot += '<td ' + TF + '>' + (isCr ? '' : grandTotal.toLocaleString()) + '</td></tr>';

    var html = '<table id="tr-tbl" class="table table-striped table-bordered" style="font-size:12px;">'
             + colgroup
             + '<thead>' + thead + '</thead>'
             + '<tbody>' + tbody + '</tbody>'
             + '<tfoot>' + tfoot + '</tfoot></table>';

    $('#tr-table-wrap').html(html);

    if ($.fn.DataTable.isDataTable('#tr-tbl')) { $('#tr-tbl').DataTable().destroy(); }

    var hrTargets = [];
    for (var i = 1; i <= hours.length; i++) hrTargets.push(i);

    $('#tr-tbl').DataTable({
        pageLength   : 50,
        order        : [],
        orderClasses : false,
        autoWidth    : false,
        columnDefs   : [
            { width: '90px', targets: 0 },
            { width: '36px', targets: hrTargets },
            { width: '60px', targets: hours.length + 1 }
        ],
        dom          : '<"top"Bf>rt<"bottom"ip><"clear">',
        buttons      : [
            { extend: 'copy',  className: 'btn btn-default' },
            { extend: 'csv',   className: 'btn btn-default' },
            { extend: 'excel', className: 'btn btn-default' },
            {
                extend    : 'pdfHtml5',
                className : 'btn btn-default',
                title     : 'Trend Report | SVMobi',
                customize : function (doc) {
                    doc.pageSize        = 'A4';
                    doc.pageOrientation = 'landscape';
                    doc.pageMargins     = [10, 25, 10, 10];
                    doc.defaultStyle.fontSize         = 7;
                    doc.styles.tableHeader.fontSize   = 7;
                    doc.styles.tableBodyOdd.fontSize  = 7;
                    doc.styles.tableBodyEven.fontSize = 7;
                    doc.content.forEach(function (node) {
                        if (node.table && node.table.body && node.table.body.length) {
                            var len    = node.table.body[0].length; // actual col count
                            var nHours = Math.max(1, len - 2);      // exclude Date + Total
                            var usable = 822;                        // A4 landscape - margins
                            var dateW  = 65;
                            var totW   = 42;
                            var hrW    = Math.floor((usable - dateW - totW) / nHours);
                            var widths = [dateW];
                            for (var i = 0; i < nHours; i++) widths.push(hrW);
                            widths.push(totW);
                            node.table.widths = widths;
                        }
                    });
                }
            },
            { extend: 'print', className: 'btn btn-default' }
        ]
    });
}
</script>
