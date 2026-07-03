<?php
date_default_timezone_set("Asia/Calcutta");

$pageTitle = 'Operator Blocking';
$pageIcon  = 'fa-toggle-on';

include("includes/check_session.php");

$conn = null;
ob_start();
try {
    include(dirname(dirname(__DIR__)) . '/adnetwork_admin/includes/connection.php');
} catch (Exception $e) {}
ob_end_clean();

// Load all operators from commondb
$operators = [];
if ($conn) {
    $res = $conn->query("SELECT operator_id, operator, isactive FROM commondb.operator_tbl ORDER BY operator ASC");
    if ($res) $operators = $res->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-toggle-on"></i> Operator Blocking</h4>
        <div style="float:right;font-size:12px;color:#a0aec0;margin-top:2px;">
            <i class="fa fa-info-circle"></i> Checked = Active &nbsp;|&nbsp; Unchecked = Blocked
        </div>
    </div>
    <div class="hp-card-body">

        <?php if (empty($operators)): ?>
        <div style="padding:40px;text-align:center;color:#a0aec0;">
            <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px;"></i>
            No operators found or database connection failed.
        </div>
        <?php else: ?>

        <!-- Saving indicator -->
        <div id="ob-saving" style="display:none;margin-bottom:14px;padding:10px 14px;background:#ebf4ff;border-left:4px solid #667eea;border-radius:4px;font-size:13px;color:#434190;">
            <i class="fa fa-spinner fa-spin"></i> <span id="ob-saving-msg">Saving...</span>
        </div>
        <div id="ob-saved" style="display:none;margin-bottom:14px;padding:10px 14px;background:#f0fff4;border-left:4px solid #48bb78;border-radius:4px;font-size:13px;color:#276749;">
            <i class="fa fa-check-circle"></i> <span id="ob-saved-msg">Saved.</span>
        </div>
        <div id="ob-err" style="display:none;margin-bottom:14px;padding:10px 14px;background:#fff5f5;border-left:4px solid #fc8181;border-radius:4px;font-size:13px;color:#c53030;">
            <i class="fa fa-exclamation-triangle"></i> <span id="ob-err-msg"></span>
        </div>

        <div style="display:flex;flex-wrap:wrap;gap:10px 0;">
            <?php foreach ($operators as $op): ?>
            <div style="flex:0 0 25%;min-width:160px;padding:4px 0;">
                <label style="cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;color:#2d3748;user-select:none;">
                    <input type="checkbox"
                           class="ob-chk"
                           value="<?= (int)$op['operator_id'] ?>"
                           data-name="<?= htmlspecialchars($op['operator']) ?>"
                           <?= ($op['isactive'] == 1) ? 'checked' : '' ?>
                           style="width:15px;height:15px;cursor:pointer;">
                    <?= htmlspecialchars($op['operator']) ?>
                </label>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>

    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    var saveTimer;

    $(document).on('change', '.ob-chk', function () {
        var $chk   = $(this);
        var id     = $chk.val();
        var name   = $chk.data('name');
        var toggle = $chk.prop('checked') ? 'check' : 'uncheck';

        $chk.prop('disabled', true);
        clearTimeout(saveTimer);
        $('#ob-saved, #ob-err').hide();
        $('#ob-saving-msg').text('Saving "' + name + '"...');
        $('#ob-saving').show();

        $.post('adreports/ajax.php', {
            action      : 'operator_blocking_toggle',
            operator_id : id,
            toggle      : toggle
        }, function (r) {
            $chk.prop('disabled', false);
            $('#ob-saving').hide();
            if (r.success) {
                $('#ob-saved-msg').text('"' + name + '" ' + (toggle === 'check' ? 'activated' : 'blocked') + '.');
                $('#ob-saved').show();
                saveTimer = setTimeout(function () { $('#ob-saved').fadeOut(400); }, 2000);
            } else {
                $chk.prop('checked', !$chk.prop('checked'));
                $('#ob-err-msg').text('Failed to update "' + name + '": ' + (r.error || 'unknown error'));
                $('#ob-err').show();
            }
        }, 'json').fail(function () {
            $chk.prop('disabled', false);
            $chk.prop('checked', !$chk.prop('checked'));
            $('#ob-saving').hide();
            $('#ob-err-msg').text('Request failed. Please try again.');
            $('#ob-err').show();
        });
    });

});
</script>
