<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Publisher Blocking';
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
        <h4><i class="fa fa-ban"></i> Publisher Blocking</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Operator
                        <span id="pb-op-spinner" style="display:none;margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#667eea;"></i>
                        </span>
                    </label>
                    <select id="pb-operator" class="form-control">
                        <option value="">-- Loading... --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="pb-search-btn" class="btn-submit-report" disabled>
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ─── Results ──────────────────────────────────────────────────────────────── -->
<div id="pb-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-ban" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select an operator to view and manage publisher blocking.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<style>
.pb-inline-input {
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 3px 7px;
    font-size: 12px;
    box-sizing: border-box;
    transition: border-color .15s, background .15s;
}
.pb-inline-input:focus   { outline: none; background: #fff; border-color: #667eea; }
.pb-inline-input.saving  { border-color: #ed8936; background: #fffaf0; }
.pb-inline-input.saved   { border-color: #48bb78; background: #f0fff4; }
.pb-url-input { width: 240px; }
.pb-num-input { width: 70px; text-align: center; }
</style>

<script>
$(document).ready(function () {

    var currentOperator = '';

    // ── Load operators ────────────────────────────────────────────────────────
    $('#pb-op-spinner').show();
    $.post('adreports/ajax.php', { action: 'campaign_blocking_operators' }, function (r) {
        $('#pb-op-spinner').hide();
        if (r.success && r.operators && r.operators.length) {
            var html = '<option value="">-- Select Operator --</option>';
            r.operators.forEach(function (o) {
                html += '<option value="' + $('<span>').text(o.operator).html() + '">'
                      + $('<span>').text(o.operator).html() + '</option>';
            });
            $('#pb-operator').html(html);
        } else {
            $('#pb-operator').html('<option value="">-- No operators found --</option>');
        }
    }, 'json').fail(function () {
        $('#pb-op-spinner').hide();
        $('#pb-operator').html('<option value="">-- Failed to load --</option>');
    });

    $('#pb-operator').on('change', function () {
        currentOperator = $(this).val();
        $('#pb-search-btn').prop('disabled', !currentOperator);
        resetResults();
    });

    function resetResults() {
        $('#pb-results').html(
            '<div style="padding:60px;text-align:center;color:#a0aec0;">'
          + '<i class="fa fa-ban" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>'
          + 'Select an operator to view and manage publisher blocking.</div>'
        );
    }

    // ── Search ────────────────────────────────────────────────────────────────
    $('#pb-search-btn').on('click', function () {
        currentOperator = $('#pb-operator').val();
        if (!currentOperator) { alert('Please select an operator.'); return; }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $('#pb-results').html(
            '<div style="padding:60px;text-align:center">'
          + '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;'
          + 'animation:hp-spin 0.9s linear infinite"></i>'
          + '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading publishers...</p></div>'
        );

        $.post('adreports/ajax.php', {
            action   : 'pub_blocking_load',
            operator : currentOperator
        }, function (r) {
            if (r.success) {
                $('#pb-results').html(r.html);
                bindEvents(currentOperator);
            } else {
                $('#pb-results').html(
                    '<div style="padding:30px;text-align:center;color:#e53e3e;">'
                  + '<i class="fa fa-exclamation-circle" style="font-size:28px;display:block;margin-bottom:8px;"></i>'
                  + (r.error || 'Failed to load.') + '</div>'
                );
            }
        }, 'json')
        .fail(function () {
            $('#pb-results').html('<div style="padding:30px;text-align:center;color:#e53e3e;">Request failed.</div>');
        })
        .always(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    });

    // ── Bind events after table renders ──────────────────────────────────────
    function bindEvents(operator) {

        // Totally Stop checkbox
        $(document).off('change.pb').on('change.pb', '.pb-stop-chk', function () {
            var $chk    = $(this);
            var advId   = $chk.val();
            var toggle  = $chk.prop('checked') ? 'check' : 'uncheck';
            $chk.prop('disabled', true);
            $.post('adreports/ajax.php', {
                action       : 'pub_blocking_toggle',
                operator     : operator,
                advertiser_id: advId,
                toggle       : toggle
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

        // Inline field save on blur
        $(document).off('blur.pb').on('blur.pb', '.pb-inline-input', function () {
            var $inp    = $(this);
            var field   = $inp.data('field');
            var advId   = $inp.data('id');
            var val     = $inp.val().trim();
            $inp.addClass('saving').removeClass('saved');
            $.post('adreports/ajax.php', {
                action       : 'pub_blocking_update',
                operator     : operator,
                advertiser_id: advId,
                field        : field,
                value        : val
            }, function (r) {
                $inp.removeClass('saving');
                if (r.success) {
                    $inp.addClass('saved');
                    setTimeout(function () { $inp.removeClass('saved'); }, 1500);
                } else {
                    alert('Save failed: ' + (r.error || 'unknown'));
                }
            }, 'json').fail(function () {
                $inp.removeClass('saving');
                alert('Request failed.');
            });
        });
    }

});
</script>
