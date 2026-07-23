<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Add Publisher';
$pageIcon  = 'fa-user-plus';

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

$operators = [];
if ($conn) {
    $res = $conn->query(
        "SELECT DISTINCT operator_id, operator FROM commondb.operator_tbl ORDER BY operator ASC"
    );
    if ($res) $operators = $res->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<div class="hp-main">
<?php include('../includes/top_navigation.php'); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-user-plus"></i> Add Publisher</h4>
    </div>
    <div class="hp-card-body">

        <!-- Banners -->
        <div id="ap-success" style="display:none;margin-bottom:18px;padding:14px 18px;color:#276749;background:#f0fff4;border-left:4px solid #48bb78;border-radius:4px;">
            <i class="fa fa-check-circle"></i> <span id="ap-success-msg"></span>
        </div>
        <div id="ap-error" style="display:none;margin-bottom:18px;padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
            <i class="fa fa-exclamation-triangle"></i> <span id="ap-error-msg"></span>
        </div>

        <!-- Operator checkboxes -->
        <div style="margin-bottom:20px;padding:14px 16px;background:#f7fafc;border:1px solid #e2e8f0;border-radius:6px;">
            <label class="hp-filter-label" style="display:block;margin-bottom:10px;">
                Operator <span style="color:#e53e3e;">*</span>
                <label style="font-weight:400;margin-left:16px;cursor:pointer;">
                    <input type="checkbox" id="ap-op-all"> <span style="font-size:12px;color:#4a5568;">Select All</span>
                </label>
            </label>
            <div style="display:flex;flex-wrap:wrap;gap:6px 18px;">
                <?php foreach ($operators as $op): ?>
                    <label style="cursor:pointer;font-size:12px;white-space:nowrap;color:#2d3748;">
                        <input type="checkbox" class="ap-op-chk" value="<?= (int)$op['operator_id'] ?>">
                        <?= htmlspecialchars($op['operator']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Publisher Name <span style="color:#e53e3e;">*</span></label>
                    <input type="text" id="ap-name" class="form-control" placeholder="e.g. Everdata">
                    <small style="color:#718096;font-size:11px;">Operator code will be appended per operator (e.g. EverdataIN)</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Is Active</label>
                    <select id="ap-active" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Activation PostBack URL <span style="color:#e53e3e;">*</span></label>
                    <input type="text" id="ap-url" class="form-control" placeholder="http://...">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Deactivation PostBack URL</label>
                    <input type="text" id="ap-dct-url" class="form-control" placeholder="http://... (optional)">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Redirect URL</label>
                    <input type="text" id="ap-redirect" class="form-control" placeholder="http://bit.ly/28TEoDR">
                    <small style="color:#718096;font-size:11px;">Leave blank to use default redirect</small>
                </div>
            </div>
        </div>

        <button id="ap-submit" class="btn-submit-report" onclick="apSubmit()" disabled>
            <i class="fa fa-user-plus"></i> Add Publisher
        </button>

    </div>
</div>

<!-- ── Results Card ─────────────────────────────────────────────────────────── -->
<div id="ap-results" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-check-circle"></i> Insert Results</h4>
        </div>
        <div id="ap-results-body" class="hp-card-body"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<script>
$(document).ready(function () {
    // Select All operators
    $('#ap-op-all').on('change', function () {
        $('.ap-op-chk').prop('checked', $(this).is(':checked'));
        apCheckReady();
    });
    $(document).on('change', '.ap-op-chk', function () {
        if (!$(this).is(':checked')) $('#ap-op-all').prop('checked', false);
        else if ($('.ap-op-chk:checked').length === $('.ap-op-chk').length) $('#ap-op-all').prop('checked', true);
        apCheckReady();
    });
    $('#ap-name, #ap-url').on('input', apCheckReady);
});

function apCheckReady() {
    var hasOp   = $('.ap-op-chk:checked').length > 0;
    var hasName = !!$.trim($('#ap-name').val());
    var hasUrl  = !!$.trim($('#ap-url').val());
    $('#ap-submit').prop('disabled', !(hasOp && hasName && hasUrl));
}

function apSubmit() {
    $('#ap-error, #ap-success, #ap-results').hide();

    var ids = [];
    $('.ap-op-chk:checked').each(function () { ids.push($(this).val()); });
    if (!ids.length) { apShowError('Please select at least one operator.'); return; }

    var name    = $.trim($('#ap-name').val());
    var url     = $.trim($('#ap-url').val());
    var dctUrl  = $.trim($('#ap-dct-url').val());
    var redir   = $.trim($('#ap-redirect').val());
    var active  = $('#ap-active').val();

    if (!name) { apShowError('Publisher Name is required.'); return; }
    if (!url)  { apShowError('Activation PostBack URL is required.'); return; }

    var $btn = $('#ap-submit');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');

    var data = {
        action      : 'publisher_add',
        pub_name    : name,
        pub_url     : url,
        pub_dct_url : dctUrl,
        redirect_url: redir,
        is_active   : active
    };
    $.each(ids, function (i, v) { data['operator_ids[' + i + ']'] = v; });

    $.post('adreports/ajax.php', data)
    .done(function (r) {
        $btn.prop('disabled', false).html('<i class="fa fa-user-plus"></i> Add Publisher');
        if (!r || !r.success) { apShowError(r && r.error ? r.error : 'Unknown error.'); return; }
        apRenderResults(r);
        if (r.inserted > 0) {
            $('#ap-success-msg').text(
                'Publisher added successfully to ' + r.inserted + ' operator(s).'
                + (r.failed > 0 ? ' ' + r.failed + ' failed.' : '')
            );
            $('#ap-success').show();
        }
    })
    .fail(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-user-plus"></i> Add Publisher');
        apShowError('Request failed. Please try again.');
    });
}

function apRenderResults(r) {
    var html = '<table class="table table-bordered" style="font-size:13px;margin-bottom:0;">'
             + '<thead><tr style="background:#4a5568;color:#fff;">'
             + '<th style="padding:8px;">Operator</th>'
             + '<th style="padding:8px;">Advertiser Name (in DB)</th>'
             + '<th style="padding:8px;text-align:center;">Advertiser ID</th>'
             + '<th style="padding:8px;text-align:center;">CB Counter</th>'
             + '<th style="padding:8px;text-align:center;">Status</th>'
             + '</tr></thead><tbody>';

    $.each(r.results, function (i, row) {
        var badge = row.status === 'ok'
            ? '<span style="padding:3px 10px;border-radius:12px;background:#c6f6d5;color:#276749;font-size:12px;">OK</span>'
            : '<span style="padding:3px 10px;border-radius:12px;background:#fed7d7;color:#c53030;font-size:12px;">'
              + (row.msg || 'Error') + '</span>';
        var cb = row.status === 'ok'
            ? (row.cb_inserted
                ? '<span style="color:#276749;font-size:12px;"><i class="fa fa-check"></i> Inserted</span>'
                : '<span style="color:#718096;font-size:12px;">DB not found</span>')
            : '—';
        html += '<tr>'
              + '<td style="padding:6px 10px;">' + (row.operator || '?') + '</td>'
              + '<td style="padding:6px 10px;">' + (row.adv_name || '—') + '</td>'
              + '<td style="text-align:center;padding:6px 10px;">' + (row.advertiser_id || '—') + '</td>'
              + '<td style="text-align:center;padding:6px 10px;">' + cb + '</td>'
              + '<td style="text-align:center;padding:6px 10px;">' + badge + '</td>'
              + '</tr>';
    });
    html += '</tbody></table>';

    $('#ap-results-body').html(html);
    $('#ap-results').show();
}

function apShowError(msg) {
    $('#ap-error-msg').text(msg);
    $('#ap-error').show();
}
</script>
