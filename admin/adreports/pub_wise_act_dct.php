<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'PubID wise Activation & Deactivation';
$pageIcon  = 'fa-exchange';

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
        <h4><i class="fa fa-exchange"></i> PubID wise Activation &amp; Deactivation</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Country</label>
                    <select id="pad-country" class="form-control">
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
                    <select id="pad-operator" class="form-control" disabled>
                        <option value="">-- Select Country First --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Publisher / Advertiser</label>
                    <select id="pad-type" class="form-control" disabled>
                        <option value="">-- Select Operator First --</option>
                        <option value="publisher">Publisher</option>
                        <option value="advertiser">Advertiser</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Name</label>
                    <select id="pad-name" class="form-control" disabled>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Start Date</label>
                    <input type="text" id="pad-start" class="form-control birthday" readonly>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">End Date</label>
                    <input type="text" id="pad-end" class="form-control birthday" readonly>
                </div>
            </div>

        </div>
        <div class="row" style="margin-top:8px;">
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="pad-submit" class="btn-submit-report" onclick="padSubmit()" disabled>
                        <i class="fa fa-search"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Error Banner ────────────────────────────────────────────────────────── -->
<div id="pad-error" style="display:none;margin-top:16px;">
    <div style="padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
        <i class="fa fa-exclamation-triangle"></i> <span id="pad-error-msg"></span>
    </div>
</div>

<!-- ── Results Card ────────────────────────────────────────────────────────── -->
<div id="pad-results" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-table"></i> Output Records
                <small id="pad-result-title" style="font-size:12px;color:#a0aec0;margin-left:8px;"></small>
            </h4>
        </div>
        <div id="pad-table-wrap" class="hp-card-body" style="padding:0;overflow-x:auto;"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<script>
$(document).ready(function () {
    $('#pad-start, #pad-end').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        locale           : { format: 'DD-MM-YYYY' },
        startDate        : moment()
    }).on('apply.daterangepicker', padCheckReady);
    padCheckReady();

    $('#pad-country').on('change', function () {
        var cid = $(this).val();
        $('#pad-operator').prop('disabled', true).html('<option value="">Loading...</option>');
        $('#pad-type').prop('disabled', true).html('<option value="">-- Select Operator First --</option><option value="publisher">Publisher</option><option value="advertiser">Advertiser</option>');
        $('#pad-name').prop('disabled', true).html('<option value="all">All</option>');
        padCheckReady();
        if (!cid) { $('#pad-operator').html('<option value="">-- Select Country First --</option>'); return; }

        $.post('adreports/ajax.php', { action: 'report_get_operators', country_id: cid })
        .done(function (r) {
            if (!r.success || !r.operators.length) {
                $('#pad-operator').html('<option value="">No operators found</option>'); return;
            }
            var opts = '<option value="">-- Select Operator --</option>';
            $.each(r.operators, function (i, op) {
                opts += '<option value="' + op.operator_id + '">' + op.operator + '</option>';
            });
            $('#pad-operator').html(opts).prop('disabled', false);
        })
        .fail(function () {
            $('#pad-operator').html('<option value="">-- Failed to load --</option>');
        });
    });

    $('#pad-operator').on('change', function () {
        $('#pad-type').prop('disabled', !$(this).val());
        $('#pad-name').prop('disabled', true).html('<option value="all">All</option>');
        padCheckReady();
    });

    $('#pad-type').on('change', function () {
        $('#pad-name').prop('disabled', true).html('<option value="all">Loading...</option>');
        padCheckReady();
        var opId = $('#pad-operator').val();
        var type = $(this).val();
        if (!opId || !type) { $('#pad-name').html('<option value="all">All</option>'); return; }

        $.post('adreports/ajax.php', { action: 'report_get_names', operator_id: opId, type: type })
        .done(function (r) {
            var opts = '<option value="all">All</option>';
            if (r.success && r.items && r.items.length) {
                $.each(r.items, function (i, item) {
                    opts += '<option value="' + item.id + '">' + item.name + '</option>';
                });
            }
            $('#pad-name').html(opts).prop('disabled', false);
        })
        .fail(function () {
            $('#pad-name').html('<option value="all">All</option>').prop('disabled', false);
        });
    });
});

function padCheckReady() {
    var ok = !!($('#pad-operator').val() && $('#pad-type').val() && $('#pad-start').val() && $('#pad-end').val());
    $('#pad-submit').prop('disabled', !ok);
}

function padSubmit() {
    $('#pad-error').hide();
    $('#pad-results').hide();

    var $btn = $('#pad-submit');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

    $.post('adreports/ajax.php', {
        action      : 'adreport_pub_act_dct',
        operator_id : $('#pad-operator').val(),
        type        : $('#pad-type').val(),
        id          : $('#pad-name').val() || 'all',
        start_date  : $('#pad-start').val(),
        end_date    : $('#pad-end').val()
    })
    .done(function (r) {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        if (!r || !r.success) {
            $('#pad-error-msg').text(r && r.error ? r.error : 'Unknown server error.');
            $('#pad-error').show(); return;
        }
        padRender(r);
        $('#pad-results').show();
    })
    .fail(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Submit');
        $('#pad-error-msg').text('Request failed. Please check your connection and try again.');
        $('#pad-error').show();
    });
}

