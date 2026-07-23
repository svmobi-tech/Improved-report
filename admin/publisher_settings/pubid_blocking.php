<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'PubID wise Blocking';
$pageIcon  = 'fa-ban';

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

<!-- ─── Input Card ────────────────────────────────────────────────────────────── -->
<div class="hp-card hp-filter-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-ban"></i> PubID wise Blocking</h4>
    </div>
    <div class="hp-card-body">

        <!-- Banners -->
        <div id="pib-success" style="display:none;margin-bottom:16px;padding:12px 16px;color:#276749;background:#f0fff4;border-left:4px solid #48bb78;border-radius:4px;">
            <i class="fa fa-check-circle"></i> <span id="pib-success-msg"></span>
        </div>
        <div id="pib-error" style="display:none;margin-bottom:16px;padding:12px 16px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
            <i class="fa fa-exclamation-triangle"></i> <span id="pib-error-msg"></span>
        </div>

        <div class="row">

            <!-- Operator -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Operator
                        <span id="pib-op-spinner" style="display:none;margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#667eea;"></i>
                        </span>
                    </label>
                    <select id="pib-operator" class="form-control">
                        <option value="">-- Loading... --</option>
                    </select>
                </div>
            </div>

            <!-- Advertiser (auto-loads on operator change) -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Publisher Name
                        <span id="pib-adv-spinner" style="display:none;margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#667eea;"></i>
                        </span>
                    </label>
                    <select id="pib-advertiser" class="form-control" disabled>
                        <option value="">-- Select Operator First --</option>
                    </select>
                </div>
            </div>

        </div>

        <!-- Textarea + Submit (shown after operator+advertiser ready) -->
        <div id="pib-form-wrap" style="display:none;">
            <div class="form-group">
                <label class="hp-filter-label">PubIDs <small style="color:#a0aec0;font-weight:400;">(comma or newline separated)</small></label>
                <textarea id="pib-pubids" class="form-control" rows="4"
                    style="font-size:13px;font-family:monospace;resize:vertical;"
                    placeholder="e.g. pub123, pub456, pub789"></textarea>
            </div>
            <button id="pib-submit-btn" class="btn-submit-report">
                <i class="fa fa-check"></i> Submit
            </button>
        </div>

    </div>
</div>

<!-- ─── Output Records ───────────────────────────────────────────────────────── -->
<div id="pib-output" style="display:none;margin-top:16px;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-list-alt"></i> Output Records</h4>
        </div>
        <div id="pib-output-body" class="hp-card-body" style="padding:0;overflow-x:auto;"></div>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<style>
.pib-chk { cursor:pointer; width:15px; height:15px; }
.pib-chk:disabled { opacity:.5; cursor:not-allowed; }
</style>

