<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Check Crons';
$pageIcon  = 'fa-check-circle-o';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-check-circle-o"></i> Check Crons</h4>
    </div>
    <div class="hp-card-body">
        <form id="chkact-form">
            <div class="row">

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Date</label>
                        <input type="text" name="date" id="chkact-date" class="form-control birthday"
                               value="<?php echo date('d-m-Y'); ?>">
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">&nbsp;</label>
                        <button type="submit" id="chkact-submit-btn" class="btn btn-primary btn-block">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<div id="chkact-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-check-circle-o" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select a date and click Search.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    // ── Date picker ───────────────────────────────────────────────────────────
    $('#chkact-date').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        locale           : { format: 'DD-MM-YYYY' }
    });

    // ── Form submit → load table ──────────────────────────────────────────────
    $('#chkact-form').on('submit', function (e) {
        e.preventDefault();

        var $btn = $('#chkact-submit-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#chkact-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading cron data...</p></div>'
        );

        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#chkact-table')) {
            $('#chkact-table').DataTable().destroy();
        }

        $.post('ajax/handler.php', {
            action : 'checkactivation_load',
            date   : $('#chkact-date').val()
        })
        .done(function (html) {
            $('#chkact-results').html(html);

            if ($('#chkact-table').length) {
                // exportBody: strip inline style from zero-highlighted cells so PDF gets plain numbers
                var exportBody = function (data, row, column, node) {
                    if (node) return $(node).text().trim();
                    if (typeof data === 'string') {
                        var m = data.match(/>(\d+)</);
                        return m ? m[1] : data;
                    }
                    return data;
                };
                var exportOpts = { format: { body: exportBody } };

                $('#chkact-table').DataTable({
                    dom      : 'Bfrtip',
                    buttons  : [
                        { extend: 'copy',  className: 'btn-sm', exportOptions: exportOpts },
                        { extend: 'csv',   className: 'btn-sm', exportOptions: exportOpts },
                        { extend: 'excel', className: 'btn-sm', exportOptions: exportOpts },
                        {
                            extend      : 'pdfHtml5',
                            className   : 'btn-sm',
                            title       : 'Check Crons | SVMobi',
                            orientation : 'landscape',
                            pageSize    : 'A4',
                            exportOptions: exportOpts,
                            customize   : function (doc) {
                                doc.pageMargins = [20, 35, 20, 20];
                                doc.defaultStyle.fontSize        = 9;
                                doc.defaultStyle.alignment       = 'center';
                                doc.styles.tableHeader.fontSize  = 9;
                                doc.styles.tableHeader.alignment = 'center';
                                doc.styles.tableBodyOdd.fontSize  = 9;
                                doc.styles.tableBodyEven.fontSize = 9;
                                doc.content.forEach(function (node) {
                                    if (node.table) {
                                        var cols = node.table.body[0].length;
                                        node.table.widths = Array(cols).fill('*');
                                        node.table.body.forEach(function (row) {
                                            row.forEach(function (cell) {
                                                if (typeof cell === 'object') cell.alignment = 'center';
                                            });
                                        });
                                    }
                                });
                            }
                        },
                        { extend: 'print', className: 'btn-sm', exportOptions: exportOpts }
                    ],
                    order      : [[4, 'asc'], [5, 'asc']],
                    pageLength : 50
                });
            }
        })
        .fail(function () {
            $('#chkact-results').html(
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
