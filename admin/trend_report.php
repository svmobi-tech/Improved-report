<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Trend Report';
$pageIcon  = 'fa-line-chart';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<!-- ─── Filter Card ─────────────────────────────────────────────────────────── -->
<div class="hp-card hp-filter-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-search"></i> Search Report</h4>
    </div>
    <div class="hp-card-body">
        <form id="trendForm">
            <div class="row">

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Product</label>
                        <select name="product" id="product" class="form-control">
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
                        <span id="f1">
                            <select class="form-control" disabled>
                                <option>-- Select Product First --</option>
                            </select>
                        </span>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Start Date</label>
                        <input class="birthday form-control" name="start_date" id="start_date" type="text"
                            value="<?php echo date('d-m-Y'); ?>">
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">End Date</label>
                        <input class="birthday form-control" name="end_date" id="end_date" type="text"
                            value="<?php echo date('d-m-Y'); ?>">
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Type</label>
                        <select name="type" class="form-control">
                            <option value="act">Activation</option>
                            <option value="ren">Renewal</option>
                            <option value="totalamount">Total-amount</option>
                            <option value="clicks">Clicks</option>
                            <option value="low">Lowbalance</option>
                            <option value="callback">Callback-Sent</option>
                            <option value="pinconf">Pin confirmed</option>
                            <option value="trial">Trial</option>
                            <option value="cg">Sent To CG</option>
                            <option value="cr">C.R.</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Advertiser</label>
                        <span id="f">
                            <select class="form-control" disabled>
                                <option>-- Select Operator First --</option>
                            </select>
                        </span>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">&nbsp;</label>
                        <button type="submit" id="btnSubmit" class="btn-submit-report">
                            <i class="fa fa-search"></i> Submit
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- ─── Results Area (populated via AJAX) ───────────────────────────────────── -->
<div id="trend-results"></div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    // ── Date pickers ──────────────────────────────────────────────────────────
    $('#start_date, #end_date').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        locale           : { format: 'DD-MM-YYYY' }
    });

    // ── Product change → load operators ──────────────────────────────────────
    $('#product').change(function () {
        var product = $(this).val();
        $('#f1').html('<select class="form-control" disabled><option>Loading...</option></select>');
        $('#f').html('<select class="form-control" disabled><option>-- Select Operator First --</option></select>');
        $('#trend-results').html('');
        if (!product) {
            $('#f1').html('<select class="form-control" disabled><option>-- Select Product First --</option></select>');
            return;
        }
        $.get('ajax/handler.php', { action: 'find_operators_trend', product: product }, function (data) {
            $('#f1').html(data);
        });
    });

    // ── Operator change → load advertisers ───────────────────────────────────
    $(document).on('change', '[name="operator"]', function () {
        var operator = $(this).val();
        var product  = $('#product').val();
        if (!operator) return;
        $('#f').html('<select class="form-control" disabled><option>Loading...</option></select>');
        $.get('ajax/handler.php', { action: 'find_advertisers', operator: operator, product: product }, function (data) {
            $('#f').html(data);
        });
    });

    // ── Submit → fetch report via AJAX ────────────────────────────────────────
    $('#trendForm').on('submit', function (e) {
        e.preventDefault();

        var product  = $('#product').val();
        var operator = $('[name="operator"]:visible').val();

        if (!product || !operator) {
            alert('Please select Product and Operator.');
            return;
        }

        $('#trend-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading report...</p></div>'
        );

        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#trend-table')) {
            $('#trend-table').DataTable().destroy();
        }

        $.ajax({
            url    : 'ajax/handler.php',
            method : 'POST',
            data   : $(this).serialize() + '&action=trend_data',
            success: function (html) {
                $('#trend-results').html(html);

                if ($('#trend-table').length) {
                    $('#trend-table').DataTable({
                        dom    : 'Bfrtip',
                        buttons: [
                            { extend: 'copy',  className: 'btn-sm' },
                            { extend: 'csv',   className: 'btn-sm' },
                            { extend: 'excel', className: 'btn-sm' },
                            {
                                extend   : 'pdfHtml5',
                                className: 'btn-sm',
                                title    : 'Trend Report | SVMobi',
                                customize: function (doc) {
                                    // A3 landscape — 26 columns (Date + 24 hours + Total)
                                    doc.pageSize = { width: 1190.55, height: 841.89 };
                                    doc.pageMargins     = [10, 30, 10, 15];
                                    doc.defaultStyle.fontSize         = 7;
                                    doc.styles.tableHeader.fontSize   = 7;
                                    doc.styles.tableBodyOdd.fontSize  = 7;
                                    doc.styles.tableBodyEven.fontSize = 7;
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
                                        '@page { size: A3 landscape; margin: 5mm; }' +
                                        'body { margin: 0; font-size: 7pt; }' +
                                        'table { border-collapse: collapse; width: 100% !important; table-layout: fixed; }' +
                                        'table th, table td { font-size: 6pt; padding: 1px 2px; word-break: break-word; }' +
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
                $('#trend-results').html(
                    '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                    '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                    'Failed to load report. Please try again.</div>'
                );
            }
        });
    });

});
</script>
