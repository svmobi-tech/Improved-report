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
            url:    'ajax/handler.php',
            method: 'POST',
            data:   $(this).serialize() + '&action=subdash_data',
            success: function (html) {
                $('#subdash-results').html(html);

                if ($('#subdash-table').length) {
                    $('#subdash-table').DataTable({
                        dom      : 'Bfrtip',
                        buttons  : [
                            { extend: 'copy',  className: 'btn-sm' },
                            { extend: 'csv',   className: 'btn-sm' },
                            {
                                extend   : 'excelHtml5',
                                text     : 'Excel',
                                className: 'btn-sm',
                                title    : '',
                                customize: function (xlsx) {
                                    var ws = xlsx.Sheets[xlsx.SheetNames[0]];

                                    // ── helpers ──────────────────────────────
                                    function colLetter(n) {
                                        n++; var s = '';
                                        while (n > 0) { var rem=(n-1)%26; s=String.fromCharCode(65+rem)+s; n=Math.floor((n-1)/26); }
                                        return s;
                                    }
                                    function colNum(s) {
                                        var n=0; for(var i=0;i<s.length;i++) n=n*26+(s.charCodeAt(i)-64); return n-1;
                                    }
                                    function sc(addr, val) { ws[addr] = {v: val, t: 's'}; }

                                    // ── parse current sheet range ─────────────
                                    var refParts = ws['!ref'].split(':');
                                    var startRow = parseInt(refParts[0].replace(/[A-Z]/g,''));
                                    var endStr   = refParts[1];
                                    var endRow   = parseInt(endStr.replace(/[A-Z]/g,''));
                                    var endCol   = colNum(endStr.replace(/[0-9]/g,''));

                                    // ── find the actual flat-header row ───────
                                    // (title:'' may still emit a blank/title row before headers)
                                    var hdrRow = startRow;
                                    for (var rr = startRow; rr <= Math.min(startRow+3, endRow); rr++) {
                                        if (ws['A'+rr] && String(ws['A'+rr].v) === 'Country') {
                                            hdrRow = rr; break;
                                        }
                                    }

                                    // ── snapshot header cells + data rows ─────
                                    var hdrCells = [];
                                    for (var c = 0; c <= endCol; c++) {
                                        hdrCells.push(ws[colLetter(c)+hdrRow] || null);
                                    }
                                    var dataCells = [];
                                    for (var r = hdrRow+1; r <= endRow; r++) {
                                        var row = [];
                                        for (var c = 0; c <= endCol; c++) {
                                            row.push(ws[colLetter(c)+r] || null);
                                        }
                                        dataCells.push(row);
                                    }

                                    // ── wipe sheet ────────────────────────────
                                    for (var r = startRow; r <= endRow; r++) {
                                        for (var c = 0; c <= endCol; c++) {
                                            delete ws[colLetter(c)+r];
                                        }
                                    }

                                    // ── row 1: group headers ──────────────────
                                    sc('D1','Activation'); sc('F1','Renewal'); sc('H1','Total');
                                    sc('J1','Callback Sent'); sc('K1','Digital Investment');
                                    sc('L1','SVMobi Revenue'); sc('M1','Profit / Loss');
                                    sc('N1','Projected');

                                    // ── row 2: sub-headers ────────────────────
                                    sc('D2','Count'); sc('E2','Amount');
                                    sc('F2','Count'); sc('G2','Amount');
                                    sc('H2','Count'); sc('I2','Amount');
                                    sc('N2','Total Amount');    sc('O2','Digital Investment');
                                    sc('P2','SVMobi Revenue');  sc('Q2','Profit / Loss');
                                    sc('R2','% Growth Over Last Month');

                                    // ── row 3: flat column headers ────────────
                                    for (var c = 0; c <= endCol; c++) {
                                        if (hdrCells[c]) ws[colLetter(c)+'3'] = {v: hdrCells[c].v, t: 's'};
                                    }
                                    // override with full names
                                    sc('J3','Callback Sent');   sc('K3','Digital Investment');
                                    sc('L3','SVMobi Revenue');  sc('M3','Profit / Loss');
                                    sc('N3','Total Amount');    sc('O3','Digital Investment');
                                    sc('P3','SVMobi Revenue');  sc('Q3','Profit / Loss');
                                    sc('R3','% Growth Over Last Month');

                                    // ── data rows (start at row 4) ────────────
                                    var greenFill = {patternType:'solid', fgColor:{rgb:'FF92D050'}};
                                    var redFill   = {patternType:'solid', fgColor:{rgb:'FFFF4444'}};

                                    for (var ri = 0; ri < dataCells.length; ri++) {
                                        var exRow = ri + 4;
                                        for (var c = 0; c <= endCol; c++) {
                                            var orig = dataCells[ri][c];
                                            if (!orig) continue;
                                            var addr = colLetter(c) + exRow;
                                            ws[addr] = {v: orig.v, t: orig.t};
                                            if (orig.z) ws[addr].z = orig.z; // keep number format
                                            // colour Q (c=16) and R (c=17)
                                            if (c === 16 || c === 17) {
                                                var raw = orig.v;
                                                var num = typeof raw === 'number' ? raw
                                                    : parseFloat(String(raw).replace(/[,%\s]/g,''));
                                                ws[addr].s = {fill: (!isNaN(num) && num < 0) ? redFill : greenFill};
                                            }
                                        }
                                    }

                                    // ── update range & merges ─────────────────
                                    ws['!ref'] = 'A1:' + colLetter(endCol) + (dataCells.length + 3);
                                    ws['!merges'] = [
                                        {s:{r:0,c:3},  e:{r:0,c:4}},  // Activation D1:E1
                                        {s:{r:0,c:5},  e:{r:0,c:6}},  // Renewal    F1:G1
                                        {s:{r:0,c:7},  e:{r:0,c:8}},  // Total      H1:I1
                                        {s:{r:0,c:13}, e:{r:0,c:17}}  // Projected  N1:R1
                                    ];
                                }   // end customize
                            },
                            { extend: 'pdfHtml5', className: 'btn-sm', orientation: 'landscape', pageSize: 'A3' },
                            { extend: 'print',    className: 'btn-sm' }
                        ],
                        ordering : false,
                        paging   : false,
                        autoWidth: false
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
