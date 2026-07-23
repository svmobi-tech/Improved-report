<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'AdNetwork Report';
$pageIcon  = 'fa-file-text-o';

// Base URL so relative assets in header/footer resolve from this subdirectory.
$_docRoot  = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
$_selfDir  = rtrim(str_replace('\\', '/', dirname(__FILE__)), '/');
$_relative = str_replace($_docRoot, '', dirname($_selfDir));
$pageBase  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
           . '://' . $_SERVER['HTTP_HOST']
           . rtrim($_relative, '/') . '/';

include('../includes/check_session.php');

// PDO connection to load country list on page load
$conn = null;
ob_start();
try {
    include(dirname(dirname(dirname(__DIR__))) . '/adnetwork_admin/includes/connection.php');
} catch (Exception $e) {}
ob_end_clean();

$countries = [];
if ($conn) {
    $res = $conn->query("SELECT DISTINCT country_name, operator_tbl.country_id FROM commondb.country_tbl INNER JOIN commondb.operator_tbl ON country_tbl.country_id = operator_tbl.country_id ORDER BY country_name");
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
        <h4><i class="fa fa-file-text-o"></i> AdNetwork Report</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Country</label>
                    <select id="rpt-country" class="form-control">
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
                    <select id="rpt-operator" class="form-control" disabled>
                        <option value="">-- Select Country First --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Publisher / Advertiser</label>
                    <select id="rpt-type" class="form-control" disabled>
                        <option value="">-- Select Operator First --</option>
                        <option value="publisher">Publisher</option>
                        <option value="advertiser">Advertiser</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Name</label>
                    <select id="rpt-name" class="form-control" disabled>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Start Date</label>
                    <input type="text" id="rpt-start" class="form-control birthday" readonly>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">End Date</label>
                    <input type="text" id="rpt-end" class="form-control birthday" readonly>
                </div>
            </div>

        </div>
        <div class="row" style="margin-top:4px;">
            <div class="col-md-12">
                <button id="rpt-submit" class="btn-submit-report" onclick="rptSubmit()" disabled>
                    <i class="fa fa-search"></i> Submit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ── Error Banner ────────────────────────────────────────────────────────── -->
<div id="rpt-error" style="display:none;margin-top:16px;">
    <div style="padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
        <i class="fa fa-exclamation-triangle"></i> <span id="rpt-error-msg"></span>
    </div>
</div>

<!-- ── Results Card ────────────────────────────────────────────────────────── -->
<div id="rpt-results" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-table"></i> Output Records
                <small id="rpt-result-title" style="font-size:12px;color:#a0aec0;margin-left:8px;"></small>
            </h4>
        </div>
        <div id="rpt-table-wrap" class="hp-card-body" style="padding:0;overflow-x:auto;"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<script>
$(document).ready(function () {
    // Datepickers
    $('#rpt-start, #rpt-end').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        locale           : { format: 'DD-MM-YYYY' }
    }).on('apply.daterangepicker', rptCheckReady);

    // Country change → load operators
    $('#rpt-country').on('change', function () {
        var cid = $(this).val();
        $('#rpt-operator').prop('disabled', true).html('<option value="">Loading...</option>');
        $('#rpt-type').prop('disabled', true).html('<option value="">-- Select Operator First --</option><option value="publisher">Publisher</option><option value="advertiser">Advertiser</option>');
        $('#rpt-name').prop('disabled', true).html('<option value="all">All</option>');
        rptCheckReady();

        if (!cid) {
            $('#rpt-operator').html('<option value="">-- Select Country First --</option>');
            return;
        }

        $.post('adreports/ajax.php', { action: 'report_get_operators', country_id: cid })
        .done(function (r) {
            if (!r.success || !r.operators.length) {
                $('#rpt-operator').html('<option value="">No operators found</option>');
                return;
            }
            var opts = '<option value="">-- Select Operator --</option>';
            $.each(r.operators, function (i, op) {
                opts += '<option value="' + op.operator_id + '">' + op.operator + '</option>';
            });
            $('#rpt-operator').html(opts).prop('disabled', false);
        });
    });

    // Operator or Type change → load names
    $('#rpt-operator').on('change', function () {
        var t = $('#rpt-type').val();
        $('#rpt-type').prop('disabled', !$(this).val());
        if (!$(this).val() || !t) { $('#rpt-name').prop('disabled', true).html('<option value="all">All</option>'); return; }
        loadNames();
    });

    $('#rpt-type').on('change', function () {
        if (!$(this).val()) { $('#rpt-name').prop('disabled', true).html('<option value="all">All</option>'); return; }
        loadNames();
        rptCheckReady();
    });
});

