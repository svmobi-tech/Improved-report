<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Currency';
$pageIcon  = 'fa-money';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-money"></i> Currency Change Portal</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button id="cur-btn" class="btn btn-primary btn-block">
                        <i class="fa fa-refresh"></i> Refresh Rates
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cur-results">
    <div style="padding:60px;text-align:center">
        <i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>
        <p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading currency rates...</p>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    function loadCurrency() {
        $('#cur-btn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#cur-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading currency rates...</p></div>'
        );

        $.post('ajax/handler.php', { action: 'currency_load' })
        .done(function (html) {
            $('#cur-results').html(html);

            if ($('#cur-table').length) {
                // exportBody: extracts input .val() for copy/csv/excel/print (DOM path)
                // and reads value="..." attr from HTML string for pdfHtml5 (regex path)
                var exportBody = function (data, row, column, node) {
                    if (node) {
                        var $inp = $(node).find('input.cur-input');
                        if ($inp.length) return $inp.val();
                    }
                    if (typeof data === 'string' && data.indexOf('cur-input') !== -1) {
                        var m = data.match(/\bvalue="([^"]*)"/);
                        return m ? m[1] : '';
                    }
                    return data;
                };
                var exportOpts = { format: { body: exportBody } };

                $('#cur-table').DataTable({
                    dom      : 'Bfrtip',
                    buttons  : [
                        { extend: 'copy',  className: 'btn-sm', exportOptions: exportOpts },
                        { extend: 'csv',   className: 'btn-sm', exportOptions: exportOpts },
                        { extend: 'excel', className: 'btn-sm', exportOptions: exportOpts },
                        {
                            extend       : 'pdfHtml5',
                            className    : 'btn-sm',
                            title        : 'Currency Rates | SVMobi',
                            orientation  : 'portrait',
                            pageSize     : 'A4',
                            exportOptions: exportOpts,
                            customize    : function (doc) {
                                doc.pageMargins = [40, 50, 40, 40];
                                doc.defaultStyle.fontSize        = 11;
                                doc.defaultStyle.alignment       = 'center';
                                doc.styles.tableHeader.fontSize  = 11;
                                doc.styles.tableHeader.alignment = 'center';
                                doc.styles.tableBodyOdd.fontSize  = 11;
                                doc.styles.tableBodyEven.fontSize = 11;
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
                    order      : [[1, 'asc']],
                    pageLength : 50
                });
            }
        })
        .fail(function () {
            $('#cur-results').html(
                '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                'Failed to load currency rates. Please try again.</div>'
            );
        })
        .always(function () {
            $('#cur-btn').prop('disabled', false).html('<i class="fa fa-refresh"></i> Refresh Rates');
        });
    }

    // Auto-load on page open
    loadCurrency();
    $('#cur-btn').on('click', loadCurrency);

    // Inline update on blur — event delegation survives DataTables re-render
    $(document).on('blur', '.cur-input', function () {
        var $inp  = $(this);
        var id    = $inp.data('id');
        var toinr = $inp.val().trim();

        if (toinr === '') return;

        $inp.css({ 'background': '#fffde7', 'border-color': '#f6c000' });

        $.post('ajax/handler.php', {
            action: 'currency_update',
            id    : id,
            toinr : toinr
        }, function (res) {
            if (res.ok) {
                $inp.css({ 'background': '#e8f5e9', 'border-color': '#43a047' });
            } else {
                $inp.css({ 'background': '#ffebee', 'border-color': '#e53935' });
                console.warn('Currency update failed:', res.msg);
            }
            setTimeout(function () { $inp.css({ 'background': '', 'border-color': '' }); }, 2000);
        }, 'json')
        .fail(function () {
            $inp.css({ 'background': '#ffebee', 'border-color': '#e53935' });
            setTimeout(function () { $inp.css({ 'background': '', 'border-color': '' }); }, 2000);
        });
    });
});
</script>
