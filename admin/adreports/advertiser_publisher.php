<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Advertiser & Publisher Report';
$pageIcon  = 'fa-users';

$_docRoot  = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
$_selfDir  = rtrim(str_replace('\\', '/', dirname(__FILE__)), '/');
$_relative = str_replace($_docRoot, '', dirname($_selfDir));
$pageBase  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
           . '://' . $_SERVER['HTTP_HOST']
           . rtrim($_relative, '/') . '/';

include('../includes/check_session.php');

$conn = null;
ob_start();
try {
    include(dirname(dirname(dirname(__DIR__))) . '/adnetwork_admin/includes/connection.php');
} catch (Exception $e) {}
ob_end_clean();

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
        <h4><i class="fa fa-users"></i> Advertiser &amp; Publisher Report</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Country</label>
                    <select id="ap-country" class="form-control">
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
                    <select id="ap-operator" class="form-control" disabled>
                        <option value="">-- Select Country First --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Start Date</label>
                    <input type="text" id="ap-start" class="form-control birthday" readonly>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">End Date</label>
                    <input type="text" id="ap-end" class="form-control birthday" readonly>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Display</label>
                    <select id="ap-display" class="form-control">
                        <option value="activation">Activation</option>
                        <option value="cbs">CBS</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="ap-submit" class="btn-submit-report" onclick="apSubmit()" disabled>
                        <i class="fa fa-search"></i> Submit
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ── Error Banner ────────────────────────────────────────────────────────── -->
<div id="ap-error" style="display:none;margin-top:16px;">
    <div style="padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
        <i class="fa fa-exclamation-triangle"></i> <span id="ap-error-msg"></span>
    </div>
</div>

<!-- ── Results Card ────────────────────────────────────────────────────────── -->
<div id="ap-results" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-table"></i> Results
                <small id="ap-result-title" style="font-size:12px;color:#a0aec0;margin-left:8px;"></small>
            </h4>
        </div>
        <div id="ap-table-wrap" class="hp-card-body" style="padding:0;overflow-x:auto;"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<script>
$(document).ready(function () {
    $('#ap-start, #ap-end').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        locale           : { format: 'DD-MM-YYYY' },
        startDate        : moment()
    }).on('apply.daterangepicker', apCheckReady);
    apCheckReady();

    $('#ap-country').on('change', function () {
        var cid = $(this).val();
        $('#ap-operator').prop('disabled', true).html('<option value="">Loading...</option>');
        apCheckReady();
        if (!cid) { $('#ap-operator').html('<option value="">-- Select Country First --</option>'); return; }

        $.post('ajax.php', { action: 'report_get_operators', country_id: cid })
        .done(function (r) {
            if (!r.success || !r.operators.length) {
                $('#ap-operator').html('<option value="">No operators found</option>'); return;
            }
            var opts = '<option value="">-- Select Operator --</option>';
            $.each(r.operators, function (i, op) {
                opts += '<option value="' + op.operator_id + '">' + op.operator + '</option>';
            });
            $('#ap-operator').html(opts).prop('disabled', false);
        })
        .fail(function () {
            $('#ap-operator').html('<option value="">-- Failed to load --</option>');
        });
    });

    $('#ap-operator').on('change', apCheckReady);
    $('#ap-display').on('change', apCheckReady);
});

function apCheckReady() {
    var ok = !!($('#ap-operator').val() && $('#ap-start').val() && $('#ap-end').val());
    $('#ap-submit').prop('disabled', !ok);
}

function apSubmit() {
    $('#ap-error').hide();
    $('#ap-results').hide();

    var $btn = $('#ap-submit');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

    $.post('ajax.php', {
        action      : 'adreport_adv_pub',
        operator_id : $('#ap-operator').val(),
        start_date  : $('#ap-start').val(),
        end_date    : $('#ap-end').val(),
        display     : $('#ap-display').val()
    })
    .done(function (r) {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        if (!r || !r.success) {
            $('#ap-error-msg').text(r && r.error ? r.error : 'Unknown server error.');
            $('#ap-error').show(); return;
        }
        apRender(r);
        $('#ap-results').show();
    })
    .fail(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        $('#ap-error-msg').text('Request failed. Please check your connection and try again.');
        $('#ap-error').show();
    });
}

