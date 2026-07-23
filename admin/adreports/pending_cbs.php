<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Pending Callbacks';
$pageIcon  = 'fa-clock-o';

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
        <h4><i class="fa fa-clock-o"></i> Pending Callbacks</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Country</label>
                    <select id="pcb-country" class="form-control">
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
                    <select id="pcb-operator" class="form-control" disabled>
                        <option value="">-- Select Country First --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Publisher / Advertiser</label>
                    <select id="pcb-type" class="form-control" disabled>
                        <option value="">-- Select Operator First --</option>
                        <option value="publisher">Publisher</option>
                        <option value="advertiser">Advertiser</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Name</label>
                    <select id="pcb-name" class="form-control" disabled>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Start Date</label>
                    <input type="text" id="pcb-start" class="form-control birthday" readonly>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">End Date</label>
                    <input type="text" id="pcb-end" class="form-control birthday" readonly>
                </div>
            </div>

        </div>
        <div class="row" style="margin-top:8px;">
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="pcb-submit" class="btn-submit-report" onclick="pcbSearch()" disabled>
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Error Banner ────────────────────────────────────────────────────────── -->
<div id="pcb-error" style="display:none;margin-top:16px;">
    <div style="padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
        <i class="fa fa-exclamation-triangle"></i> <span id="pcb-error-msg"></span>
    </div>
</div>

<!-- ── Push Result Banner ───────────────────────────────────────────────────── -->
<div id="pcb-push-result" style="display:none;margin-top:16px;">
    <div style="padding:14px 18px;color:#276749;background:#f0fff4;border-left:4px solid #48bb78;border-radius:4px;">
        <i class="fa fa-check-circle"></i> <span id="pcb-push-msg"></span>
    </div>
</div>

<!-- ── Results Card ─────────────────────────────────────────────────────────── -->
<div id="pcb-results" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <h4 style="margin:0;"><i class="fa fa-table"></i> Output Records
                <small id="pcb-result-title" style="font-size:12px;color:#a0aec0;margin-left:8px;"></small>
            </h4>
            <button id="pcb-push-btn" class="btn btn-primary btn-sm" onclick="pcbPush()" style="display:none;">
                <i class="fa fa-send"></i> Push Selected
            </button>
        </div>
        <div id="pcb-table-wrap" class="hp-card-body" style="padding:0;overflow-x:auto;"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<script>
// Store state for push action
var pcbOperatorId = 0;

$(document).ready(function () {
    $('#pcb-start, #pcb-end').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        locale           : { format: 'DD-MM-YYYY' },
        startDate        : moment()
    }).on('apply.daterangepicker', pcbCheckReady);
    pcbCheckReady();

    $('#pcb-country').on('change', function () {
        var cid = $(this).val();
        $('#pcb-operator').prop('disabled', true).html('<option value="">Loading...</option>');
        $('#pcb-type').prop('disabled', true).html('<option value="">-- Select Operator First --</option><option value="publisher">Publisher</option><option value="advertiser">Advertiser</option>');
        $('#pcb-name').prop('disabled', true).html('<option value="all">All</option>');
        pcbCheckReady();
        if (!cid) { $('#pcb-operator').html('<option value="">-- Select Country First --</option>'); return; }

        $.post('adreports/ajax.php', { action: 'report_get_operators', country_id: cid })
        .done(function (r) {
            if (!r.success || !r.operators.length) {
                $('#pcb-operator').html('<option value="">No operators found</option>'); return;
            }
            var opts = '<option value="">-- Select Operator --</option>';
            $.each(r.operators, function (i, op) {
                opts += '<option value="' + op.operator_id + '">' + op.operator + '</option>';
            });
            $('#pcb-operator').html(opts).prop('disabled', false);
        })
        .fail(function () {
            $('#pcb-operator').html('<option value="">-- Failed to load --</option>');
        });
    });

    $('#pcb-operator').on('change', function () {
        $('#pcb-type').prop('disabled', !$(this).val());
        $('#pcb-name').prop('disabled', true).html('<option value="all">All</option>');
        pcbCheckReady();
    });

    $('#pcb-type').on('change', function () {
        $('#pcb-name').prop('disabled', true).html('<option value="all">Loading...</option>');
        pcbCheckReady();
        var opId = $('#pcb-operator').val();
        var type = $(this).val();
        if (!opId || !type) { $('#pcb-name').html('<option value="all">All</option>'); return; }

        $.post('adreports/ajax.php', { action: 'report_get_names', operator_id: opId, type: type })
        .done(function (r) {
            var opts = '<option value="all">All</option>';
            if (r.success && r.items && r.items.length) {
                $.each(r.items, function (i, item) {
                    opts += '<option value="' + item.id + '">' + item.name + '</option>';
                });
            }
            $('#pcb-name').html(opts).prop('disabled', false);
        })
        .fail(function () {
            $('#pcb-name').html('<option value="all">All</option>').prop('disabled', false);
        });
    });
});

