<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Contest Leaderboard';
$pageIcon  = 'fa-trophy';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-trophy"></i> Contest Leaderboard</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>Country</label>
                    <select id="ct-country" class="form-control">
                        <option value="qa">QA</option>
                        <option value="bh">BH</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>Group Wise</label>
                    <select id="ct-group" class="form-control">
                        <option value="day">Day</option>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>MSISDN <small style="color:#a0aec0;font-weight:400;">(optional)</small></label>
                    <input id="ct-msisdn" type="text" class="form-control" placeholder="e.g. 97430285999">
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button id="ct-btn" class="btn btn-primary btn-block">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="ct-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-trophy" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select a country and group, then click Search.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    function loadContestData() {
        var country = $('#ct-country').val();
        var group   = $('#ct-group').val();
        var msisdn  = $('#ct-msisdn').val().trim();

        $('#ct-btn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#ct-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading data...</p></div>'
        );

        $.post('ajax/handler.php', {
            action : 'contest_data',
            country: country,
            group  : group,
            msisdn : msisdn
        })
        .done(function (html) {
            $('#ct-results').html(html);

            if ($('#contest-table').length) {
                $('#contest-table').DataTable({
                    dom    : 'Bfrtip',
                    buttons: [
                        { extend: 'copy',  className: 'btn-sm' },
                        { extend: 'csv',   className: 'btn-sm' },
                        { extend: 'excel', className: 'btn-sm' },
                        { extend: 'print', className: 'btn-sm' }
                    ],
                    order  : []
                });
            }
        })
        .fail(function () {
            $('#ct-results').html(
                '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                'Failed to load data. Please try again.</div>'
            );
        })
        .always(function () {
            $('#ct-btn').prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    }

    $('#ct-btn').on('click', loadContestData);

    $('#ct-msisdn').on('keydown', function (e) {
        if (e.key === 'Enter') loadContestData();
    });
});
</script>