function apRender(r) {
    var dispLabel = r.display === 'cbs' ? 'CBS' : 'Activation';
    $('#ap-result-title').text(
        r.operator + ' — ' + dispLabel + ' — ' + r.start_date + ' to ' + r.end_date
    );

    if (!r.rows || !r.rows.length) {
        $('#ap-table-wrap').html(
            '<p style="padding:32px;color:#a0aec0;text-align:center;">'
          + '<i class="fa fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;"></i>'
          + 'No data found for the selected filters.</p>'
        );
        return;
    }

    var TH  = 'style="background:#4a5568;color:#fff;text-align:center;white-space:nowrap;padding:8px;"';
    var TDC = 'style="text-align:center;white-space:nowrap;padding:6px 8px;"';
    var TDB = 'style="text-align:center;white-space:nowrap;padding:6px 8px;font-weight:600;"';
    var TF  = 'style="background:#edf2f7;font-weight:700;text-align:center;white-space:nowrap;padding:6px 8px;"';

    var thead = '<tr>'
              + '<th ' + TH + '>Date</th>'
              + '<th ' + TH + '>Campaign</th>'
              + '<th ' + TH + '>Publisher</th>'
              + '<th ' + TH + '>Count</th>'
              + '</tr>';

    var tbody = '';
    $.each(r.rows, function (i, row) {
        tbody += '<tr>'
               + '<td ' + TDC + '>' + row.dt + '</td>'
               + '<td ' + TDC + '>' + row.campaign + '</td>'
               + '<td ' + TDC + '>' + row.publisher + '</td>'
               + '<td ' + TDB + '>' + parseInt(row.cnt).toLocaleString() + '</td>'
               + '</tr>';
    });

    var tfoot = '<tr>'
              + '<td ' + TF + ' colspan="3">Total</td>'
              + '<td ' + TF + '>' + parseInt(r.total).toLocaleString() + '</td>'
              + '</tr>';

    var html = '<table id="ap-tbl" class="table table-striped table-bordered" style="font-size:12.5px;width:100%;">'
             + '<thead>' + thead + '</thead>'
             + '<tbody>' + tbody + '</tbody>'
             + '<tfoot>' + tfoot + '</tfoot></table>';

    $('#ap-table-wrap').html(html);

    if ($.fn.DataTable.isDataTable('#ap-tbl')) { $('#ap-tbl').DataTable().destroy(); }

    $('#ap-tbl').DataTable({
        pageLength   : 50,
        order        : [[0, 'asc'], [1, 'asc']],
        orderClasses : false,
        autoWidth    : false,
        dom          : '<"top"Bf>rt<"bottom"ip><"clear">',
        buttons      : [
            { extend: 'copy',  className: 'btn btn-default' },
            { extend: 'csv',   className: 'btn btn-default' },
            { extend: 'excel', className: 'btn btn-default' },
            {
                extend    : 'pdfHtml5',
                className : 'btn btn-default',
                title     : 'Advertiser & Publisher Report | SVMobi',
                customize : function (doc) {
                    doc.pageSize    = { width: 595.28, height: 841.89 }; // A4 portrait
                    doc.pageMargins = [20, 30, 20, 20];
                    doc.defaultStyle.fontSize         = 9;
                    doc.styles.tableHeader.fontSize   = 9;
                    doc.styles.tableBodyOdd.fontSize  = 9;
                    doc.styles.tableBodyEven.fontSize = 9;
                    doc.content.forEach(function (node) {
                        if (node.table) {
                            node.table.widths = ['15%', '40%', '30%', '15%'];
                        }
                    });
                }
            },
            { extend: 'print', className: 'btn btn-default' }
        ]
    });
}
</script>