function loadNames() {
    var opId = $('#rpt-operator').val();
    var type = $('#rpt-type').val();
    if (!opId || !type) return;

    $('#rpt-name').prop('disabled', true).html('<option value="all">Loading...</option>');
    $.post('adreports/ajax.php', { action: 'report_get_names', operator_id: opId, type: type })
    .done(function (r) {
        var opts = '<option value="all">All</option>';
        if (r.success && r.items.length) {
            $.each(r.items, function (i, item) {
                opts += '<option value="' + item.id + '">' + item.name + '</option>';
            });
        }
        $('#rpt-name').html(opts).prop('disabled', false);
        rptCheckReady();
    });
}

function rptCheckReady() {
    var ok = !!($('#rpt-operator').val() && $('#rpt-type').val() && $('#rpt-start').val() && $('#rpt-end').val());
    $('#rpt-submit').prop('disabled', !ok);
}

// ── Submit ───────────────────────────────────────────────────────────────────

function rptSubmit() {
    $('#rpt-error').hide();
    $('#rpt-results').hide();

    var $btn = $('#rpt-submit');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

    $.post('adreports/ajax.php', {
        action      : 'report_data',
        operator_id : $('#rpt-operator').val(),
        type        : $('#rpt-type').val(),
        id          : $('#rpt-name').val() || 'all',
        start_date  : $('#rpt-start').val(),
        end_date    : $('#rpt-end').val()
    })
    .done(function (r) {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        if (!r || !r.success) {
            $('#rpt-error-msg').text(r && r.error ? r.error : 'Unknown server error.');
            $('#rpt-error').show();
            return;
        }
        rptRender(r);
        $('#rpt-results').show();
    })
    .fail(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        $('#rpt-error-msg').text('Request failed. Please check your connection and try again.');
        $('#rpt-error').show();
    });
}

// ── Table renderer ───────────────────────────────────────────────────────────

