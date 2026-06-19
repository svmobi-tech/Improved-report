<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Main Report';
$pageIcon  = 'fa-file-text-o';
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
        <form id="reportForm">
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
                        <label class="hp-filter-label">&nbsp;</label><br>
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
<div id="report-results"></div>

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

    // ── Product change → load operators via AJAX ──────────────────────────────
    $('#product').change(function () {
        var product = $(this).val();
        $('#f1').html('<select class="form-control" disabled><option>Loading...</option></select>');
        $('#f').html('<select class="form-control" disabled><option>-- Select Operator First --</option></select>');
        $('#report-results').html('');
        if (!product) {
            $('#f1').html('<select class="form-control" disabled><option>-- Select Product First --</option></select>');
            return;
        }
        $.get('ajax/findoperatormainreport.php', { product: product }, function (data) {
            $('#f1').html(data);
        });
    });

    // ── Operator change → load advertisers via AJAX ───────────────────────────
    $(document).on('change', '[name="operator"]', function () {
        var operator = $(this).val();
        var product  = $('#product').val();
        if (!operator) return;
        $('#f').html('<select class="form-control" disabled><option>Loading...</option></select>');
        $.get('ajax/advertisermainreport.php', { operator: operator, product: product }, function (data) {
            $('#f').html(data);
        });
    });

    // ── Submit → fetch report via AJAX (no page reload) ───────────────────────
    $('#reportForm').on('submit', function (e) {
        e.preventDefault();

        var product  = $('#product').val();
        var operator = $('[name="operator"]:visible').val();

        if (!product || !operator) {
            alert('Please select Product and Operator.');
            return;
        }

        // Show loading spinner
        $('#report-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading report...</p></div>'
        );

        // Destroy any existing DataTable first
        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#datatable-buttons')) {
            $('#datatable-buttons').DataTable().destroy();
        }

        $.ajax({
            url:    'ajax/report_data.php',
            method: 'POST',
            data:   $(this).serialize(),
            success: function (html) {
                $('#report-results').html(html);

                // Init DataTable on the returned table
                if ($('#datatable-buttons').length) {
                    $('#datatable-buttons').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy',     className: 'btn-sm' },
                            { extend: 'csv',      className: 'btn-sm' },
                            { extend: 'excel',    className: 'btn-sm' },
                            { extend: 'pdfHtml5', className: 'btn-sm' },
                            { extend: 'print',    className: 'btn-sm' }
                        ],
                        responsive: true,
                        ordering:   false,
                        paging:     false
                    });
                }
            },
            error: function () {
                $('#report-results').html(
                    '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                    '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                    'Failed to load report. Please try again.</div>'
                );
            }
        });
    });

});
</script>