function padRender(r) {
    var typeLabel = r.type.charAt(0).toUpperCase() + r.type.slice(1);
    $('#pad-result-title').text(
        typeLabel + ' — ' + r.operator + ' — ' + r.start_date + ' to ' + r.end_date
    );

    if (!r.rows || !r.rows.length) {
        $('#pad-table-wrap').html(
            '<p style="padding:32px;color:#a0aec0;text-align:center;">'
          + '<i class="fa fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;"></i>'
          + 'No data found for the selected filters.</p>'
        );
        return;
    }

    var TH  = 'style="background:#4a5568;color:#fff;text-align:center;white-space:nowrap;padding:8px;"';
    var THL = 'style="background:#4a5568;color:#fff;text-align:left;white-space:nowrap;padding:8px;"';
    var TDC = 'style="text-align:center;white-space:nowrap;padding:6px 8px;font-size:13px;"';
    var TDL = 'style="text-align:left;white-space:nowrap;padding:6px 8px;font-size:13px;"';
    var TDB = 'style="text-align:center;white-space:nowrap;padding:6px 8px;font-size:13px;font-weight:600;"';
    var TF  = 'style="background:#edf2f7;font-weight:700;text-align:center;white-space:nowrap;padding:6px 8px;font-size:13px;"';

    var titleLabel = (r.type === 'advertiser') ? 'Campaign Title' : 'Publisher Name';

    var thead = '<tr>'
              + '<th ' + TH  + '>Date</th>'
              + '<th ' + THL + '>' + titleLabel + '</th>'
              + '<th ' + TH  + '>PubID</th>'
              + '<th ' + TH  + '>Clicks</th>'
              + '<th ' + TH  + '>Activation</th>'
              + '<th ' + TH  + '>CR%</th>'
              + '</tr>';

    var tbody = '';
    $.each(r.rows, function (i, row) {
        var clicks = parseInt(row.clicks) || 0;
        var act    = parseInt(row.act)    || 0;
        var cr     = (clicks > 0) ? (act / clicks * 100).toFixed(2) : '0.00';
        tbody += '<tr>'
               + '<td ' + TDC + '>' + row.dt + '</td>'
               + '<td ' + TDL + '>' + (row.title || '—') + '</td>'
               + '<td ' + TDC + '>' + (row.pubid || '—') + '</td>'
               + '<td ' + TDC + '>' + clicks.toLocaleString() + '</td>'
               + '<td ' + TDB + '>' + act.toLocaleString() + '</td>'
               + '<td ' + TDC + '>' + cr + ' %</td>'
               + '</tr>';
    });

    var totalCr = (r.total_clicks > 0)
        ? (r.total_act / r.total_clicks * 100).toFixed(2)
        : '0.00';

    var tfoot = '<tr>'
              + '<td ' + TF + '>Total</td>'
              + '<td ' + TF + '></td>'
              + '<td ' + TF + '></td>'
              + '<td ' + TF + '>' + parseInt(r.total_clicks).toLocaleString() + '</td>'
              + '<td ' + TF + '>' + parseInt(r.total_act).toLocaleString() + '</td>'
              + '<td ' + TF + '>' + totalCr + ' %</td>'
              + '</tr>';

    var html = '<table id="pad-tbl" class="table table-striped table-bordered" style="font-size:13px;width:100%;">'
             + '<thead>' + thead + '</thead>'
             + '<tbody>' + tbody + '</tbody>'
             + '<tfoot>' + tfoot + '</tfoot></table>';

    $('#pad-table-wrap').html(html);

    if ($.fn.DataTable.isDataTable('#pad-tbl')) { $('#pad-tbl').DataTable().destroy(); }

    $('#pad-tbl').DataTable({
        pageLength   : 50,
        order        : [[0, 'asc'], [2, 'asc']],
        orderClasses : false,
        autoWidth    : false,
        dom          : '<"top"Bf>rt<"bottom"ip><"clear">',
        buttons      : [
            { extend: 'copy',  className: 'btn btn-default' },
            { extend: 'csv',   className: 'btn btn-default' },
            { extend: 'excel', className: 'btn btn-default' },
            {
                extend      : 'pdfHtml5',
                className   : 'btn btn-default',
                title       : 'PubID wise Act & Dct | SVMobi',
                orientation : 'landscape',
                pageSize    : 'A4',
                customize   : function (doc) {
                    doc.defaultStyle.fontSize         = 9;
                    doc.styles.tableHeader.fontSize   = 9;
                    doc.styles.tableBodyOdd.fontSize  = 9;
                    doc.styles.tableBodyEven.fontSize = 9;
                    doc.content.forEach(function (node) {
                        if (node.table && node.table.body && node.table.body.length) {
                            node.table.widths = ['12%', '38%', '12%', '13%', '13%', '12%'];
                        }
                    });
                }
            },
            { extend: 'print', className: 'btn btn-default' }
        ]
    });
}
</script>
