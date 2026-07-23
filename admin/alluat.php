<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'All UAT';
$pageIcon  = 'fa-list-alt';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-list-alt"></i> UAT Comparison</h4>
    </div>
    <div class="hp-card-body">
        <form id="alluat-form">
            <div class="row">

                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Country</label>
                        <select name="country" id="alluat-country" class="form-control" disabled>
                            <option value="">-- Loading... --</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">&nbsp;</label>
                        <button type="submit" id="alluat-submit-btn" class="btn btn-primary btn-block" disabled>
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<div id="alluat-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-list-alt" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select a country to view UAT comparison across operators.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    // ── Load country dropdown via AJAX on page open ───────────────────────────
    $.get('ajax/handler.php', { action: 'uat_countries' }, function (countries) {
        var opts = '<option value="">-- Select Country --</option>';
        countries.forEach(function (c) {
            opts += '<option value="' + c + '">' + c + '</option>';
        });
        $('#alluat-country').html(opts).prop('disabled', false);
        $('#alluat-submit-btn').prop('disabled', false);
    }, 'json')
    .fail(function () {
        $('#alluat-country').html('<option value="">-- Failed to load --</option>');
    });

    // ── Form submit → load UAT pivot table ───────────────────────────────────
    $('#alluat-form').on('submit', function (e) {
        e.preventDefault();

        var country = $('#alluat-country').val();
        if (!country) {
            alert('Please select a Country.');
            return;
        }

        var $btn = $('#alluat-submit-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#alluat-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading UAT comparison...</p></div>'
        );

        $.post('ajax/handler.php', {
            action  : 'uat_load',
            country : country
        })
        .done(function (html) {
            $('#alluat-results').html(html);
        })
        .fail(function () {
            $('#alluat-results').html(
                '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                'Request failed. Please try again.</div>'
            );
        })
        .always(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    });

});
</script>
