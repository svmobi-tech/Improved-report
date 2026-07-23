<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'New Configuration';
$pageIcon  = 'fa-cog';

include("includes/check_session.php");

$conn = null;
ob_start();
try { require_once __DIR__ . '/includes/config.php'; } catch (Throwable $e) {}
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
ob_end_clean();

// Load countries for dropdown
$countries = [];
if ($conn) {
    $res = $conn->query("SELECT country_id, country_name FROM commondb.country_tbl ORDER BY country_name ASC");
    if ($res) $countries = $res->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-cog"></i> New Configuration</h4>
    </div>
    <div class="hp-card-body">

        <!-- Banners -->
        <div id="nc-success" style="display:none;margin-bottom:18px;padding:14px 18px;color:#276749;background:#f0fff4;border-left:4px solid #48bb78;border-radius:4px;">
            <i class="fa fa-check-circle"></i> <span id="nc-success-msg"></span>
        </div>
        <div id="nc-error" style="display:none;margin-bottom:18px;padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
            <i class="fa fa-exclamation-triangle"></i> <span id="nc-error-msg"></span>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-5 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Country <span style="color:#e53e3e;">*</span></label>
                    <select id="nc-country" class="form-control">
                        <option value="">-- Select Country --</option>
                        <?php foreach ($countries as $c): ?>
                            <option value="<?= (int)$c['country_id'] ?>"><?= htmlspecialchars($c['country_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Operator checkboxes (cascade) -->
        <div id="nc-op-wrap" style="display:none;margin-bottom:20px;padding:14px 16px;background:#f7fafc;border:1px solid #e2e8f0;border-radius:6px;">
            <label class="hp-filter-label" style="display:block;margin-bottom:10px;">
                Operator <span style="color:#e53e3e;">*</span>
                <label style="font-weight:400;margin-left:16px;cursor:pointer;">
                    <input type="checkbox" id="nc-op-all"> <span style="font-size:12px;color:#4a5568;">Select All</span>
                </label>
            </label>
            <div id="nc-op-list" style="display:flex;flex-wrap:wrap;gap:6px 18px;"></div>
        </div>

        <div id="nc-op-spinner" style="display:none;margin-bottom:16px;color:#667eea;">
            <i class="fa fa-spinner fa-spin"></i> Loading operators...
        </div>

        <button id="nc-submit" class="btn-submit-report" disabled>
            <i class="fa fa-database"></i> Create Configuration
        </button>

        <div style="margin-top:10px;font-size:12px;color:#a0aec0;">
            <i class="fa fa-info-circle"></i>
            Creates operator database with all required tables. Safe to re-run — uses <code>IF NOT EXISTS</code>.
        </div>

    </div>
</div>

<!-- ── Results ─────────────────────────────────────────────────────────────── -->
<div id="nc-results" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-list-alt"></i> Configuration Results</h4>
        </div>
        <div id="nc-results-body" class="hp-card-body"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    // ── Country change → load operators ──────────────────────────────────────
    $('#nc-country').on('change', function () {
        var countryId = $(this).val();
        $('#nc-submit').prop('disabled', true);
        $('#nc-op-wrap').hide();
        $('#nc-op-list').html('');
        $('#nc-op-all').prop('checked', false);
        $('#nc-results').hide();
        ncHideBanners();

        if (!countryId) { $('#nc-op-spinner').hide(); return; }

        $('#nc-op-spinner').show();
        $.post('adreports/ajax.php', {
            action     : 'new_config_operators',
            country_id : countryId
        }, function (r) {
            $('#nc-op-spinner').hide();
            if (r.success && r.operators && r.operators.length) {
                var html = '';
                r.operators.forEach(function (o) {
                    html += '<label style="cursor:pointer;font-size:12px;white-space:nowrap;color:#2d3748;">'
                          + '<input type="checkbox" class="nc-op-chk" value="'
                          + $('<span>').text(o.operator).html() + '"> '
                          + $('<span>').text(o.operator).html()
                          + '</label>';
                });
                $('#nc-op-list').html(html);
                $('#nc-op-wrap').show();
                ncCheckReady();
            } else {
                ncShowError('No operators found for the selected country.');
            }
        }, 'json').fail(function () {
            $('#nc-op-spinner').hide();
            ncShowError('Failed to load operators.');
        });
    });

    // Select All
    $('#nc-op-all').on('change', function () {
        $('.nc-op-chk').prop('checked', $(this).is(':checked'));
        ncCheckReady();
    });
    $(document).on('change', '.nc-op-chk', function () {
        if (!$(this).is(':checked')) $('#nc-op-all').prop('checked', false);
        else if ($('.nc-op-chk:checked').length === $('.nc-op-chk').length) $('#nc-op-all').prop('checked', true);
        ncCheckReady();
    });

    function ncCheckReady() {
        $('#nc-submit').prop('disabled', $('.nc-op-chk:checked').length === 0);
    }

    // ── Submit ────────────────────────────────────────────────────────────────
    $('#nc-submit').on('click', function () {
        var ops = [];
        $('.nc-op-chk:checked').each(function () { ops.push($(this).val()); });
        if (!ops.length) { ncShowError('Please select at least one operator.'); return; }

        ncHideBanners();
        $('#nc-results').hide();

        if (!confirm('Create/update configuration for ' + ops.length + ' operator(s)?\n\n' + ops.join(', '))) return;

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Creating...');

        var data = { action: 'new_config_create' };
        $.each(ops, function (i, v) { data['operators[' + i + ']'] = v; });

        $.post('adreports/ajax.php', data, function (r) {
            $btn.prop('disabled', false).html('<i class="fa fa-database"></i> Create Configuration');
            if (!r || !r.success) { ncShowError(r && r.error ? r.error : 'Unknown error.'); return; }
            ncRenderResults(r);
            var ok  = r.results.filter(function (x) { return x.status === 'ok'; }).length;
            var err = r.results.length - ok;
            $('#nc-success-msg').text('Done: ' + ok + ' operator(s) configured.' + (err > 0 ? ' ' + err + ' failed.' : ''));
            $('#nc-success').show();
        }, 'json').fail(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-database"></i> Create Configuration');
            ncShowError('Request failed. Please try again.');
        });
    });

    function ncRenderResults(r) {
        var html = '<table class="table table-bordered" style="font-size:13px;margin-bottom:0;">'
                 + '<thead><tr style="background:#4a5568;color:#fff;">'
                 + '<th style="padding:8px 12px;">Operator</th>'
                 + '<th style="padding:8px 12px;">Database</th>'
                 + '<th style="padding:8px 12px;text-align:center;">Tables</th>'
                 + '<th style="padding:8px 12px;text-align:center;">Status</th>'
                 + '</tr></thead><tbody>';
        r.results.forEach(function (row) {
            var badge = row.status === 'ok'
                ? '<span style="padding:3px 10px;border-radius:12px;background:#c6f6d5;color:#276749;font-size:12px;">OK</span>'
                : '<span style="padding:3px 10px;border-radius:12px;background:#fed7d7;color:#c53030;font-size:12px;">'
                  + (row.msg || 'Error') + '</span>';
            html += '<tr>'
                  + '<td style="padding:7px 12px;">' + row.operator + '</td>'
                  + '<td style="padding:7px 12px;font-family:monospace;font-size:12px;">' + (row.logdb || '—') + '</td>'
                  + '<td style="text-align:center;padding:7px 12px;">' + (row.tables || '—') + '</td>'
                  + '<td style="text-align:center;padding:7px 12px;">' + badge + '</td>'
                  + '</tr>';
        });
        html += '</tbody></table>';
        $('#nc-results-body').html(html);
        $('#nc-results').show();
    }

    function ncShowError(msg) {
        $('#nc-error-msg').text(msg);
        $('#nc-error').show();
    }
    function ncHideBanners() {
        $('#nc-error, #nc-success').hide();
    }
});
</script>
