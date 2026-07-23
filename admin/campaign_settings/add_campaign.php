<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Add Campaign';
$pageIcon  = 'fa-plus-circle';

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
        "SELECT country_id, country_name FROM commondb.country_tbl ORDER BY country_name"
    );
    if ($res) $countries = $res->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<div class="hp-main">
<?php include('../includes/top_navigation.php'); ?>
<div class="hp-content">

<!-- ── Form Card ─────────────────────────────────────────────────────────────── -->
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-plus-circle"></i> Add Campaign</h4>
    </div>
    <div class="hp-card-body">

        <!-- Banners -->
        <div id="ac-success" style="display:none;margin-bottom:18px;padding:14px 18px;color:#276749;background:#f0fff4;border-left:4px solid #48bb78;border-radius:4px;">
            <i class="fa fa-check-circle"></i> <span id="ac-success-msg"></span>
        </div>
        <div id="ac-error" style="display:none;margin-bottom:18px;padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
            <i class="fa fa-exclamation-triangle"></i> <span id="ac-error-msg"></span>
        </div>

        <div class="row">
            <!-- Country -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Country <span style="color:#e53e3e;">*</span></label>
                    <select id="ac-country" class="form-control">
                        <option value="">-- Select Country --</option>
                        <?php foreach ($countries as $c): ?>
                            <option value="<?= (int)$c['country_id'] ?>"><?= htmlspecialchars($c['country_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Operator checkboxes (loaded via AJAX) -->
        <div id="ac-op-wrap" style="display:none;margin-bottom:18px;padding:14px 16px;background:#f7fafc;border:1px solid #e2e8f0;border-radius:6px;">
            <label class="hp-filter-label" style="display:block;margin-bottom:10px;">
                Operator <span style="color:#e53e3e;">*</span>
                <label style="font-weight:400;margin-left:16px;cursor:pointer;">
                    <input type="checkbox" id="ac-op-all"> <span style="font-size:12px;color:#4a5568;">Select All</span>
                </label>
            </label>
            <div id="ac-op-list" style="display:flex;flex-wrap:wrap;gap:10px 20px;"></div>
        </div>
        <div id="ac-op-loading" style="display:none;color:#718096;font-size:13px;margin-bottom:18px;">
            <i class="fa fa-spinner fa-spin"></i> Loading operators...
        </div>

        <hr style="border-color:#e2e8f0;margin:6px 0 20px;">

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Campaign Partner <span style="color:#e53e3e;">*</span></label>
                    <input type="text" id="ac-partner" class="form-control" placeholder="e.g. Everdata">
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Campaign Title <span style="color:#e53e3e;">*</span></label>
                    <input type="text" id="ac-title" class="form-control" placeholder="e.g. Glamour WAP">
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Campaign Price</label>
                    <input type="number" id="ac-price" class="form-control" placeholder="Default: 10" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Campaign Weightage</label>
                    <input type="number" id="ac-weightage" class="form-control" placeholder="Default: 1" step="0.01" min="0">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Campaign URL <span style="color:#e53e3e;">*</span></label>
                    <input type="text" id="ac-url" class="form-control" placeholder="http://...">
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Campaign Live</label>
                    <select id="ac-live" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Browser -->
        <div style="margin-bottom:16px;padding:12px 14px;background:#f7fafc;border:1px solid #e2e8f0;border-radius:6px;">
            <label class="hp-filter-label" style="display:block;margin-bottom:10px;">Campaign Browser</label>
            <label style="margin-right:20px;cursor:pointer;font-size:13px;">
                <input type="checkbox" id="ac-br-all"> <strong>All</strong>
            </label>
            <label style="margin-right:20px;cursor:pointer;font-size:13px;">
                <input type="checkbox" class="ac-browser" value="chrome"> Chrome
            </label>
            <label style="margin-right:20px;cursor:pointer;font-size:13px;">
                <input type="checkbox" class="ac-browser" value="opera"> Opera
            </label>
            <label style="margin-right:20px;cursor:pointer;font-size:13px;">
                <input type="checkbox" class="ac-browser" value="ucb"> UC Browser
            </label>
            <label style="cursor:pointer;font-size:13px;">
                <input type="checkbox" class="ac-browser" value="other"> Other
            </label>
        </div>

        <!-- OS -->
        <div style="margin-bottom:24px;padding:12px 14px;background:#f7fafc;border:1px solid #e2e8f0;border-radius:6px;">
            <label class="hp-filter-label" style="display:block;margin-bottom:10px;">Campaign OS</label>
            <label style="margin-right:20px;cursor:pointer;font-size:13px;">
                <input type="checkbox" id="ac-os-all"> <strong>All</strong>
            </label>
            <label style="margin-right:20px;cursor:pointer;font-size:13px;">
                <input type="checkbox" class="ac-os" value="android"> Android
            </label>
            <label style="margin-right:20px;cursor:pointer;font-size:13px;">
                <input type="checkbox" class="ac-os" value="iphone"> iPhone
            </label>
            <label style="margin-right:20px;cursor:pointer;font-size:13px;">
                <input type="checkbox" class="ac-os" value="windows"> Windows
            </label>
            <label style="margin-right:20px;cursor:pointer;font-size:13px;">
                <input type="checkbox" class="ac-os" value="linux"> Linux
            </label>
            <label style="cursor:pointer;font-size:13px;">
                <input type="checkbox" class="ac-os" value="other"> Other
            </label>
        </div>

        <button id="ac-submit" class="btn-submit-report" onclick="acSubmit()" disabled>
            <i class="fa fa-plus-circle"></i> Add Campaign
        </button>

    </div>
</div>

<!-- ── Results Card ─────────────────────────────────────────────────────────── -->
<div id="ac-results" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-check-circle"></i> Insert Results</h4>
        </div>
        <div id="ac-results-body" class="hp-card-body"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<script>
var acCountryId = 0;

$(document).ready(function () {

    // Country → load operators as checkboxes
    $('#ac-country').on('change', function () {
        acCountryId = parseInt($(this).val()) || 0;
        $('#ac-op-wrap').hide();
        $('#ac-op-list').html('');
        $('#ac-op-all').prop('checked', false);
        acCheckReady();

        if (!acCountryId) return;
        $('#ac-op-loading').show();

        $.post('adreports/ajax.php', { action: 'report_get_operators', country_id: acCountryId })
        .done(function (r) {
            $('#ac-op-loading').hide();
            if (!r.success || !r.operators || !r.operators.length) {
                $('#ac-op-list').html('<span style="color:#718096;font-size:13px;">No operators found for this country.</span>');
                $('#ac-op-wrap').show(); return;
            }
            var html = '';
            $.each(r.operators, function (i, op) {
                html += '<label style="cursor:pointer;font-size:13px;white-space:nowrap;">'
                      + '<input type="checkbox" class="ac-op-chk" value="' + op.operator_id + '"> '
                      + op.operator
                      + '</label>';
            });
            $('#ac-op-list').html(html);
            $('#ac-op-wrap').show();
            $(document).on('change', '.ac-op-chk', acCheckReady);
        })
        .fail(function () {
            $('#ac-op-loading').hide();
            $('#ac-op-list').html('<span style="color:#c53030;font-size:13px;">Failed to load operators.</span>');
            $('#ac-op-wrap').show();
        });
    });

    // Select All operators
    $('#ac-op-all').on('change', function () {
        $('.ac-op-chk').prop('checked', $(this).is(':checked'));
        acCheckReady();
    });

    // Browser "All" toggle
    $('#ac-br-all').on('change', function () {
        $('.ac-browser').prop('checked', $(this).is(':checked'));
    });
    $(document).on('change', '.ac-browser', function () {
        if (!$(this).is(':checked')) $('#ac-br-all').prop('checked', false);
        else if ($('.ac-browser:checked').length === $('.ac-browser').length) $('#ac-br-all').prop('checked', true);
    });

    // OS "All" toggle
    $('#ac-os-all').on('change', function () {
        $('.ac-os').prop('checked', $(this).is(':checked'));
    });
    $(document).on('change', '.ac-os', function () {
        if (!$(this).is(':checked')) $('#ac-os-all').prop('checked', false);
        else if ($('.ac-os:checked').length === $('.ac-os').length) $('#ac-os-all').prop('checked', true);
    });

    // Enable submit on field changes
    $('#ac-partner, #ac-title, #ac-url').on('input', acCheckReady);
});

function acCheckReady() {
    var hasOp      = $('.ac-op-chk:checked').length > 0;
    var hasPartner = !!$.trim($('#ac-partner').val());
    var hasTitle   = !!$.trim($('#ac-title').val());
    var hasUrl     = !!$.trim($('#ac-url').val());
    $('#ac-submit').prop('disabled', !(acCountryId && hasOp && hasPartner && hasTitle && hasUrl));
}

function acSubmit() {
    $('#ac-error, #ac-success, #ac-results').hide();

    var ids = [];
    $('.ac-op-chk:checked').each(function () { ids.push($(this).val()); });
    if (!ids.length) { acShowError('Please select at least one operator.'); return; }

    var partner   = $.trim($('#ac-partner').val());
    var title     = $.trim($('#ac-title').val());
    var url       = $.trim($('#ac-url').val());
    var price     = parseFloat($('#ac-price').val()) || 10;
    var weightage = parseFloat($('#ac-weightage').val()) || 1;
    var live      = $('#ac-live').val();

    var browsers = [];
    $('.ac-browser:checked').each(function () { browsers.push($(this).val()); });
    var oses = [];
    $('.ac-os:checked').each(function () { oses.push($(this).val()); });

    var $btn = $('#ac-submit');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');

    // Build POST
    var data = {
        action      : 'campaign_add',
        country_id  : acCountryId,
        partner     : partner,
        title       : title,
        price       : price,
        url         : url,
        live        : live,
        weightage   : weightage
    };
    $.each(ids,      function (i, v) { data['operator_ids[' + i + ']'] = v; });
    $.each(browsers, function (i, v) { data['browser[' + i + ']'] = v; });
    $.each(oses,     function (i, v) { data['os[' + i + ']'] = v; });

    $.post('adreports/ajax.php', data)
    .done(function (r) {
        $btn.prop('disabled', false).html('<i class="fa fa-plus-circle"></i> Add Campaign');
        if (!r || !r.success) { acShowError(r && r.error ? r.error : 'Unknown error.'); return; }
        acRenderResults(r);
        if (r.inserted > 0) {
            $('#ac-success-msg').text(
                'Campaign added successfully to ' + r.inserted + ' operator(s).'
                + (r.failed > 0 ? ' ' + r.failed + ' failed.' : '')
            );
            $('#ac-success').show();
        }
    })
    .fail(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-plus-circle"></i> Add Campaign');
        acShowError('Request failed. Please try again.');
    });
}

function acRenderResults(r) {
    var html = '<table class="table table-bordered" style="font-size:13px;margin-bottom:0;">'
             + '<thead><tr style="background:#4a5568;color:#fff;">'
             + '<th style="padding:8px;">Operator</th>'
             + '<th style="padding:8px;text-align:center;">Campaign ID</th>'
             + '<th style="padding:8px;text-align:center;">Status</th>'
             + '</tr></thead><tbody>';

    $.each(r.results, function (i, row) {
        var badge = row.status === 'ok'
            ? '<span style="padding:3px 10px;border-radius:12px;background:#c6f6d5;color:#276749;font-size:12px;">OK</span>'
            : '<span style="padding:3px 10px;border-radius:12px;background:#fed7d7;color:#c53030;font-size:12px;">'
              + (row.msg || 'Error') + '</span>';
        html += '<tr>'
              + '<td style="padding:6px 10px;">' + (row.operator || '?') + '</td>'
              + '<td style="text-align:center;padding:6px 10px;">' + (row.campaign_id || '—') + '</td>'
              + '<td style="text-align:center;padding:6px 10px;">' + badge + '</td>'
              + '</tr>';
    });
    html += '</tbody></table>';

    $('#ac-results-body').html(html);
    $('#ac-results').show();
}

function acShowError(msg) {
    $('#ac-error-msg').text(msg);
    $('#ac-error').show();
}
</script>