function pcbCheckReady() {
    var ok = !!($('#pcb-operator').val() && $('#pcb-type').val() && $('#pcb-start').val() && $('#pcb-end').val());
    $('#pcb-submit').prop('disabled', !ok);
}

function pcbSearch() {
    $('#pcb-error, #pcb-push-result').hide();
    $('#pcb-results').hide();
    $('#pcb-push-btn').hide();

    var $btn = $('#pcb-submit');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Searching...');

    pcbOperatorId = $('#pcb-operator').val();

    $.post('adreports/ajax.php', {
        action      : 'pending_cbs_search',
        operator_id : pcbOperatorId,
        type        : $('#pcb-type').val(),
        id          : $('#pcb-name').val() || 'all',
        start_date  : $('#pcb-start').val(),
        end_date    : $('#pcb-end').val()
    })
    .done(function (r) {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        if (!r || !r.success) {
            $('#pcb-error-msg').text(r && r.error ? r.error : 'Unknown server error.');
            $('#pcb-error').show(); return;
        }
        pcbRender(r);
        $('#pcb-results').show();
    })
    .fail(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        $('#pcb-error-msg').text('Request failed. Please try again.');
        $('#pcb-error').show();
    });
}

function pcbRender(r) {
    $('#pcb-result-title').text(r.operator + ' — ' + r.start_date + ' to ' + r.end_date);

    if (!r.rows || !r.rows.length) {
        $('#pcb-table-wrap').html(
            '<p style="padding:32px;color:#a0aec0;text-align:center;">'
          + '<i class="fa fa-check-circle" style="font-size:32px;display:block;margin-bottom:10px;color:#68d391;"></i>'
          + 'No pending callbacks found for the selected filters.</p>'
        );
        $('#pcb-push-btn').hide();
        return;
    }

    var TH  = 'style="background:#4a5568;color:#fff;text-align:center;white-space:nowrap;padding:8px;"';
    var THL = 'style="background:#4a5568;color:#fff;text-align:left;white-space:nowrap;padding:8px;"';
    var TDC = 'style="text-align:center;white-space:nowrap;padding:6px 8px;font-size:13px;"';
    var TDL = 'style="text-align:left;white-space:nowrap;padding:6px 8px;font-size:13px;"';

    var thead = '<tr>'
              + '<th ' + TH + ' style="background:#4a5568;color:#fff;padding:8px;width:36px;">'
              + '  <input type="checkbox" id="pcb-select-all" title="Select All">'
              + '</th>'
              + '<th ' + TH  + '>DateTime</th>'
              + '<th ' + THL + '>Publisher</th>'
              + '<th ' + THL + '>Advertiser</th>'
              + '</tr>';

    var tbody = '';
    $.each(r.rows, function (i, row) {
        tbody += '<tr id="pcb-row-' + row.ad_resp_id + '">'
               + '<td ' + TDC + '><input type="checkbox" class="pcb-chk" value="' + row.ad_resp_id + '"></td>'
               + '<td ' + TDC + '>' + (row.dt || '—') + '</td>'
               + '<td ' + TDL + '>' + (row.publisher || '—') + '</td>'
               + '<td ' + TDL + '>' + (row.advertiser || '—') + '</td>'
               + '</tr>';
    });

    var html = '<table id="pcb-tbl" class="table table-striped table-bordered" style="font-size:13px;width:100%;">'
             + '<thead>' + thead + '</thead>'
             + '<tbody>' + tbody + '</tbody>'
             + '</table>';

    $('#pcb-table-wrap').html(html);

    // Select-all toggle
    $('#pcb-select-all').on('change', function () {
        $('.pcb-chk').prop('checked', $(this).is(':checked'));
        pcbUpdatePushBtn();
    });
    $(document).on('change', '.pcb-chk', pcbUpdatePushBtn);

    if ($.fn.DataTable.isDataTable('#pcb-tbl')) { $('#pcb-tbl').DataTable().destroy(); }

    $('#pcb-tbl').DataTable({
        pageLength   : 50,
        order        : [[1, 'desc']],
        orderClasses : false,
        autoWidth    : false,
        columnDefs   : [{ orderable: false, targets: 0 }],
        dom          : '<"top"Bf>rt<"bottom"ip><"clear">',
        buttons      : [
            { extend: 'copy',  className: 'btn btn-default' },
            { extend: 'csv',   className: 'btn btn-default' },
            { extend: 'excel', className: 'btn btn-default' },
            {
                extend      : 'pdfHtml5',
                className   : 'btn btn-default',
                title       : 'Pending Callbacks | SVMobi',
                orientation : 'landscape',
                pageSize    : 'A4',
                customize   : function (doc) {
                    doc.defaultStyle.fontSize = 9;
                    doc.styles.tableHeader.fontSize = 9;
                    doc.content.forEach(function (node) {
                        if (node.table && node.table.body && node.table.body.length) {
                            node.table.widths = ['8%', '22%', '35%', '35%'];
                        }
                    });
                }
            },
            { extend: 'print', className: 'btn btn-default' }
        ]
    });

    $('#pcb-push-btn').show();
}

