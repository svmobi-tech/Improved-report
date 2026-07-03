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

<!-- ─── Filter / Block Card ──────────────────────────────────────────────────── -->
<div class="hp-card hp-filter-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-ban"></i> PubID wise Blocking</h4>
    </div>
    <div class="hp-card-body">

        <div class="row">

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

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Advertiser
                        <span id="pib-adv-spinner" style="display:none;margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#667eea;"></i>
                        </span>
                    </label>
                    <select id="pib-advertiser" class="form-control" disabled>
                        <option value="">-- Select Operator First --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="pib-search-btn" class="btn-submit-report" disabled>
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>

        </div>

        <!-- Block pubids textarea (shown after operator+advertiser selected) -->
        <div id="pib-block-wrap" style="display:none;margin-top:10px;padding-top:14px;border-top:1px solid #e2e8f0;">
            <label class="hp-filter-label">Block PubIDs <small style="color:#a0aec0;">(comma or newline separated)</small></label>
            <textarea id="pib-pubids" class="form-control" rows="3"
                style="font-size:13px;font-family:monospace;resize:vertical;"
                placeholder="e.g. pub123, pub456, pub789"></textarea>
            <div style="margin-top:10px;">
                <button id="pib-block-btn" class="btn-submit-report" style="background:linear-gradient(135deg,#e53e3e,#c53030);">
                    <i class="fa fa-ban"></i> Block PubIDs
                </button>
                <span id="pib-block-msg" style="margin-left:14px;font-size:12px;"></span>
            </div>
        </div>

    </div>
</div>

<!-- ─── Results ──────────────────────────────────────────────────────────────── -->
<div id="pib-results" style="margin-top:16px;">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-ban" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select an operator and advertiser to view blocked PubIDs.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<style>
.pib-chk { cursor:pointer; width:16px; height:16px; }
.pib-chk:disabled { opacity:.5; cursor:not-allowed; }
</style>

<script>
$(document).ready(function () {

    var currentOperator  = '';
    var currentAdvertiser = '';

    // ── Load operators ────────────────────────────────────────────────────────
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

    // ── Operator change → load advertisers ───────────────────────────────────
    $('#pib-operator').on('change', function () {
        currentOperator   = $(this).val();
        currentAdvertiser = '';
        $('#pib-search-btn').prop('disabled', true);
        $('#pib-block-wrap').hide();
        resetResults();

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
                $('#pib-search-btn').prop('disabled', false);
                $('#pib-block-wrap').show();
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
        $('#pib-search-btn').prop('disabled', !currentAdvertiser);
        resetResults();
    });

    function resetResults() {
        $('#pib-results').html(
            '<div style="padding:60px;text-align:center;color:#a0aec0;">'
          + '<i class="fa fa-ban" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>'
          + 'Select an operator and advertiser to view blocked PubIDs.</div>'
        );
    }

    // ── Search ────────────────────────────────────────────────────────────────
    $('#pib-search-btn').on('click', doSearch);

    function doSearch() {
        currentOperator   = $('#pib-operator').val();
        currentAdvertiser = $('#pib-advertiser').val();
        if (!currentOperator || !currentAdvertiser) { alert('Please select operator and advertiser.'); return; }

        var $btn = $('#pib-search-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $('#pib-results').html(
            '<div style="padding:60px;text-align:center">'
          + '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;'
          + 'animation:hp-spin 0.9s linear infinite"></i>'
          + '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading records...</p></div>'
        );

        $.post('adreports/ajax.php', {
            action        : 'pubid_blocking_load',
            operator      : currentOperator,
            advertiser_id : currentAdvertiser
        }, function (r) {
            if (r.success) {
                $('#pib-results').html(r.html);
                bindEvents();
            } else {
                $('#pib-results').html(
                    '<div style="padding:30px;text-align:center;color:#e53e3e;">'
                  + '<i class="fa fa-exclamation-circle" style="font-size:28px;display:block;margin-bottom:8px;"></i>'
                  + (r.error || 'Failed to load.') + '</div>'
                );
            }
        }, 'json')
        .fail(function () {
            $('#pib-results').html('<div style="padding:30px;text-align:center;color:#e53e3e;">Request failed.</div>');
        })
        .always(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    }

    // ── Block PubIDs ──────────────────────────────────────────────────────────
    $('#pib-block-btn').on('click', function () {
        var raw = $('#pib-pubids').val().trim();
        if (!raw) { $('#pib-block-msg').css('color','#c53030').text('Please enter at least one PubID.'); return; }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Blocking...');
        $('#pib-block-msg').text('');

        $.post('adreports/ajax.php', {
            action        : 'pubid_blocking_submit',
            operator      : currentOperator,
            advertiser_id : currentAdvertiser,
            pubids        : raw
        }, function (r) {
            $btn.prop('disabled', false).html('<i class="fa fa-ban"></i> Block PubIDs');
            if (r.success) {
                $('#pib-block-msg').css('color','#276749').text(r.msg || 'Done.');
                $('#pib-pubids').val('');
                doSearch();
            } else {
                $('#pib-block-msg').css('color','#c53030').text(r.error || 'Failed.');
            }
        }, 'json').fail(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-ban"></i> Block PubIDs');
            $('#pib-block-msg').css('color','#c53030').text('Request failed.');
        });
    });

    // ── Bind events after table renders ──────────────────────────────────────
    function bindEvents() {

        // Total Block toggle
        $(document).off('change.pib').on('change.pib', '.pib-chk', function () {
            var $chk   = $(this);
            var id     = $chk.data('id');
            var toggle = $chk.prop('checked') ? 'unblock' : 'block';
            $chk.prop('disabled', true);
            $.post('adreports/ajax.php', {
                action         : 'pubid_blocking_toggle',
                operator       : currentOperator,
                pub_blocking_id: id,
                toggle         : toggle
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

});
</script>