function rptRender(r) {
    var label = r.type.charAt(0).toUpperCase() + r.type.slice(1);
    $('#rpt-result-title').text(label + ' — ' + r.operator + ' — ' + r.start_date + ' to ' + r.end_date);

    if (!r.rows || !r.rows.length) {
        $('#rpt-table-wrap').html(
            '<p style="padding:32px;color:#a0aec0;text-align:center;">'
          + '<i class="fa fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;"></i>'
          + 'No data found for the selected filters.</p>');
        $('#rpt-results').show();
        window._rptData = r;
        return;
    }

    var TH = 'style="background:#4a5568;color:#fff;text-align:center;white-space:nowrap;padding:8px 8px;"';
    var TD = 'style="text-align:center;white-space:nowrap;padding:6px 8px;"';

    var html = '<table id="rpt-tbl" class="table table-striped table-bordered" style="font-size:12.5px;width:100%;">'
             + '<thead><tr>'
             + '<th ' + TH + ' width="90">Date</th>'
             + '<th ' + TH + ' width="150">Name</th>'
             + '<th ' + TH + ' width="70">Clicks</th>'
             + '<th ' + TH + ' width="62">CR%</th>'
             + '<th ' + TH + ' width="90">SameDay ACT</th>'
             + '<th ' + TH + ' width="62">SPO</th>'
             + '<th ' + TH + ' width="62">SDC</th>'
             + '<th ' + TH + ' width="70">Churn</th>'
             + '<th ' + TH + ' width="72">Churn%</th>'
             + '<th ' + TH + ' width="72">Callback</th>'
             + '<th ' + TH + ' width="68">CB CR%</th>'
             + '<th ' + TH + ' width="62">CB%</th>'
             + '</tr></thead><tbody>';

    var tot = { clicks:0, sameday:0, spo:0, sdc:0, churn:0, cbr:0 };

    $.each(r.rows, function (i, row) {
        var spo   = row.act - row.sameday;
        var churn = row.dct - row.samedaydct;
        var cr    = row.clicks  ? ((row.act        / row.clicks)  * 100).toFixed(2) + '%' : '0.00%';
        var chPct = row.sameday ? ((row.samedaydct / row.sameday) * 100).toFixed(2)       : '0.00';
        var cbCr  = row.clicks  ? ((row.cbr        / row.clicks)  * 100).toFixed(2) + '%' : '0.00%';
        var cbPct = row.act     ? ((row.cbr        / row.act)     * 100).toFixed(2) + '%' : '0.00%';
        var chBadge = '<span style="color:#fff;font-weight:700;background:' + (parseFloat(chPct) > 15 ? '#e53e3e' : '#38a169') + ';padding:2px 7px;border-radius:3px;">' + chPct + '%</span>';

        tot.clicks  += row.clicks;
        tot.sameday += row.sameday;
        tot.spo     += spo;
        tot.sdc     += row.samedaydct;
        tot.churn   += churn;
        tot.cbr     += row.cbr;

        html += '<tr>'
              + '<td ' + TD + '>' + row.dt + '</td>'
              + '<td style="padding:6px 8px;">' + row.title + '</td>'
              + '<td ' + TD + '>' + row.clicks.toLocaleString() + '</td>'
              + '<td ' + TD + '>' + cr + '</td>'
              + '<td ' + TD + '>' + row.sameday.toLocaleString() + '</td>'
              + '<td ' + TD + '>' + spo.toLocaleString() + '</td>'
              + '<td ' + TD + '>' + row.samedaydct.toLocaleString() + '</td>'
              + '<td ' + TD + '>' + churn.toLocaleString() + '</td>'
              + '<td ' + TD + '>' + chBadge + '</td>'
              + '<td ' + TD + '>' + row.cbr.toLocaleString() + '</td>'
              + '<td ' + TD + '>' + cbCr + '</td>'
              + '<td ' + TD + '>' + cbPct + '</td>'
              + '</tr>';
    });

    // Totals row — totAct = sum(act) = sum(spo) + sum(sameday)
    var totAct  = tot.spo + tot.sameday;
    var tChPct  = tot.sameday ? ((tot.sdc  / tot.sameday) * 100).toFixed(2) : '0.00';
    var tCr     = tot.clicks  ? ((totAct   / tot.clicks)  * 100).toFixed(2) + '%' : '0.00%';
    var tCbCr   = tot.clicks  ? ((tot.cbr  / tot.clicks)  * 100).toFixed(2) + '%' : '0.00%';
    var tCbPct  = totAct      ? ((tot.cbr  / totAct)      * 100).toFixed(2) + '%' : '0.00%';
    var tChBadge= '<span style="color:#fff;font-weight:700;background:' + (parseFloat(tChPct) > 15 ? '#e53e3e' : '#38a169') + ';padding:2px 7px;border-radius:3px;">' + tChPct + '%</span>';
    var TF = 'style="background:#edf2f7;font-weight:700;text-align:center;white-space:nowrap;padding:6px 8px;"';

    html += '</tbody><tfoot><tr>'
          + '<td ' + TF + '>Total</td>'
          + '<td ' + TF + '></td>'
          + '<td ' + TF + '>' + tot.clicks.toLocaleString() + '</td>'
          + '<td ' + TF + '>' + tCr + '</td>'
          + '<td ' + TF + '>' + tot.sameday.toLocaleString() + '</td>'
          + '<td ' + TF + '>' + tot.spo.toLocaleString() + '</td>'
          + '<td ' + TF + '>' + tot.sdc.toLocaleString() + '</td>'
          + '<td ' + TF + '>' + tot.churn.toLocaleString() + '</td>'
          + '<td ' + TF + '>' + tChBadge + '</td>'
          + '<td ' + TF + '>' + tot.cbr.toLocaleString() + '</td>'
          + '<td ' + TF + '>' + tCbCr + '</td>'
          + '<td ' + TF + '>' + tCbPct + '</td>'
          + '</tr></tfoot></table>';

    $('#rpt-table-wrap').html(html);
    window._rptData = r;

    // Destroy any previous DataTable instance before re-init
    if ($.fn.DataTable.isDataTable('#rpt-tbl')) {
        $('#rpt-tbl').DataTable().destroy();
    }
    $('#rpt-tbl').DataTable({
        pageLength   : 50,
        order        : [],
        orderClasses : false,
        autoWidth    : false,
        dom          : '<"top"Bf>rt<"bottom"ip><"clear">',
        buttons    : [
            { extend: 'copy',      className: 'btn btn-default' },
            { extend: 'csv',       className: 'btn btn-default' },
            { extend: 'excel',     className: 'btn btn-default' },
            {
                extend    : 'pdfHtml5',
                className : 'btn btn-default',
                title     : 'AdNetwork Report | SVMobi',
                customize : function (doc) {
                    doc.pageSize    = { width: 841.89, height: 595.28 }; // A4 landscape
                    doc.pageMargins = [15, 25, 15, 15];
                    doc.defaultStyle.fontSize         = 8;
                    doc.styles.tableHeader.fontSize   = 8;
                    doc.styles.tableBodyOdd.fontSize  = 8;
                    doc.styles.tableBodyEven.fontSize = 8;
                    doc.content.forEach(function (node) {
                        if (node.table) {
                            // proportional widths across ~812pt usable A4-landscape width
                            node.table.widths = [77, 132, 60, 53, 79, 53, 53, 60, 64, 64, 64, 55];
                        }
                    });
                }
            },
            { extend: 'print', className: 'btn btn-default' }
        ]
    });
}

</script>
