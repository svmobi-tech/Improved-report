<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Add Operator';
$pageIcon  = 'fa-plus-circle';

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
        <h4><i class="fa fa-plus-circle"></i> Add Operator</h4>
    </div>
    <div class="hp-card-body">

        <!-- Banners -->
        <div id="ao-success" style="display:none;margin-bottom:18px;padding:14px 18px;color:#276749;background:#f0fff4;border-left:4px solid #48bb78;border-radius:4px;">
            <i class="fa fa-check-circle"></i> <span id="ao-success-msg"></span>
        </div>
        <div id="ao-error" style="display:none;margin-bottom:18px;padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
            <i class="fa fa-exclamation-triangle"></i> <span id="ao-error-msg"></span>
        </div>

        <div class="row">

            <!-- Country -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Country <span style="color:#e53e3e;">*</span></label>
                    <select id="ao-country" class="form-control">
                        <option value="">-- Select Country --</option>
                        <?php foreach ($countries as $c): ?>
                            <option value="<?= (int)$c['country_id'] ?>"><?= htmlspecialchars($c['country_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Operator Name -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Operator Name <span style="color:#e53e3e;">*</span></label>
                    <input type="text" id="ao-name" class="form-control" placeholder="e.g. airtel_india" autocomplete="off">
                    <span id="ao-name-msg" style="font-size:11px;display:block;margin-top:4px;"></span>
                </div>
            </div>

            <!-- Operator Code -->
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Operator Code <span style="color:#e53e3e;">*</span> <small style="color:#a0aec0;">(2 chars)</small></label>
                    <input type="text" id="ao-code" class="form-control" placeholder="e.g. AI" maxlength="2" autocomplete="off" style="text-transform:uppercase;">
                    <span id="ao-code-msg" style="font-size:11px;display:block;margin-top:4px;"></span>
                </div>
            </div>

        </div>

        <div style="margin-top:6px;">
            <button id="ao-submit" class="btn-submit-report" disabled>
                <i class="fa fa-plus"></i> Add Operator
            </button>
        </div>

    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<style>
#ao-name.valid, #ao-code.valid   { border-color:#48bb78; background:#f0fff4; }
#ao-name.invalid, #ao-code.invalid { border-color:#fc8181; background:#fff5f5; }
</style>

<script>
$(document).ready(function () {

    var nameOk = false;
    var codeOk = false;
    var nameTimer, codeTimer;

    function checkReady() {
        var country = $('#ao-country').val();
        $('#ao-submit').prop('disabled', !(country && nameOk && codeOk));
    }

    $('#ao-country').on('change', checkReady);

    // ── Operator Name live check ──────────────────────────────────────────────
    $('#ao-name').on('input', function () {
        nameOk = false;
        checkReady();
        clearTimeout(nameTimer);
        var val = $(this).val().trim();
        if (!val) {
            $('#ao-name').removeClass('valid invalid');
            $('#ao-name-msg').text('');
            return;
        }
        nameTimer = setTimeout(function () {
            $.post('adreports/ajax.php', {
                action  : 'add_operator_check_name',
                op_name : val
            }, function (r) {
                if (r.available) {
                    nameOk = true;
                    $('#ao-name').removeClass('invalid').addClass('valid');
                    $('#ao-name-msg').css('color','#276749').text(r.msg);
                } else {
                    nameOk = false;
                    $('#ao-name').removeClass('valid').addClass('invalid');
                    $('#ao-name-msg').css('color','#c53030').text(r.msg);
                }
                checkReady();
            }, 'json');
        }, 400);
    });

    // ── Operator Code live check ──────────────────────────────────────────────
    $('#ao-code').on('input', function () {
        $(this).val($(this).val().toUpperCase());
        codeOk = false;
        checkReady();
        clearTimeout(codeTimer);
        var val = $(this).val().trim();
        if (!val) {
            $('#ao-code').removeClass('valid invalid');
            $('#ao-code-msg').text('');
            return;
        }
        if (val.length !== 2) {
            $('#ao-code').removeClass('valid').addClass('invalid');
            $('#ao-code-msg').css('color','#c53030').text('Must be exactly 2 characters.');
            return;
        }
        codeTimer = setTimeout(function () {
            $.post('adreports/ajax.php', {
                action  : 'add_operator_check_code',
                op_code : val
            }, function (r) {
                if (r.available) {
                    codeOk = true;
                    $('#ao-code').removeClass('invalid').addClass('valid');
                    $('#ao-code-msg').css('color','#276749').text(r.msg);
                } else {
                    codeOk = false;
                    $('#ao-code').removeClass('valid').addClass('invalid');
                    $('#ao-code-msg').css('color','#c53030').text(r.msg);
                }
                checkReady();
            }, 'json');
        }, 400);
    });

    // ── Submit ────────────────────────────────────────────────────────────────
    $('#ao-submit').on('click', function () {
        var country = $('#ao-country').val();
        var name    = $('#ao-name').val().trim();
        var code    = $('#ao-code').val().trim().toUpperCase();

        if (!country || !name || !code) { return; }

        $('#ao-success, #ao-error').hide();
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');

        $.post('adreports/ajax.php', {
            action     : 'add_operator_submit',
            country_id : country,
            op_name    : name,
            op_code    : code
        }, function (r) {
            $btn.html('<i class="fa fa-plus"></i> Add Operator');
            if (r.success) {
                $('#ao-success-msg').text('Operator "' + name + '" added successfully!');
                $('#ao-success').show();
                // Reset form
                $('#ao-country').val('');
                $('#ao-name').val('').removeClass('valid invalid');
                $('#ao-code').val('').removeClass('valid invalid');
                $('#ao-name-msg, #ao-code-msg').text('');
                nameOk = false; codeOk = false;
                $btn.prop('disabled', true);
            } else {
                $('#ao-error-msg').text(r.error || 'Failed to add operator.');
                $('#ao-error').show();
                $btn.prop('disabled', false);
            }
        }, 'json').fail(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-plus"></i> Add Operator');
            $('#ao-error-msg').text('Request failed. Please try again.');
            $('#ao-error').show();
        });
    });

});
</script>
