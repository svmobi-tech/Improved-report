<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Engagement Activity';
$pageIcon  = 'fa-comments';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-comments"></i> Engagement Activity</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>Country</label>
                    <select id="en-country" class="form-control">
                        <option value="qa">QA</option>
                        <option value="bh">BH</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>Start Date</label>
                    <input id="en-start" type="text"
                           class="date-picker form-control birthday"
                           value="<?php echo date('d-m-Y'); ?>"
                           placeholder="dd-mm-yyyy" readonly>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>End Date</label>
                    <input id="en-end" type="text"
                           class="date-picker form-control birthday"
                           value="<?php echo date('d-m-Y'); ?>"
                           placeholder="dd-mm-yyyy" readonly>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button id="en-btn" class="btn btn-primary btn-block">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="en-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-comments" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select a country and date range, then click Search.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    function loadEngagementData() {
        var country = $('#en-country').val();
        var start   = $('#en-start').val();
        var end     = $('#en-end').val();

        if (!start || !end) {
            alert('Please select both start and end dates.');
            return;
        }

        $('#en-btn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#en-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading data...</p></div>'
        );

        $.post('ajax/handler.php', {
            action    : 'engagement_data',
            country   : country,
            start_date: start,
            end_date  : end
        })
        .done(function (html) {
            $('#en-results').html(html);

            if ($('#engage-table').length) {
                $('#engage-table').DataTable({
                    dom    : 'Bfrtip',
                    buttons: [
                        { extend: 'copy',  className: 'btn-sm' },
                        { extend: 'csv',   className: 'btn-sm' },
                        { extend: 'excel', className: 'btn-sm' },
                        {
                            extend     : 'pdfHtml5',
                            className  : 'btn-sm',
                            title      : 'Engagement Activity | SVMobi',
                            orientation: 'portrait',
                            pageSize   : 'A4',
                            customize  : function (doc) {
                                doc.pageMargins = [30, 40, 30, 30];
                                doc.defaultStyle.fontSize        = 10;
                                doc.defaultStyle.alignment       = 'center';
                                doc.styles.tableHeader.fontSize  = 10;
                                doc.styles.tableHeader.alignment = 'center';
                                doc.styles.tableBodyOdd.fontSize  = 10;
                                doc.styles.tableBodyEven.fontSize = 10;
                                doc.content.forEach(function (node) {
                                    if (node.table) {
                                        var cols = node.table.body[0].length;
                                        node.table.widths = Array(cols).fill('*');
                                        node.table.body.forEach(function (row) {
                                            row.forEach(function (cell) {
                                                if (typeof cell === 'object') {
                                                    cell.alignment = 'center';
                                                }
                                            });
                                        });
                                    }
                                });
                            }
                        },
                        { extend: 'print', className: 'btn-sm' }
                    ],
                    order  : [[0, 'asc']]
                });
            }
        })
        .fail(function () {
            $('#en-results').html(
                '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                'Failed to load data. Please try again.</div>'
            );
        })
        .always(function () {
            $('#en-btn').prop('disabled', false).html('<i class="fa fa-search"></i> Search');
        });
    }

    $('#en-btn').on('click', loadEngagementData);
});
</script>
