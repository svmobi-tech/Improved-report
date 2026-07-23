<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Campaign Capping';
$pageIcon  = 'fa-sliders';

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
        <h4><i class="fa fa-sliders"></i> Campaign Capping</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Operator
                        <span id="cc2-op-spinner" style="display:none;margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#667eea;"></i>
                        </span>
                    </label>
                    <select id="cc2-operator" class="form-control">
                        <option value="">-- Loading... --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="cc2-search-btn" class="btn-submit-report" disabled>
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ─── Results ──────────────────────────────────────────────────────────────── -->
<div id="cc2-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-sliders" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select an operator to view campaign capping.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<style>
.cc2-cap-input {
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 4px 8px;
    font-size: 13px;
    width: 110px;
    box-sizing: border-box;
    text-align: center;
    transition: border-color .15s, background .15s;
}
.cc2-cap-input:focus  { outline: none; background: #fff; border-color: #667eea; }
.cc2-cap-input.saving { border-color: #ed8936; background: #fffaf0; }
.cc2-cap-input.saved  { border-color: #48bb78; background: #f0fff4; }
</style>

<script>
$(document).ready(function () {

    var currentOperator = '';

    // ── Load operators ────────────────────────────────────────────────────────
    $('#cc2-op-spinner').show();
    $.post('adreports/ajax.php', { action: 'campaign_blocking_operators' }, function (r) {
        $('#cc2-op-spinner').hide();
        if (r.success && r.operators && r.operators.length) {
            var html = '<option value="">-- Select Operator --</option>';
            r.operators.forEach(function (o) {
                html += '<option value="' + $('<span>').text(o.operator).html() + '">'
                      + $('<span>').text(o.operator).html() + '</option>';
            });
            $('#cc2-operator').html(html);
        } else {
            $('#cc2-operator').html('<option value="">-- No operators found --</option>');
        }
    }, 'json').fail(function () {
        $('#cc2-op-spinner').hide();
        $('#cc2-operator').html('<option value="">-- Failed to load --</option>');
    });

    $('#cc2-operator').on('change', function () {
        currentOperator = $(this).val();
        $('#cc2-search-btn').prop('disabled', !currentOperator);
        resetResults();
    });

    function resetResults() {
        $('#cc2-results').html(
            '<div style="padding:60px;text-align:center;color:#a0aec0;">'
          + '<i class="fa fa-sliders" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>'
          + 'Select an operator to view campaign capping.</div>'
        );
    }

    // ── Search ────────────────────────────────────────────────────────────────
    $('#cc2-search-btn').on('click', doSearch);

    function doSearch() {
        currentOperator = $('#cc2-operator').val();
        if (!currentOperator) { alert('Please select an operator.'); return; }

        var $btn = $('#cc2-search-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $('#cc2-results').html(
            '<div style="padding:60px;text-align:center">'
          + '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;'
          + 'animation:hp-spin 0.9s linear infinite"></i>'
          + '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading campaigns...</p></div>'
        );

        $.post('adreports/ajax.php', {
            action   : 'camp_capping_load',
            operator : currentOperator
        }, function (r) {
            if (r.success) {
                $('#cc2-results').html(r.html);
                bindEvents();
            } else {
                $('#cc2-results').html(
                    '<div style="padding:30px;text-align:center;color:#e53e3e;">'
                  + '<i class="fa fa-exclamation-circle" style="font-size:28px;display:block;margin-bottom:8px;"></i>'
                  + (r.error || 'Failed to load.') + '</div>'
                );
            }
        }, 'json')
        .fail(function () {
            $('#cc2-results').html('<div style="padding:30px;text-align:center;color:#e53e3e;">Request failed.</div>');
        })
        .always(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    }

    // ── Events after table renders ────────────────────────────────────────────
    function bindEvents() {

        // Select-all checkbox in header
        $(document).off('change.cc2-all').on('change.cc2-all', '#cc2-chk-all', function () {
            $('.cc2-del-chk').prop('checked', $(this).prop('checked'));
        });

        // Capping value update on blur
        $(document).off('blur.cc2').on('blur.cc2', '.cc2-cap-input', function () {
            var $inp = $(this);
            var cid  = $inp.data('cid');
            var val  = $inp.val().trim();
            $inp.addClass('saving').removeClass('saved');
            $.post('adreports/ajax.php', {
                action      : 'camp_capping_update',
                operator    : currentOperator,
                campaign_id : cid,
                capping     : val
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

        // Erase from capping
        $(document).off('click.cc2-erase').on('click.cc2-erase', '#cc2-erase-btn', function () {
            var ids = [];
            $('.cc2-del-chk:checked').each(function () { ids.push($(this).val()); });
            if (!ids.length) { alert('Please select at least one campaign to erase.'); return; }
            if (!confirm('Erase capping for ' + ids.length + ' campaign(s)? This will reset campaign_live and remove from capping_tbl.')) return;

            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Erasing...');

            $.post('adreports/ajax.php', {
                action      : 'camp_capping_erase',
                operator    : currentOperator,
                campaign_ids: ids
            }, function (r) {
                if (r.success) {
                    doSearch();
                } else {
                    alert('Erase failed: ' + (r.error || 'unknown'));
                    $btn.prop('disabled', false).html('<i class="fa fa-trash-o"></i> Erase from Capping');
                }
            }, 'json').fail(function () {
                alert('Request failed.');
                $btn.prop('disabled', false).html('<i class="fa fa-trash-o"></i> Erase from Capping');
            });
        });
    }

});
</script>
