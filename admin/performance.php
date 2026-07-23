<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Current Month Performance';
$pageIcon  = 'fa-tachometer';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<!-- ─── Results Area (auto-loaded via AJAX on page open) ────────────────────── -->
<div id="perf-results">
    <div style="padding:80px;text-align:center">
        <i class="fa fa-refresh" style="font-size:34px;color:#667eea;display:inline-block;animation:hp-spin 0.9s linear infinite"></i>
        <p style="color:#a0aec0;margin-top:14px;font-size:14px">Loading performance data...</p>
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
        data   : { action: 'performance_data' },
        success: function (html) {
            $('#perf-results').html(html);

            if ($('#perf-table').length) {
                $('#perf-table').DataTable({
                    dom    : 'Bfrtip',
                    buttons: [
                        { extend: 'copy',  className: 'btn-sm' },
                        { extend: 'csv',   className: 'btn-sm' },
                        { extend: 'excel', className: 'btn-sm' },
                        {
                            text     : 'PDF',
                            className: 'btn-sm buttons-pdf buttons-html5',
                            action: function (e, dt) {


                                // Read data rows from DOM to capture inline background colors
                                var tableRows = [];
                                $('#perf-table tbody tr').each(function () {
                                    var row = [];
                                    $(this).find('td').each(function (ci) {
                                        var style = $(this).attr('style') || '';
                                        var bgM   = style.match(/background:\s*(#[0-9a-fA-F]{6})/i);
                                        var fill  = bgM ? bgM[1] : null;
                                        var cell  = { text: $(this).text().trim() };
                                        if (ci < 3) {
                                            cell.fillColor = '#e2e0e0';
                                            cell.bold      = true;
                                        } else if (fill) {
                                            cell.fillColor = fill;
                                            cell.color     = '#ffffff';
                                            cell.bold      = true;
                                            cell.alignment = 'center';
                                        } else {
                                            cell.alignment = 'center';
                                        }
                                        row.push(cell);
                                    });
                                    tableRows.push(row);
                                });

                                function pad2(n) { return (n < 10 ? '0' : '') + n; }
                                var yd   = new Date();
                                yd.setDate(yd.getDate() - 1);
                                var yStr = pad2(yd.getDate()) + '-' + pad2(yd.getMonth() + 1) + '-' + yd.getFullYear();

                                // Column widths: text cols fixed, 8 numeric cols share remaining space
                                var widths = [65, 55, 120, '*', '*', '*', '*', '*', '*', '*', '*', 65, 65];

                                // Build fresh header rows for the header() function.
                                // Must be a factory (called per-page) — pdfmake mutates cell
                                // objects during layout, so reusing the same objects across
                                // pages corrupts the repeated header.
                                function makeHdrRows() {
                                    function h(txt, extra) {
                                        var c = { text: txt, style: 'hdr', alignment: 'center' };
                                        if (extra) { for (var k in extra) { c[k] = extra[k]; } }
                                        return c;
                                    }
                                    return [
                                        [
                                            h('Country',    { rowSpan: 3, alignment: 'left' }),
                                            h('Product',    { rowSpan: 3, alignment: 'left' }),
                                            h('Operator',   { rowSpan: 3, alignment: 'left' }),
                                            h('Activation', { colSpan: 4 }), {}, {}, {},
                                            h('Renewal',    { colSpan: 4 }), {}, {}, {},
                                            h('% Growth',   { colSpan: 2, rowSpan: 2 }), {}
                                        ],
                                        [
                                            {}, {}, {},
                                            h('AVG. Last 30 Days', { colSpan: 2 }), {},
                                            h('Yesterday',         { colSpan: 2 }), {},
                                            h('AVG. Last 30 Days', { colSpan: 2 }), {},
                                            h('Yesterday',         { colSpan: 2 }), {},
                                            {}, {}
                                        ],
                                        [
                                            {}, {}, {},
                                            h('Count'), h('Amount'), h('Count'), h('Amount'),
                                            h('Count'), h('Amount'), h('Count'), h('Amount'),
                                            h('% Growth Act.'), h('% Growth Ren.')
                                        ]
                                    ];
                                }

                                var tblLayout = {
                                    hLineWidth   : function () { return 0.4; },
                                    vLineWidth   : function () { return 0.4; },
                                    hLineColor   : function () { return '#cbd5e0'; },
                                    vLineColor   : function () { return '#cbd5e0'; },
                                    paddingLeft  : function () { return 3; },
                                    paddingRight : function () { return 3; },
                                    paddingTop   : function () { return 2; },
                                    paddingBottom: function () { return 2; }
                                };

                                // Top margin = title(16) + subtitle(12) + 3 header rows(~11 each) + gaps = 73
                                pdfMake.createPdf({
                                    pageSize    : { width: 1190.55, height: 841.89 },
                                    pageMargins : [10, 73, 10, 10],
                                    defaultStyle: { fontSize: 6 },
                                    styles: {
                                        hdr: { bold: true, fontSize: 6.5, color: '#ffffff', fillColor: '#4a5568' }
                                    },
                                    // header() is called fresh for every page — generates new objects
                                    // each time so pdfmake mutation of span placeholders doesn't
                                    // corrupt subsequent pages. This also avoids the headerRows bug
                                    // where pdfmake falls back to A4 portrait when repeating a
                                    // complex colspan/rowspan header via table.headerRows.
                                    header: function () {
                                        return [
                                            {
                                                columns: [
                                                    { text: 'Performance Report  |  SVMobi', bold: true, fontSize: 11, color: '#2d3748' },
                                                    { text: 'Yesterday (' + yStr + ')  vs.  Last 30-Day Average', fontSize: 8, color: '#718096', alignment: 'right', margin: [0, 3, 0, 0] }
                                                ],
                                                margin: [10, 6, 10, 4]
                                            },
                                            {
                                                margin : [10, 0, 10, 0],
                                                table  : { widths: widths, body: makeHdrRows() },
                                                layout : tblLayout
                                            }
                                        ];
                                    },
                                    content: [
                                        {
                                            // data rows only — no headerRows so pdfmake never
                                            // attempts to repeat a colspan/rowspan header block
                                            table : { widths: widths, body: tableRows },
                                            layout: tblLayout
                                        }
                                    ]
                                }).download('Performance_Report_SVMobi.pdf');
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
            $('#perf-results').html(
                '<div style="padding:40px;text-align:center;color:#e53e3e">' +
                '<i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>' +
                'Failed to load performance data. Please refresh the page.</div>'
            );
        }
    });

});
</script>
