<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Counter Reset';
$pageIcon  = 'fa-refresh';

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

$operators = [];
if ($conn) {
    $res = $conn->query(
        "SELECT operator_id, operator
         FROM commondb.operator_tbl
         ORDER BY operator ASC"
    );
    if ($res) $operators = $res->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card" style="max-width:500px;">
    <div class="hp-card-header">
        <h4><i class="fa fa-refresh"></i> Counter Reset</h4>
    </div>
    <div class="hp-card-body">

        <!-- Success banner -->
        <div id="cr-success" style="display:none;margin-bottom:18px;padding:14px 18px;color:#276749;background:#f0fff4;border-left:4px solid #48bb78;border-radius:4px;">
            <i class="fa fa-check-circle"></i> <span id="cr-success-msg"></span>
        </div>

        <!-- Error banner -->
        <div id="cr-error" style="display:none;margin-bottom:18px;padding:14px 18px;color:#c53030;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;">
            <i class="fa fa-exclamation-triangle"></i> <span id="cr-error-msg"></span>
        </div>

        <div class="form-group">
            <label class="hp-filter-label">Operator</label>
            <select id="cr-operator" class="form-control">
                <option value="">-- Select Operator --</option>
                <?php foreach ($operators as $op): ?>
                    <option value="<?= (int)$op['operator_id'] ?>"><?= htmlspecialchars($op['operator']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-top:20px;">
            <button id="cr-btn" class="btn btn-danger" onclick="crReset()" disabled>
                <i class="fa fa-refresh"></i> Reset Counter
            </button>
        </div>

        <div style="margin-top:16px;padding:12px 14px;background:#fffbeb;border-left:4px solid #f6ad55;border-radius:4px;font-size:12px;color:#744210;">
            <i class="fa fa-warning"></i>
            <strong>Warning:</strong> This will set <code>counter_no = 0</code> for all rows in the selected operator's <code>counter_tbl</code>. This action cannot be undone.
        </div>

    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$('#cr-operator').on('change', function () {
    $('#cr-btn').prop('disabled', !$(this).val());
    $('#cr-success, #cr-error').hide();
});

function crReset() {
    var opId   = $('#cr-operator').val();
    var opName = $('#cr-operator option:selected').text();
    if (!opId) return;

    if (!confirm('Reset counter for "' + opName + '"?\n\nThis sets counter_no = 0 for all rows in counter_tbl. This cannot be undone.')) return;

    var $btn = $('#cr-btn');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Resetting...');
    $('#cr-success, #cr-error').hide();

    $.post('adreports/ajax.php', { action: 'counter_reset', operator_id: opId })
    .done(function (r) {
        if (r && r.success) {
            $('#cr-success-msg').text('Counter reset successfully for "' + r.operator + '". (' + r.affected + ' row(s) updated)');
            $('#cr-success').show();
            $('#cr-operator').val('');
        } else {
            $('#cr-error-msg').text(r && r.error ? r.error : 'Unknown error.');
            $('#cr-error').show();
        }
    })
    .fail(function () {
        $('#cr-error-msg').text('Request failed. Please try again.');
        $('#cr-error').show();
    })
    .always(function () {
        $btn.prop('disabled', true).html('<i class="fa fa-refresh"></i> Reset Counter');
    });
}
</script>
