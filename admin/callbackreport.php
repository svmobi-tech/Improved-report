<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Callback Report';
$pageIcon  = 'fa-phone';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-phone"></i> Callback Report</h4>
    </div>
    <div class="hp-card-body">
        <form id="cbr-form">
            <div class="row">

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Product</label>
                        <select name="product" id="cbr-product" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="gamebar">Gamebar</option>
                            <option value="glambar">Glambar</option>
                            <option value="11Players">11Players</option>
                            <option value="Contest">Contest</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Operator</label>
                        <div id="cbr-operator-wrap">
                            <select name="operator" id="cbr-operator" class="form-control" disabled>
                                <option value="">-- Select Product First --</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Start Date</label>
                        <input type="text" name="start_date" id="cbr-start" class="form-control birthday"
                               value="<?php echo date('d-m-Y'); ?>">
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">End Date</label>
                        <input type="text" name="end_date" id="cbr-end" class="form-control birthday"
                               value="<?php echo date('d-m-Y'); ?>">
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">&nbsp;</label>
                        <button type="submit" id="cbr-submit-btn" class="btn btn-primary btn-block">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<div id="cbr-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-phone" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select a product and operator, then click Search.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    // ── Date pickers ──────────────────────────────────────────────────────────
    $('#cbr-start, #cbr-end').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        locale           : { format: 'DD-MM-YYYY' }
    });

    // ── Product change → load operators ──────────────────────────────────────
    $('#cbr-product').on('change', function () {
        var product = $(this).val();
        if (!product) {
            $('#cbr-operator-wrap').html(
                '<select name="operator" id="cbr-operator" class="form-control" disabled>' +
                '<option value="">-- Select Product First --</option></select>'
            );
            $('#cbr-results').html(
                '<div style="padding:60px;text-align:center;color:#a0aec0;">' +
                '<i class="fa fa-phone" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>' +
                'Select a product and operator, then click Search.</div>'
            );
            return;
        }
        $.get('ajax/handler.php', { action: 'find_operators', product: product }, function (html) {
            $('#cbr-operator-wrap').html(html);
        });
    });

    // ── Form submit → load report ─────────────────────────────────────────────
    $('#cbr-form').on('submit', function (e) {
        e.preventDefault();

        var product  = $('#cbr-product').val();
        var operator = $('#cbr-operator-wrap select').val();

        if (!product || !operator) {
            alert('Please select both Product and Operator.');
            return;
        }

        var $btn = $('#cbr-submit-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#cbr-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading report...</p></div>'
        );

        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#cbr-table')) {
            $('#cbr-table').DataTable().destroy();
        }

        $.post('ajax/handler.php', {
            action    : 'callback_report_load',
            product   : product,
            operator  : operator,
            start_date: $('#cbr-start').val(),
            end_date  : $('#cbr-end').val()
        })
        .done(function (html) {
            $('#cbr-results').html(html);

            if ($('#cbr-table').length) {
                $('#cbr-table').DataTable({
                    dom      : 'Bfrtip',
                    buttons  : [
                        { extend: 'copy',  className: 'btn-sm' },
                        { extend: 'csv',   className: 'btn-sm' },
                        { extend: 'excel', className: 'btn-sm' },
                        {
                            extend      : 'pdfHtml5',
                            className   : 'btn-sm',
                            title       : 'Callback Report | SVMobi',
                            orientation : 'landscape',
                            pageSize    : 'A4',
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
                        { extend: 'print', className: 'btn-sm' }
                    ],
                    order      : [[0, 'asc'], [1, 'asc']],
                    pageLength : 25
                });
            }
        })
        .fail(function () {
            $('#cbr-results').html(
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
