<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Sub Dashboard';
$pageIcon  = 'fa-th-large';

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
        <form id="subdashForm">
            <div class="row">

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Month</label>
                        <select name="month" id="month" class="form-control">
                            <?php
                            $months = ['01'=>'January','02'=>'February','03'=>'March','04'=>'April',
                                       '05'=>'May','06'=>'June','07'=>'July','08'=>'August',
                                       '09'=>'September','10'=>'October','11'=>'November','12'=>'December'];
                            $curMonth = date('m');
                            foreach ($months as $val => $label):
                            ?>
                            <option value="<?php echo $val; ?>" <?php echo ($curMonth === $val) ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Year</label>
                        <select name="year" id="year" class="form-control">
                            <?php for ($y = 2018; $y <= (int)date('Y'); $y++): ?>
                            <option value="<?php echo $y; ?>" <?php echo ($y == (int)date('Y')) ? 'selected' : ''; ?>>
                                <?php echo $y; ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Currency</label>
                        <select name="currency" id="currency" class="form-control">
                            <option value="INR">INR</option>
                            <option value="USD">USD</option>
                        </select>
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
<div id="subdash-results"></div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    $('#subdashForm').on('submit', function (e) {
        e.preventDefault();

        // Show loading spinner
        $('#subdash-results').html(
            '<div style="padding:60px; text-align:center;">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0; margin-top:14px; font-size:14px;">Loading report...</p>' +
            '</div>'
        );

        // Destroy existing DataTable before replacing HTML
        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#subdash-table')) {
            $('#subdash-table').DataTable().destroy();
        }

        $.ajax({
            url:    'ajax/subdash_data.php',
            method: 'POST',
            data:   $(this).serialize(),
            success: function (html) {
                $('#subdash-results').html(html);

                if ($('#subdash-table').length) {
                    $('#subdash-table').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy',     className: 'btn-sm' },
                            { extend: 'csv',      className: 'btn-sm' },
                            { extend: 'excel',    className: 'btn-sm' },
                            { extend: 'pdfHtml5', className: 'btn-sm' },
                            { extend: 'print',    className: 'btn-sm' }
                        ],
                        ordering:  false,
                        paging:    false,
                        responsive: true
                    });
                }
            },
            error: function () {
                $('#subdash-results').html(
                    '<div style="padding:40px; text-align:center; color:#e53e3e;">' +
                    '<i class="fa fa-exclamation-circle" style="font-size:32px; display:block; margin-bottom:10px;"></i>' +
                    'Failed to load report. Please try again.</div>'
                );
            }
        });
    });

});
</script>
