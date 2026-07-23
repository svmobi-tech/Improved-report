<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Campaign Capping & Automation';
$pageIcon  = 'fa-filter';

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
        <h4><i class="fa fa-filter"></i> Campaign Capping &amp; Automation</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Operator
                        <span id="cc-op-spinner" style="display:none;margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#667eea;"></i>
                        </span>
                    </label>
                    <select id="cc-operator" class="form-control">
                        <option value="">-- Loading... --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Type Setting</label>
                    <select id="cc-type" class="form-control">
                        <option value="2">Manually</option>
                        <option value="1">Percentage</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12" id="cc-auto-col" style="display:none;">
                <div class="form-group">
                    <label class="hp-filter-label">Automation</label>
                    <div style="display:flex;align-items:center;gap:10px;height:34px;">
                        <label class="cc-toggle-wrap">
                            <input type="checkbox" id="cc-auto-chk">
                            <span class="cc-toggle-slider"></span>
                        </label>
                        <span id="cc-auto-label" style="font-size:13px;color:#a0aec0;font-weight:600;">OFF</span>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="cc-search-btn" class="btn-submit-report" disabled>
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ─── Results ──────────────────────────────────────────────────────────────── -->
<div id="cc-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-filter" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select an operator to manage campaign weights and automation.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>

<style>
.cc-weight-input {
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 4px 8px;
    font-size: 13px;
    width: 90px;
    box-sizing: border-box;
    text-align: center;
    transition: border-color .15s, background .15s;
}
.cc-weight-input:focus  { outline: none; background: #fff; border-color: #667eea; }
.cc-weight-input.saving { border-color: #ed8936; background: #fffaf0; }
.cc-weight-input.saved  { border-color: #48bb78; background: #f0fff4; }

.cc-auto-bar {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 18px;
    background: #f0f4ff;
    border-bottom: 1px solid #e2e8f0;
}
.cc-toggle-wrap { position: relative; display: inline-block; width: 44px; height: 24px; }
.cc-toggle-wrap input { opacity: 0; width: 0; height: 0; }
.cc-toggle-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: #cbd5e0;
    border-radius: 24px;
    transition: .3s;
}
.cc-toggle-slider:before {
    content: "";
    position: absolute;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    left: 3px;
    top: 3px;
    background: #fff;
    transition: .3s;
}
.cc-toggle-wrap input:checked + .cc-toggle-slider { background: #667eea; }
.cc-toggle-wrap input:checked + .cc-toggle-slider:before { transform: translateX(20px); }
</style>

<script>
$(document).ready(function () {

    var currentOperator = '';

    // ── Load operators ────────────────────────────────────────────────────────
    $('#cc-op-spinner').show();
    $.post('adreports/ajax.php', { action: 'campaign_blocking_operators' }, function (r) {
        $('#cc-op-spinner').hide();
        if (r.success && r.operators && r.operators.length) {
            var html = '<option value="">-- Select Operator --</option>';
            r.operators.forEach(function (o) {
                html += '<option value="' + $('<span>').text(o.operator).html() + '">'
                      + $('<span>').text(o.operator).html() + '</option>';
            });
            $('#cc-operator').html(html);
        } else {
            $('#cc-operator').html('<option value="">-- No operators found --</option>');
        }
    }, 'json').fail(function () {
        $('#cc-op-spinner').hide();
        $('#cc-operator').html('<option value="">-- Failed to load --</option>');
    });

    // ── Automation toggle (in filter card — always bound) ─────────────────────
    $('#cc-auto-chk').on('change', function () {
        var $chk   = $(this);
        var enable = $chk.prop('checked') ? 1 : 0;
        updateAutoLabel(enable);
        if (!currentOperator) return;
        $.post('adreports/ajax.php', {
            action   : 'campaign_capping_toggle_automation',
            operator : currentOperator,
            enable   : enable
        }, function (r) {
            if (!r.success) {
                alert('Failed: ' + (r.error || 'unknown'));
                $chk.prop('checked', !$chk.prop('checked'));
                updateAutoLabel($chk.prop('checked') ? 1 : 0);
            }
        }, 'json').fail(function () {
            alert('Request failed.');
            $chk.prop('checked', !$chk.prop('checked'));
            updateAutoLabel($chk.prop('checked') ? 1 : 0);
        });
    });

    function updateAutoLabel(enable) {
        var $lbl = $('#cc-auto-label');
        if (enable) {
            $lbl.text('ON').css('color', '#667eea');
        } else {
            $lbl.text('OFF').css('color', '#a0aec0');
        }
    }

    $('#cc-operator').on('change', function () {
        currentOperator = $(this).val();
        var hasOp = !!currentOperator;
        $('#cc-search-btn').prop('disabled', !hasOp);
        resetResults();

        if (!hasOp) {
            $('#cc-auto-col').hide();
            return;
        }

        // Load automation status for selected operator
        $.post('adreports/ajax.php', {
            action   : 'campaign_capping_get_automation',
            operator : currentOperator
        }, function (r) {
            if (r.success) {
                var isOn = r.automation ? true : false;
                $('#cc-auto-chk').prop('checked', isOn);
                updateAutoLabel(isOn ? 1 : 0);
                $('#cc-auto-col').show();
            }
        }, 'json');
    });

    function resetResults() {
        $('#cc-results').html(
            '<div style="padding:60px;text-align:center;color:#a0aec0;">'
          + '<i class="fa fa-filter" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>'
          + 'Select an operator to manage campaign weights and automation.</div>'
        );
    }

    // ── Search ────────────────────────────────────────────────────────────────
    $('#cc-search-btn').on('click', function () {
        currentOperator = $('#cc-operator').val();
        var type = $('#cc-type').val();
        if (!currentOperator) { alert('Please select an operator.'); return; }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $('#cc-results').html(
            '<div style="padding:60px;text-align:center">'
          + '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;'
          + 'animation:hp-spin 0.9s linear infinite"></i>'
          + '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading...</p></div>'
        );

        $.post('adreports/ajax.php', {
            action   : 'campaign_capping_load',
            operator : currentOperator,
            type     : type
        }, function (r) {
            if (r.success) {
                $('#cc-results').html(r.html);
                bindEvents();
            } else {
                $('#cc-results').html(
                    '<div style="padding:30px;text-align:center;color:#e53e3e;">'
                  + '<i class="fa fa-exclamation-circle" style="font-size:28px;display:block;margin-bottom:8px;"></i>'
                  + (r.error || 'Failed to load.') + '</div>'
                );
            }
        }, 'json')
        .fail(function () {
            $('#cc-results').html('<div style="padding:30px;text-align:center;color:#e53e3e;">Request failed.</div>');
        })
        .always(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    });

    // ── Bind events after table renders ──────────────────────────────────────
    function bindEvents() {

        // Manual weight update (blur → save)
        $(document).off('blur.cc-w').on('blur.cc-w', '.cc-weight-input[data-cid]', function () {
            var $inp = $(this);
            var cid  = $inp.data('cid');
            var val  = $inp.val().trim();
            $inp.addClass('saving').removeClass('saved');
            $.post('adreports/ajax.php', {
                action      : 'campaign_capping_update_weight',
                operator    : currentOperator,
                campaign_id : cid,
                weight      : val
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

        // Percentage update (blur → save)
        $(document).off('blur.cc-p').on('blur.cc-p', '#cc-perc-input', function () {
            var $inp = $(this);
            var val  = $inp.val().trim();
            $inp.addClass('saving').removeClass('saved');
            $.post('adreports/ajax.php', {
                action   : 'campaign_capping_update_percentage',
                operator : currentOperator,
                value    : val
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
