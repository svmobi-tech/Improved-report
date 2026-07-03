<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Campaign Blocking';
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

<!-- ─── Filter Card ──────────────────────────────────────────────────────────── -->
<div class="hp-card hp-filter-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-ban"></i> Campaign Blocking</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Operator
                        <span id="cb-op-spinner" style="display:none;margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#667eea;"></i>
                        </span>
                    </label>
                    <select id="cb-operator" class="form-control">
                        <option value="">-- Loading... --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Browser</label>
                    <select id="cb-browser" class="form-control">
                        <option value="all">All</option>
                        <option value="chrome">Chrome</option>
                        <option value="opera">Opera</option>
                        <option value="ucb">UC Browser</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">OS</label>
                    <select id="cb-os" class="form-control">
                        <option value="all">All</option>
                        <option value="android">Android</option>
                        <option value="iphone">iPhone</option>
                        <option value="windows">Windows</option>
                        <option value="linux">Linux</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="cb-search-btn" class="btn-submit-report" disabled>
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ─── Results ──────────────────────────────────────────────────────────────── -->
<div id="cb-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-ban" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select an operator to view and manage campaign blocking.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<style>
.cb-inline-input {
    background:#f7fafc; border:1px solid #e2e8f0; border-radius:4px;
    padding:4px 8px; font-size:13px; width:100%; box-sizing:border-box;
    transition:border-color .15s, background .15s;
}
.cb-inline-input:focus   { outline:none; background:#fff; border-color:#667eea; }
.cb-inline-input[disabled] { background:#edf2f7; color:#a0aec0; cursor:not-allowed; }
.cb-inline-input.saving  { border-color:#ed8936; background:#fffaf0; }
.cb-inline-input.saved   { border-color:#48bb78; background:#f0fff4; }
</style>

<script>
$(document).ready(function () {

    // ── Load operators on page load ───────────────────────────────────────────
    $('#cb-op-spinner').show();
    $.post('adreports/ajax.php', { action: 'campaign_blocking_operators' }, function (r) {
        $('#cb-op-spinner').hide();
        if (r.success && r.operators && r.operators.length) {
            var html = '<option value="">-- Select Operator --</option>';
            r.operators.forEach(function (o) {
                html += '<option value="' + $('<span>').text(o.operator).html() + '"'
                      + ' data-id="' + o.operator_id + '">'
                      + $('<span>').text(o.operator).html() + '</option>';
            });
            $('#cb-operator').html(html);
        } else {
            $('#cb-operator').html('<option value="">-- No operators found --</option>');
        }
    }, 'json').fail(function () {
        $('#cb-op-spinner').hide();
        $('#cb-operator').html('<option value="">-- Failed to load --</option>');
    });

    $('#cb-operator').on('change', function () {
        $('#cb-search-btn').prop('disabled', !$(this).val());
        $('#cb-results').html(
            '<div style="padding:60px;text-align:center;color:#a0aec0;">'
          + '<i class="fa fa-ban" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>'
          + 'Select an operator to view and manage campaign blocking.</div>'
        );
    });

    // ── Search ────────────────────────────────────────────────────────────────
    $('#cb-search-btn').on('click', function () {
        var opId  = $('#cb-operator').find(':selected').data('id');
        var op    = $('#cb-operator').val();
        if (!op) { alert('Please select an operator.'); return; }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $('#cb-results').html(
            '<div style="padding:60px;text-align:center">'
          + '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>'
          + '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading campaigns...</p></div>'
        );

        $.post('adreports/ajax.php', {
            action      : 'campaign_blocking_load',
            operator_id : opId,
            operator    : op,
            browser     : $('#cb-browser').val(),
            os          : $('#cb-os').val()
        }, function (r) {
            if (r.success) {
                $('#cb-results').html(r.html);
                bindTableEvents(op, opId);
            } else {
                $('#cb-results').html(
                    '<div style="padding:30px;text-align:center;color:#e53e3e;">'
                  + '<i class="fa fa-exclamation-circle" style="font-size:28px;display:block;margin-bottom:8px;"></i>'
                  + (r.error || 'Failed to load campaigns.') + '</div>'
                );
            }
        }, 'json')
        .fail(function () {
            $('#cb-results').html('<div style="padding:30px;text-align:center;color:#e53e3e;">Request failed. Please try again.</div>');
        })
        .always(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    });

    // ── Bind events after table renders ──────────────────────────────────────
    function bindTableEvents(operator, operatorId) {

        // URL edit toggle
        $('#cb-url-toggle').off('click').on('click', function () {
            var $btn  = $(this);
            var $urls = $('.url-field');
            var isOff = $urls.first().prop('disabled');
            $urls.prop('disabled', !isOff);
            $btn.toggleClass('btn-default btn-warning');
            $btn.find('i').toggleClass('fa-lock fa-unlock');
            $btn.find('span').text(isOff ? ' Disable URL Edit' : ' Enable URL Edit');
        });

        // Block checkbox
        $(document).off('change.cb').on('change.cb', '.cb-block-chk', function () {
            var $chk  = $(this);
            var cid   = $chk.val();
            var act   = $chk.prop('checked') ? 'block' : 'unblock';
            $chk.prop('disabled', true);
            $.post('adreports/ajax.php', {
                action      : 'campaign_blocking_toggle',
                operator_id : operatorId,
                operator    : operator,
                campaign_id : cid,
                toggle      : act
            }, function (r) {
                $chk.prop('disabled', false);
                if (!r.success) {
                    alert('Update failed: ' + (r.error || 'unknown error'));
                    $chk.prop('checked', !$chk.prop('checked'));
                }
            }, 'json').fail(function () {
                $chk.prop('disabled', false);
                alert('Request failed.');
                $chk.prop('checked', !$chk.prop('checked'));
            });
        });

        // Inline save
        $(document).off('blur.cb').on('blur.cb', '.cb-inline-input', function () {
            var $inp  = $(this);
            var field = $inp.data('field');
            var cid   = $inp.data('id');
            var val   = $inp.val().trim();
            $inp.addClass('saving').removeClass('saved');
            $.post('adreports/ajax.php', {
                action      : 'campaign_blocking_update',
                operator_id : operatorId,
                operator    : operator,
                campaign_id : cid,
                field       : field,
                value       : val
            }, function (r) {
                $inp.removeClass('saving');
                if (r.success) {
                    $inp.addClass('saved');
                    setTimeout(function () { $inp.removeClass('saved'); }, 1500);
                } else {
                    alert('Save failed: ' + (r.error || 'unknown error'));
                }
            }, 'json').fail(function () {
                $inp.removeClass('saving');
                alert('Request failed while saving ' + field + '.');
            });
        });
    }

});
</script>
