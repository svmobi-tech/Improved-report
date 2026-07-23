<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Dashboard';
$pageIcon  = 'fa-home';

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
        <form id="dashForm">
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
<div id="dash-results"></div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    // ── Auto-submit on page load with current month defaults ─────────────────
    function loadDashboard() {
        $('#dash-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading dashboard...</p></div>'
        );

        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#dash-table')) {
            $('#dash-table').DataTable().destroy();
        }

        $.ajax({
            url    : 'ajax/handler.php',
            method : 'POST',
            data   : $('#dashForm').serialize() + '&action=dashboard_data',
            success: function (html) {
                $('#dash-results').html(html);

                if ($('#dash-table').length) {
                    $('#dash-table').DataTable({
                        dom    : 'Bfrtip',
                        buttons: [
                            { extend: 'copy',  className: 'btn-sm' },
                            { extend: 'csv',   className: 'btn-sm' },
                            { extend: 'excel', className: 'btn-sm' },
                            {
                                extend   : 'pdfHtml5',
                                className: 'btn-sm',
                                title    : 'Dashboard | SVMobi',
                                customize: function (doc) {
                                    // A3 landscape — 17 columns
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
                $('#dash-results').html(
                    '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                    '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                    'Failed to load dashboard. Please try again.</div>'
                );
            }
        });
    }

    // Load on page open
    loadDashboard();

    // Reload on form submit
    $('#dashForm').on('submit', function (e) {
        e.preventDefault();
        loadDashboard();
    });

});
</script>