function pcbUpdatePushBtn() {
    var checked = $('.pcb-chk:checked').length;
    $('#pcb-push-btn').text(checked > 0
        ? 'Push Selected (' + checked + ')'
        : 'Push Selected'
    ).prop('disabled', checked === 0);
}

function pcbPush() {
    var ids = [];
    $('.pcb-chk:checked').each(function () { ids.push($(this).val()); });
    if (!ids.length) { alert('Please select at least one row.'); return; }

    if (!confirm('Push ' + ids.length + ' callback(s)?\n\nThis will call each callback URL and update the response in the database.')) return;

    var $btn = $('#pcb-push-btn');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Pushing ' + ids.length + '...');
    $('#pcb-push-result').hide();

    // Build POST data
    var data = { action: 'pending_cbs_push', operator_id: pcbOperatorId };
    $.each(ids, function (i, id) { data['ids[' + i + ']'] = id; });

    $.post('adreports/ajax.php', data)
    .done(function (r) {
        $btn.html('<i class="fa fa-send"></i> Push Selected').prop('disabled', false);
        if (!r || !r.success) {
            $('#pcb-error-msg').text(r && r.error ? r.error : 'Push failed.');
            $('#pcb-error').show(); return;
        }

        // Mark pushed rows visually
        $.each(r.results, function (i, item) {
            var $row = $('#pcb-row-' + item.id);
            if (item.status === 'ok') {
                $row.find('td').css('background', '#f0fff4');
                $row.find('.pcb-chk').prop('checked', false).prop('disabled', true);
            } else {
                $row.find('td').css('background', '#fff5f5');
            }
        });

        $('#pcb-push-msg').text(
            'Push complete — ' + r.pushed + ' succeeded, ' + r.failed + ' failed.'
        );
        $('#pcb-push-result').show();
        $('#pcb-select-all').prop('checked', false);
        pcbUpdatePushBtn();
    })
    .fail(function () {
        $btn.html('<i class="fa fa-send"></i> Push Selected').prop('disabled', false);
        $('#pcb-error-msg').text('Push request failed. Please try again.');
        $('#pcb-error').show();
    });
}
</script>
