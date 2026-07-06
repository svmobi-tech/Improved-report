<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="vendors/jszip/dist/jszip.min.js"></script>
<script src="vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="vendors/pdfmake/build/vfs_fonts.js"></script>
<script src="vendors/select2/dist/js/select2.full.min.js"></script>
<script src="js/moment/moment.min.js"></script>
<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
// Sidebar toggle — desktop collapses inline; mobile overlays on top
document.getElementById('sidebarToggle').addEventListener('click', function () {
    if (window.innerWidth <= 768) {
        document.body.classList.toggle('sidebar-mobile-open');
    } else {
        document.body.classList.toggle('sidebar-collapsed');
    }
});

// Close mobile sidebar when overlay is tapped
var _overlay = document.getElementById('hp-mobile-overlay');
if (_overlay) {
    _overlay.addEventListener('click', function () {
        document.body.classList.remove('sidebar-mobile-open');
    });
}

// Clean up mobile state on resize to desktop
window.addEventListener('resize', function () {
    if (window.innerWidth > 768) {
        document.body.classList.remove('sidebar-mobile-open');
    }
});

// Raw table clone saved BEFORE DataTables strips the thead content.
// transposeTable() reads from this so labels are never empty.
var _tableForTranspose = null;

$(document).ready(function () {

    // Date pickers — single date, DD-MM-YYYY format
    $('.date-picker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: { format: 'DD-MM-YYYY' }
    });

    // Hours — Select2 dropdown
    $('select[name=hours]').select2({ width: '100%', minimumResultsForSearch: Infinity });

    // AJAX report loader
    function submitReport() {
        var data = $('#formname').serialize() + '&submit=1';
        $('#ajax-output').html(
            '<div class="hp-loading">' +
            '<i class="fa fa-spinner hp-spin-icon"></i>' +
            '<p>Loading data&hellip;</p>' +
            '</div>'
        );
        $.ajax({
            url: window.location.pathname,
            type: 'POST',
            data: data,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function (html) {
                $('#ajax-output').html(html);
                // Reset transpose button label on every new report load
                $('.btn-transpose').html('<i class="fa fa-arrows-alt"></i> Transpose');

                if ($('#myTable').length) {
                    // Clone BEFORE DataTables modifies/empties the original thead cells.
                    // DataTables with scrollX moves header content to a separate scrollHead
                    // copy and leaves the original <th> elements empty, which breaks transpose.
                    _tableForTranspose = document.getElementById('myTable').cloneNode(true);

                    if ($.fn.DataTable.isDataTable('#myTable')) {
                        $('#myTable').DataTable().destroy();
                    }
                    // scrollX is intentionally omitted — the container already has
                    // overflow-x:auto, so the browser handles horizontal scroll natively.
                    // DataTables scrollX clones <thead> into a separate DOM node which
                    // breaks rowspan/colspan on multi-level headers.
                    $('#myTable').DataTable({
                        pageLength: 50,
                        order: [],
                        dom: '<"top"Bf>rt<"bottom"ip><"clear">',
                        buttons: [
                            { extend: 'copy',  className: 'btn btn-default' },
                            { extend: 'csv',   className: 'btn btn-default' },
                            { extend: 'excel', className: 'btn btn-default' },
                            {
                                extend   : 'pdfHtml5',
                                className: 'btn btn-default',
                                title    : 'Activation Report | SVMobi',
                                customize: function (doc) {
                                    // A2 landscape — width > height forces landscape on all pdfmake versions
                                    doc.pageSize = { width: 1683.78, height: 1190.55 };
                                    doc.pageMargins     = [10, 30, 10, 15];
                                    doc.defaultStyle.fontSize         = 6;
                                    doc.styles.tableHeader.fontSize   = 6;
                                    doc.styles.tableBodyOdd.fontSize  = 6;
                                    doc.styles.tableBodyEven.fontSize = 6;
                                    doc.content.forEach(function (node) {
                                        if (node.table) {
                                            var cols = node.table.body[0].length;
                                            node.table.widths = [];
                                            for (var i = 0; i < cols; i++) {
                                                node.table.widths.push('*');
                                            }
                                        }
                                    });
                                }
                            },
                            {
                                extend   : 'print',
                                className: 'btn btn-default',
                                customize: function (win) {
                                    $(win.document.head).append(
                                        '<style>' +
                                        '@page { size: A2 landscape; margin: 5mm; }' +
                                        'body { margin: 0; font-size: 7pt; }' +
                                        'table { border-collapse: collapse; width: 100% !important; table-layout: fixed; }' +
                                        'table th, table td { font-size: 6pt; padding: 1px 2px; word-break: break-word; overflow-wrap: break-word; }' +
                                        '</style>'
                                    );
                                }
                            }
                        ]
                    });
                }
            },
            error: function (xhr) {
                $('#ajax-output').html(
                    '<p class="text-danger" style="padding:20px">Error loading data (HTTP ' + xhr.status + '). Please try again.</p>'
                );
            }
        });
    }

    // Auto-load on page open
    setTimeout(submitReport, 500);

    // Re-load on form submit
    $('#formname').on('submit', function (e) {
        e.preventDefault();
        submitReport();
    });
});

// Transpose toggle — shows transposed view on first click, hides on second click.
function transposeTable() {
    var $output = $('#output');
    var $btn    = $('.btn-transpose');

    // If transposed view is already visible → hide it and reset button
    if ($output.children().length > 0) {
        $output.html('');
        $btn.html('<i class="fa fa-arrows-alt"></i> Transpose');
        return;
    }

    if (!_tableForTranspose) {
        alert('No table to transpose yet. Please generate a report first.');
        return;
    }

    const rows = Array.from(_tableForTranspose.rows);
    const grid = [];
    let maxCols = 0;

    for (let i = 0; i < rows.length; i++) {
        let colIndex = 0;
        if (!grid[i]) grid[i] = [];
        for (let cell of rows[i].cells) {
            while (grid[i][colIndex]) colIndex++;
            const colspan = cell.colSpan || 1;
            const rowspan = cell.rowSpan || 1;
            for (let r = 0; r < rowspan; r++) {
                for (let c = 0; c < colspan; c++) {
                    const ri = i + r, ci = colIndex + c;
                    if (!grid[ri]) grid[ri] = [];
                    grid[ri][ci] = (r === 0 && c === 0) ? cell.cloneNode(true) : null;
                }
            }
            colIndex += colspan;
        }
        maxCols = Math.max(maxCols, grid[i].length);
    }

    const newTable = document.createElement('table');
    newTable.border = '1';
    for (let col = 0; col < maxCols; col++) {
        const newRow = newTable.insertRow();
        for (let row = 0; row < grid.length; row++) {
            const cell = grid[row][col];
            if (cell === undefined || cell === null) continue;
            const newCell = cell.tagName === 'TH'
                ? document.createElement('th')
                : document.createElement('td');
            newCell.innerHTML = cell.innerHTML;
            if (cell.colSpan > 1) newCell.rowSpan = cell.colSpan;
            if (cell.rowSpan > 1) newCell.colSpan = cell.rowSpan;
            newRow.appendChild(newCell);
        }
    }
    $output.html('');
    $output[0].appendChild(newTable);

    // Update button to show "Hide" state
    $btn.html('<i class="fa fa-times"></i> Hide Transpose');
    $output[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
</body>
</html>
