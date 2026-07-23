<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Last Activity';
$pageIcon  = 'fa-clock-o';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<!-- ─── Results Area (auto-loaded via AJAX on page open) ────────────────────── -->
<div id="activity-results">
    <div style="padding:80px;text-align:center">
        <i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>
        <p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading activity data...</p>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    $.ajax({
        url    : 'ajax/handler.php',
        method : 'POST',
        data   : { action: 'last_activity_data' },
        success: function (html) {
            $('#activity-results').html(html);

            if ($('#activity-table').length) {
                $('#activity-table').DataTable({
                    dom    : 'Bfrtip',
                    buttons: [
                        { extend: 'copy',  className: 'btn-sm' },
                        { extend: 'csv',   className: 'btn-sm' },
                        { extend: 'excel', className: 'btn-sm' },
                        {
                            extend   : 'pdfHtml5',
                            className: 'btn-sm',
                            title    : 'Last Activity | SVMobi',
                            customize: function (doc) {
                                doc.pageSize = { width: 595.28, height: 841.89 };
                                doc.pageMargins     = [10, 30, 10, 15];
                                doc.defaultStyle.fontSize         = 8;
                                doc.styles.tableHeader.fontSize   = 8;
                                doc.styles.tableBodyOdd.fontSize  = 8;
                                doc.styles.tableBodyEven.fontSize = 8;
                                doc.content.forEach(function (node) {
                                    if (node.table) {
                                        var cols = node.table.body[0].length;
                                        node.table.widths = [];
                                        for (var i = 0; i < cols; i++) node.table.widths.push('*');
                                    }
                                });
                            }
                        },
                        {
                            extend   : 'print',
                            className: 'btn-sm',
                            customize: function (win) {
                                $(win.document.head).append(
                                    '<style>' +
                                    '@page { size: A4 portrait; margin: 5mm; }' +
                                    'body { margin: 0; font-size: 8pt; }' +
                                    'table { border-collapse: collapse; width: 100% !important; }' +
                                    'table th, table td { font-size: 7pt; padding: 2px 4px; }' +
                                    '</style>'
                                );
                            }
                        }
                    ],
                    ordering : false,
                    paging   : false
                });
            }
        },
        error: function () {
            $('#activity-results').html(
                '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                'Failed to load activity data. Please refresh the page.</div>'
            );
        }
    });

});
</script>