<script>
$(document).ready(function () {

    var currentOperator  = '';
    var currentAdvertiser = '';

    // ── Load operators on page load ───────────────────────────────────────────
    $('#pib-op-spinner').show();
    $.post('adreports/ajax.php', { action: 'campaign_blocking_operators' }, function (r) {
        $('#pib-op-spinner').hide();
        if (r.success && r.operators && r.operators.length) {
            var html = '<option value="">-- Select Operator --</option>';
            r.operators.forEach(function (o) {
                html += '<option value="' + $('<span>').text(o.operator).html() + '">'
                      + $('<span>').text(o.operator).html() + '</option>';
            });
            $('#pib-operator').html(html);
        } else {
            $('#pib-operator').html('<option value="">-- No operators found --</option>');
        }
    }, 'json').fail(function () {
        $('#pib-op-spinner').hide();
        $('#pib-operator').html('<option value="">-- Failed to load --</option>');
    });

    // ── Operator change → auto-load advertisers ───────────────────────────────
    $('#pib-operator').on('change', function () {
        currentOperator   = $(this).val();
        currentAdvertiser = '';
        hideBanners();
        resetOutput();
        $('#pib-form-wrap').hide();

        if (!currentOperator) {
            $('#pib-advertiser').html('<option value="">-- Select Operator First --</option>').prop('disabled', true);
            return;
        }

        $('#pib-adv-spinner').show();
        $('#pib-advertiser').html('<option value="">Loading...</option>').prop('disabled', true);

        $.post('adreports/ajax.php', {
            action   : 'pubid_blocking_advertisers',
            operator : currentOperator
        }, function (r) {
            $('#pib-adv-spinner').hide();
            if (r.success && r.advertisers && r.advertisers.length) {
                var html = '<option value="all">All</option>';
                r.advertisers.forEach(function (a) {
                    html += '<option value="' + a.advertiser_id + '">'
                          + $('<span>').text(a.advertiser_name).html() + '</option>';
                });
                $('#pib-advertiser').html(html).prop('disabled', false);
                currentAdvertiser = 'all';
                $('#pib-form-wrap').show();
            } else {
                $('#pib-advertiser').html('<option value="">-- No advertisers found --</option>').prop('disabled', true);
            }
        }, 'json').fail(function () {
            $('#pib-adv-spinner').hide();
            $('#pib-advertiser').html('<option value="">-- Failed to load --</option>').prop('disabled', true);
        });
    });

    $('#pib-advertiser').on('change', function () {
        currentAdvertiser = $(this).val();
        resetOutput();
        hideBanners();
    });

    // ── Submit: save pubids THEN load output records ──────────────────────────
    $('#pib-submit-btn').on('click', function () {
        currentOperator   = $('#pib-operator').val();
        currentAdvertiser = $('#pib-advertiser').val();
        var raw = $('#pib-pubids').val().trim();

        hideBanners();

        if (!currentOperator || !currentAdvertiser) {
            showError('Please select operator and publisher.');
            return;
        }

        var $btn = $(this);

        // If textarea has pubids → block them first, then load output
        // If empty → just load output records for selected operator/advertiser
        if (raw !== '') {
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            $.post('adreports/ajax.php', {
                action        : 'pubid_blocking_submit',
                operator      : currentOperator,
                advertiser_id : currentAdvertiser,
                pubids        : raw
            }, function (r) {
                if (r.success) {
                    showSuccess(r.msg || 'PubIDs blocked successfully.');
                    $('#pib-pubids').val('');
                } else {
                    showError(r.error || 'Failed to save PubIDs.');
                }
                loadOutput();
                $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Submit');
            }, 'json').fail(function () {
                $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Submit');
                showError('Request failed. Please try again.');
            });
        } else {
            // No pubids typed — just view output
            loadOutput();
        }
    });

    // ── Load output records ───────────────────────────────────────────────────
    function loadOutput() {
        $('#pib-output').show();
        $('#pib-output-body').html(
            '<div style="padding:40px;text-align:center;">'
          + '<i class="fa fa-refresh" style="font-size:32px;color:#667eea;display:inline-block;'
          + 'animation:hp-spin 0.9s linear infinite"></i>'
          + '<p style="color:#a0aec0;margin-top:12px;font-size:13px;">Loading records...</p></div>'
        );

        $.post('adreports/ajax.php', {
            action        : 'pubid_blocking_load',
            operator      : currentOperator,
            advertiser_id : currentAdvertiser
        }, function (r) {
            if (r.success) {
                $('#pib-output-body').html(r.html);
                bindToggle();
            } else {
                $('#pib-output-body').html(
                    '<div style="padding:30px;text-align:center;color:#e53e3e;">'
                  + (r.error || 'Failed to load records.') + '</div>'
                );
            }
        }, 'json').fail(function () {
            $('#pib-output-body').html(
                '<div style="padding:30px;text-align:center;color:#e53e3e;">Request failed.</div>'
            );
        });
    }

    function resetOutput() {
        $('#pib-output').hide();
        $('#pib-output-body').html('');
    }

    // ── Checkbox toggle (Total Block) ─────────────────────────────────────────
    function bindToggle() {
        $(document).off('change.pib').on('change.pib', '.pib-chk', function () {
            var $chk   = $(this);
            var id     = $chk.data('id');
            var toggle = $chk.prop('checked') ? 'unblock' : 'block';
            $chk.prop('disabled', true);
            $.post('adreports/ajax.php', {
                action          : 'pubid_blocking_toggle',
                operator        : currentOperator,
                pub_blocking_id : id,
                toggle          : toggle
            }, function (r) {
                $chk.prop('disabled', false);
                if (!r.success) {
                    alert('Update failed: ' + (r.error || 'unknown'));
                    $chk.prop('checked', !$chk.prop('checked'));
                }
            }, 'json').fail(function () {
                $chk.prop('disabled', false);
                alert('Request failed.');
                $chk.prop('checked', !$chk.prop('checked'));
            });
        });
    }

    function showSuccess(msg) { $('#pib-success-msg').text(msg); $('#pib-success').show(); }
    function showError(msg)   { $('#pib-error-msg').text(msg);   $('#pib-error').show();   }
    function hideBanners()    { $('#pib-success, #pib-error').hide(); }
});
</script>
