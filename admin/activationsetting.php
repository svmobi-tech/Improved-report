<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Activation Report Setting';
$pageIcon  = 'fa-toggle-on';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-toggle-on"></i> Activation Report Setting</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button id="as-btn" class="btn btn-primary btn-block">
                        <i class="fa fa-refresh"></i> Refresh Settings
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="as-results">
    <div style="padding:60px;text-align:center">
        <i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>
        <p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading settings...</p>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    function loadSettings() {
        $('#as-btn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#as-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading settings...</p></div>'
        );

        $.post('ajax/handler.php', { action: 'activation_setting_load' })
        .done(function (html) {
            $('#as-results').html(html);

            if ($('#as-table').length) {
                /**
                 * exportBody — fixes two issues in this table:
                 *  1. Action column has a <select> — all option texts get joined
                 *     ("Open Close") instead of just the selected value.
                 *  2. Status column has a <span class="label"> badge — text
                 *     extraction works fine but we strip extra whitespace.
                 *
                 * DOM path (copy/csv/excel/print): node is the live <td>.
                 * Regex path (pdfHtml5): node is null, data is raw innerHTML.
                 */
                var exportBody = function (data, row, column, node) {
                    // DOM path
                    if (node) {
                        var $sel = $(node).find('select.action-select');
                        if ($sel.length) return $sel.val();
                        var $badge = $(node).find('.label');
                        if ($badge.length) return $badge.text().trim();
                    }
                    // Regex path for pdfHtml5
                    if (typeof data === 'string') {
                        // Action column: extract the <option selected>value</option>
                        if (data.indexOf('action-select') !== -1) {
                            var m = data.match(/<option[^>]+selected[^>]*>([^<]+)<\/option>/i);
                            return m ? m[1].trim() : '';
                        }
                        // Status column: extract text from <span class="label ...">text</span>
                        if (data.indexOf('class="label') !== -1) {
                            var m2 = data.match(/>([^<]+)<\/span>/);
                            return m2 ? m2[1].trim() : data;
                        }
                    }
                    return data;
                };

                var exportOpts = { format: { body: exportBody } };

                $('#as-table').DataTable({
                    dom      : 'Bfrtip',
                    buttons  : [
                        { extend: 'copy',  className: 'btn-sm', exportOptions: exportOpts },
                        { extend: 'csv',   className: 'btn-sm', exportOptions: exportOpts },
                        { extend: 'excel', className: 'btn-sm', exportOptions: exportOpts },
                        {
                            extend       : 'pdfHtml5',
                            className    : 'btn-sm',
                            title        : 'Activation Report Setting | SVMobi',
                            orientation  : 'portrait',
                            pageSize     : 'A4',
                            exportOptions: exportOpts,
                            customize    : function (doc) {
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
            $('#as-results').html(
                '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                'Failed to load settings. Please try again.</div>'
            );
        })
        .always(function () {
            $('#as-btn').prop('disabled', false).html('<i class="fa fa-refresh"></i> Refresh Settings');
        });
    }

    // Auto-load on page open
    loadSettings();

    $('#as-btn').on('click', loadSettings);

    // Handle Action dropdown change (event delegation — survives DataTables re-render)
    $(document).on('change', '.action-select', function () {
        var $sel    = $(this);
        var act     = $sel.val();
        var product = $sel.data('product');
        var country = $sel.data('country');
        var $status = $('.as-status-' + product + '-' + country);

        $sel.prop('disabled', true);

        $.post('ajax/handler.php', {
            action : 'activation_setting_update',
            act    : act,
            product: product,
            country: country
        })
        .done(function (res) {
            if (res && res.ok) {
                var badge = act === 'Open'
                    ? '<span class="label label-success">Open</span>'
                    : '<span class="label label-danger">Closed</span>';
                $status.html(badge);
            } else {
                alert('Update failed: ' + (res.msg || 'Unknown error'));
                // Revert dropdown
                loadSettings();
            }
        })
        .fail(function () {
            alert('Network error. Please try again.');
        })
        .always(function () {
            $sel.prop('disabled', false);
        });
    });
});
</script>
