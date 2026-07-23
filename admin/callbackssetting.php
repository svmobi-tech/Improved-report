<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Callback Settings';
$pageIcon  = 'fa-bell-o';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<!-- Filter Card -->
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-bell-o"></i> Callback Settings</h4>
    </div>
    <div class="hp-card-body">
        <form id="cb-search-form">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label>Product</label>
                        <select name="product" id="product" class="form-control">
                            <option value="">-- Select Product --</option>
                            <option value="gamebar">Gamebar</option>
                            <option value="glambar">Glambar</option>
                            <option value="11Players">11Players</option>
                            <option value="Contest">Contest</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label>Operator</label>
                        <div id="operator-wrap">
                            <select name="operator" id="operator" class="form-control">
                                <option value="">-- Select Product first --</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" id="cb-submit-btn" class="btn btn-primary btn-block">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Results -->
<div id="cb-results">
    <div style="padding:60px;text-align:center;color:#a0aec0;">
        <i class="fa fa-bell-o" style="font-size:40px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>
        Select a product and operator, then click Search.
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    // ── Product change → reload Operator dropdown ─────────────────────────────
    $('#product').on('change', function () {
        var product = $(this).val();
        if (!product) {
            $('#operator-wrap').html(
                '<select name="operator" id="operator" class="form-control">' +
                '<option value="">-- Select Product first --</option></select>'
            );
            return;
        }
        $.get('ajax/handler.php', { action: 'find_operators', product: product }, function (html) {
            $('#operator-wrap').html(html);
        });
    });

    // ── Form submit → load callback table ────────────────────────────────────
    $('#cb-search-form').on('submit', function (e) {
        e.preventDefault();

        var product  = $('#product').val();
        var operator = $('#operator-wrap select').val();

        if (!product || !operator) {
            alert('Please select both Product and Operator.');
            return;
        }

        var $btn = $('#cb-submit-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#cb-results').html(
            '<div style="padding:60px;text-align:center">' +
            '<i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>' +
            '<p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading callback data...</p></div>'
        );

        $.post('ajax/handler.php', {
            action   : 'callback_setting_load',
            product  : product,
            operator : operator
        }, function (res) {
            $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');

            if (!res.success) {
                $('#cb-results').html(
                    '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                    '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                    '<strong>' + (res.message || 'No data found.') + '</strong></div>'
                );
                return;
            }

            renderTable(res.rows, res.meta);
        }, 'json')
        .fail(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Search');
            $('#cb-results').html(
                '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                'Request failed. Please try again.</div>'
            );
        });
    });

    // ── Render results table ──────────────────────────────────────────────────
    function renderTable(rows, meta) {
        if (!rows.length) {
            $('#cb-results').html(
                '<div style="padding:60px;text-align:center">' +
                '<i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>' +
                '<p style="color:#a0aec0;margin:0">No records found for the selected combination.</p></div>'
            );
            return;
        }

        var inputStyle = 'width:70px;padding:4px 6px;border:1px solid #e2e8f0;border-radius:4px;text-align:center;font-size:12px;';

        var html = '<div class="hp-card"><div class="hp-card-header">';
        html += '<h4><i class="fa fa-list"></i> Callback Percentages';
        html += '<small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">';
        html += meta.product + ' &middot; ' + meta.operator + ' &middot; ' + rows.length + ' advertisers</small>';
        html += '</h4></div>';
        html += '<div class="hp-card-body" style="overflow-x:auto;">';
        html += '<p style="margin-bottom:10px;font-size:12px;color:#718096;">';
        html += '<i class="fa fa-info-circle"></i> Edit a value and click outside the field to save. ';
        html += 'Use the <strong>bulk row</strong> (header inputs) to set the same % for all advertisers.</p>';
        html += '<table id="cb-table" class="table table-striped table-bordered" style="width:100%">';
        html += '<thead><tr>';
        html += '<th style="text-align:center">ID</th>';
        html += '<th style="text-align:center">Advertiser Name</th>';
        html += '<th style="text-align:center">Callback URL</th>';
        html += '<th style="text-align:center">Act Stop (%)<br>';
        html += '<input type="number" class="cb-bulk" style="' + inputStyle + '" data-type="act_stop"  placeholder="All" min="0" max="100" title="Set for ALL advertisers"></th>';
        html += '<th style="text-align:center">Spi-lower Stop (%)<br>';
        html += '<input type="number" class="cb-bulk" style="' + inputStyle + '" data-type="spo_stop" placeholder="All" min="0" max="100" title="Set for ALL advertisers"></th>';
        html += '<th style="text-align:center">CG Stop (%)<br>';
        html += '<input type="number" class="cb-bulk" style="' + inputStyle + '" data-type="cg_stop"  placeholder="All" min="0" max="100" title="Set for ALL advertisers"></th>';
        html += '</tr></thead><tbody>';

        rows.forEach(function (r) {
            html += '<tr>';
            html += '<td style="text-align:center">' + r.advertiserid + '</td>';
            html += '<td>' + r.advname + '</td>';
            html += '<td style="font-size:11px;word-break:break-all;">' + r.callbackurl + '</td>';
            html += '<td style="text-align:center"><input type="number" class="cb-stop" style="' + inputStyle + '"'
                  + ' value="' + (r.act_stop || '') + '" data-type="act_stop"  data-advid="' + r.advertiserid + '" placeholder="%" min="0" max="100"></td>';
            html += '<td style="text-align:center"><input type="number" class="cb-stop" style="' + inputStyle + '"'
                  + ' value="' + (r.spo_stop || '') + '" data-type="spo_stop" data-advid="' + r.advertiserid + '" placeholder="%" min="0" max="100"></td>';
            html += '<td style="text-align:center"><input type="number" class="cb-stop" style="' + inputStyle + '"'
                  + ' value="' + (r.cg_stop  || '') + '" data-type="cg_stop"  data-advid="' + r.advertiserid + '" placeholder="%" min="0" max="100"></td>';
            html += '</tr>';
        });

        html += '</tbody></table></div></div>';
        $('#cb-results').html(html);

        if ($('#cb-table').length) {
            /**
             * exportBody — called per cell by every export button.
             *
             * For copy/csv/excel/print: `node` is the live <td> DOM element.
             *   → find the <input.cb-stop> inside it and return .val()
             *
             * For pdfHtml5: DataTables passes the raw innerHTML string as `data`
             *   (the full <input type="number" ... value="95" ...> markup).
             *   pdfmake chokes on '<' / '>' in text, which is why Spi-lower and
             *   CG Stop columns are missing in the PDF entirely.
             *   → extract the value="..." attribute via regex instead.
             */
            var exportBody = function (data, row, column, node) {
                // DOM path (copy / csv / excel / print)
                if (node) {
                    var $inp = $(node).find('input.cb-stop');
                    if ($inp.length) return $inp.val();
                }
                // Regex path (pdfHtml5 — node is null, data is innerHTML string)
                if (typeof data === 'string' && data.indexOf('cb-stop') !== -1) {
                    var m = data.match(/\bvalue="(\d*)"/);
                    return m ? m[1] : '';
                }
                return data;
            };

            // Header cleaner: strip the bulk-input from <th> so PDF headers show
            // only the column label, not raw <input> HTML
            var exportHeader = function (data, column, node) {
                if (node) {
                    var clone = $(node).clone();
                    clone.find('input').remove();
                    return clone.text().trim();
                }
                return $('<div>').html(data).find('input').remove().end().text().trim();
            };

            var exportOpts    = { format: { body: exportBody } };
            var exportOptsPdf = { format: { body: exportBody, header: exportHeader } };

            $('#cb-table').DataTable({
                dom        : 'Bfrtip',
                buttons    : [
                    { extend: 'copy',  className: 'btn-sm', exportOptions: exportOpts },
                    { extend: 'csv',   className: 'btn-sm', exportOptions: exportOpts },
                    { extend: 'excel', className: 'btn-sm', exportOptions: exportOpts },
                    {
                        extend     : 'pdfHtml5',
                        className  : 'btn-sm',
                        title      : 'Callback Settings | SVMobi',
                        orientation: 'landscape',
                        pageSize   : 'A4',
                        exportOptions: exportOptsPdf,
                        customize  : function (doc) {
                            doc.pageMargins = [20, 35, 20, 20];
                            doc.defaultStyle.fontSize        = 9;
                            doc.defaultStyle.alignment       = 'center';
                            doc.styles.tableHeader.fontSize  = 9;
                            doc.styles.tableHeader.alignment = 'center';
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
                    { extend: 'print', className: 'btn-sm', exportOptions: exportOptsPdf }
                ],
                order      : [[1, 'asc']],
                pageLength : 25,
                columnDefs : [{ targets: [3, 4, 5], orderable: false }]
            });
        }

        // Store meta for update calls
        $('#cb-table').data('meta', meta);
    }

    // ── Per-row blur → save ───────────────────────────────────────────────────
    $(document).on('blur', '.cb-stop', function () {
        var $input = $(this);
        var meta   = $('#cb-table').data('meta');
        sendUpdate($input.data('type'), $input.data('advid'), $input.val().trim(), meta, $input);
    });

    // ── Bulk header blur → save for all advertisers ───────────────────────────
    $(document).on('blur', '.cb-bulk', function () {
        var $input = $(this);
        var perc   = $input.val().trim();
        if (perc === '') return;
        var meta   = $('#cb-table').data('meta');
        if (!meta) return;

        if (!confirm('Set ' + $input.data('type').replace('_', ' ') + ' = ' + perc + '% for ALL advertisers?')) {
            $input.val('');
            return;
        }
        sendUpdate($input.data('type'), 'mehul', perc, meta, $input);
    });

    // ── AJAX update helper ────────────────────────────────────────────────────
    function sendUpdate(cbtype, advertiserid, perc, meta, $input) {
        $input.css({ 'background': '#fffde7', 'border-color': '#f6c000' });

        $.post('ajax/handler.php', {
            action            : 'callback_setting_update',
            callbacktype      : cbtype,
            advertiserid      : advertiserid,
            callbackstop_perc : perc,
            advdb             : meta.advdb,
            advtable          : meta.advtable,
            condition         : meta.condition
        }, function (res) {
            if (res.ok) {
                $input.css({ 'background': '#e8f5e9', 'border-color': '#43a047' });
            } else {
                $input.css({ 'background': '#ffebee', 'border-color': '#e53935' });
                console.warn('Callback update failed:', res.msg);
            }
            setTimeout(function () { $input.css({ 'background': '', 'border-color': '' }); }, 2000);
        }, 'json')
        .fail(function () {
            $input.css({ 'background': '#ffebee', 'border-color': '#e53935' });
            setTimeout(function () { $input.css({ 'background': '', 'border-color': '' }); }, 2000);
        });
    }
});
</script>
