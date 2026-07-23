<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Contest Charging Report';
$pageIcon  = 'fa-credit-card';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-credit-card"></i> Contest Charging Report</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>Country</label>
                    <select id="cc-country" class="form-control">
                        <option value="qa">QA</option>
                        <option value="bh">BH</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>Start Date</label>
                    <input id="cc-start" type="text"
                           class="date-picker form-control birthday"
                           value="<?php echo date('d-m-Y'); ?>"
                           placeholder="dd-mm-yyyy" readonly>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>End Date</label>
                    <input id="cc-end" type="text"
                           class="date-picker form-control birthday"
                           value="<?php echo date('d-m-Y'); ?>"
                           placeholder="dd-mm-yyyy" readonly>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button id="cc-btn" class="btn btn-primary btn-block">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cc-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-credit-card" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select a country and date range, then click Search.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    function loadChargingData() {
        var country = $('#cc-country').val();
        var start   = $('#cc-start').val();
        var end     = $('#cc-end').val();

        if (!start || !end) {
            alert('Please select both start and end dates.');
            return;
        }

        $('#cc-btn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#cc-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading data...</p></div>'
        );

        $.post('ajax/handler.php', {
            action    : 'contest_charging_data',
            country   : country,
            start_date: start,
            end_date  : end
        })
        .done(function (html) {
            $('#cc-results').html(html);

            if ($('#charging-table').length) {
                $('#charging-table').DataTable({
                    dom    : 'Bfrtip',
                    buttons: [
                        { extend: 'copy',  className: 'btn-sm' },
                        { extend: 'csv',   className: 'btn-sm' },
                        { extend: 'excel', className: 'btn-sm' },
                        { extend: 'print', className: 'btn-sm' }
                    ],
                    order  : [[0, 'asc']]
                });
            }
        })
        .fail(function () {
            $('#cc-results').html(
                '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                'Failed to load data. Please try again.</div>'
            );
        })
        .always(function () {
            $('#cc-btn').prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    }

    $('#cc-btn').on('click', loadChargingData);
});
</script>
