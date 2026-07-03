<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Campaign Wise Publisher Blocking';
$pageIcon  = 'fa-shield';

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

<!-- ─── Filter Card ──────────────────────────────────────────────────────────── -->
<div class="hp-card hp-filter-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-shield"></i> Campaign Wise Publisher Blocking</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Operator
                        <span id="pcb-op-spinner" style="display:none;margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#667eea;"></i>
                        </span>
                    </label>
                    <select id="pcb-operator" class="form-control">
                        <option value="">-- Loading... --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Campaign
                        <span id="pcb-camp-spinner" style="display:none;margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#667eea;"></i>
                        </span>
                    </label>
                    <select id="pcb-campaign" class="form-control" disabled>
                        <option value="">-- Select Operator First --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="pcb-search-btn" class="btn-submit-report" disabled>
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ─── Results ──────────────────────────────────────────────────────────────── -->
<div id="pcb-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-shield" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select an operator and campaign to manage publisher blocking.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<script>
$(document).ready(function () {

    var currentOperator  = '';
    var currentCampaign  = '';

    // ── Load operators ────────────────────────────────────────────────────────
    $('#pcb-op-spinner').show();
    $.post('adreports/ajax.php', { action: 'campaign_blocking_operators' }, function (r) {
        $('#pcb-op-spinner').hide();
        if (r.success && r.operators && r.operators.length) {
            var html = '<option value="">-- Select Operator --</option>';
            r.operators.forEach(function (o) {
                html += '<option value="' + $('<span>').text(o.operator).html() + '">'
                      + $('<span>').text(o.operator).html() + '</option>';
            });
            $('#pcb-operator').html(html);
        } else {
            $('#pcb-operator').html('<option value="">-- No operators found --</option>');
        }
    }, 'json').fail(function () {
        $('#pcb-op-spinner').hide();
        $('#pcb-operator').html('<option value="">-- Failed to load --</option>');
    });

    // ── Operator change → load campaigns ─────────────────────────────────────
    $('#pcb-operator').on('change', function () {
        currentOperator = $(this).val();
        currentCampaign = '';
        $('#pcb-search-btn').prop('disabled', true);
        resetResults();

        if (!currentOperator) {
            $('#pcb-campaign').html('<option value="">-- Select Operator First --</option>').prop('disabled', true);
            return;
        }

        $('#pcb-camp-spinner').show();
        $('#pcb-campaign').html('<option value="">Loading...</option>').prop('disabled', true);

        $.post('adreports/ajax.php', {
            action   : 'pub_camp_blocking_campaigns',
            operator : currentOperator
        }, function (r) {
            $('#pcb-camp-spinner').hide();
            if (r.success && r.campaigns && r.campaigns.length) {
                var html = '<option value="all">All</option>';
                r.campaigns.forEach(function (c) {
                    html += '<option value="' + c.campaign_id + '">'
                          + $('<span>').text(c.campaign_title).html() + '</option>';
                });
                $('#pcb-campaign').html(html).prop('disabled', false);
                currentCampaign = 'all';
                $('#pcb-search-btn').prop('disabled', false);
            } else {
                $('#pcb-campaign').html('<option value="">-- No campaigns found --</option>').prop('disabled', true);
            }
        }, 'json').fail(function () {
            $('#pcb-camp-spinner').hide();
            $('#pcb-campaign').html('<option value="">-- Failed to load --</option>').prop('disabled', true);
        });
    });

    $('#pcb-campaign').on('change', function () {
        currentCampaign = $(this).val();
        $('#pcb-search-btn').prop('disabled', !currentCampaign);
        resetResults();
    });

    function resetResults() {
        $('#pcb-results').html(
            '<div style="padding:60px;text-align:center;color:#a0aec0;">'
          + '<i class="fa fa-shield" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>'
          + 'Select an operator and campaign to manage publisher blocking.</div>'
        );
    }

    // ── Search ────────────────────────────────────────────────────────────────
    $('#pcb-search-btn').on('click', doSearch);

    function doSearch() {
        currentOperator = $('#pcb-operator').val();
        currentCampaign = $('#pcb-campaign').val();
        if (!currentOperator || !currentCampaign) { alert('Please select operator and campaign.'); return; }

        var $btn = $('#pcb-search-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $('#pcb-results').html(
            '<div style="padding:60px;text-align:center">'
          + '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;'
          + 'animation:hp-spin 0.9s linear infinite"></i>'
          + '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading publishers...</p></div>'
        );

        $.post('adreports/ajax.php', {
            action      : 'pub_camp_blocking_load',
            operator    : currentOperator,
            campaign_id : currentCampaign
        }, function (r) {
            if (r.success) {
                $('#pcb-results').html(r.html);
                bindEvents();
            } else {
                $('#pcb-results').html(
                    '<div style="padding:30px;text-align:center;color:#e53e3e;">'
                  + '<i class="fa fa-exclamation-circle" style="font-size:28px;display:block;margin-bottom:8px;"></i>'
                  + (r.error || 'Failed to load.') + '</div>'
                );
            }
        }, 'json')
        .fail(function () {
            $('#pcb-results').html('<div style="padding:30px;text-align:center;color:#e53e3e;">Request failed.</div>');
        })
        .always(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    }

    // ── Events after table renders ────────────────────────────────────────────
    function bindEvents() {

        // Block checkbox toggle
        $(document).off('change.pcb').on('change.pcb', '.pcb-block-chk', function () {
            var $chk   = $(this);
            var advId  = $chk.val();
            var action = $chk.prop('checked') ? 'check' : 'uncheck';
            $chk.prop('disabled', true);
            $.post('adreports/ajax.php', {
                action       : 'pub_camp_blocking_toggle',
                operator     : currentOperator,
                advertiser_id: advId,
                campaign_id  : currentCampaign,
                toggle       : action
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
