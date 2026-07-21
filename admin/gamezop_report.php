<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Gamezop Report';
$pageIcon  = 'fa-gamepad';

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
        <h4><i class="fa fa-gamepad"></i> Gamezop Revenue Report</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">
                        Partner
                        <span id="gz-partner-spinner" style="margin-left:6px;">
                            <i class="fa fa-spinner fa-spin" style="font-size:11px;color:#764ba2;"></i>
                        </span>
                    </label>
                    <select id="gz-partner" class="form-control" disabled>
                        <option value="">-- Loading partners... --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">Start Date</label>
                    <input type="text" id="gz-start" class="form-control birthday"
                           value="<?php echo date('d-m-Y'); ?>">
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">End Date</label>
                    <input type="text" id="gz-end" class="form-control birthday"
                           value="<?php echo date('d-m-Y'); ?>">
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="hp-filter-label">&nbsp;</label>
                    <button id="gz-search-btn" class="btn btn-primary btn-block" disabled>
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Loading indicator -->
<div id="gz-loading" style="display:none;text-align:center;padding:48px 0;">
    <i class="fa fa-spinner fa-spin" style="font-size:36px;color:#764ba2;"></i>
    <p style="color:#718096;margin-top:14px;font-size:14px;">Fetching data from Gamezop API...</p>
</div>

<!-- Results (hidden until first search) -->
<div id="gz-results" style="display:none;">

    <!-- Stat tiles -->
    <div class="row" style="margin-bottom:4px;">
        <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom:16px;">
            <div class="hp-card" style="text-align:center;padding:18px 12px;margin-bottom:0;">
                <div style="font-size:11px;color:#718096;text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px;">Your Revenue</div>
                <div id="gz-your-rev" style="font-size:22px;font-weight:700;color:#667eea;">0.00</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom:16px;">
            <div class="hp-card" style="text-align:center;padding:18px 12px;margin-bottom:0;">
                <div style="font-size:11px;color:#718096;text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px;">Total Revenue</div>
                <div id="gz-total-rev" style="font-size:22px;font-weight:700;color:#48bb78;">0.00</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom:16px;">
            <div class="hp-card" style="text-align:center;padding:18px 12px;margin-bottom:0;">
                <div style="font-size:11px;color:#718096;text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px;">Impressions</div>
                <div id="gz-impressions" style="font-size:22px;font-weight:700;color:#ed8936;">0</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom:16px;">
            <div class="hp-card" style="text-align:center;padding:18px 12px;margin-bottom:0;">
                <div style="font-size:11px;color:#718096;text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px;">eCPM</div>
                <div id="gz-ecpm" style="font-size:22px;font-weight:700;color:#4299e1;">0.00</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom:16px;">
            <div class="hp-card" style="text-align:center;padding:18px 12px;margin-bottom:0;">
                <div style="font-size:11px;color:#718096;text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px;">Clicks</div>
                <div id="gz-clicks" style="font-size:22px;font-weight:700;color:#9f7aea;">0</div>
            </div>
        </div>
    </div>

    <!-- API notice (shown only when API has no/error data) -->
    <div id="gz-api-note" style="display:none;margin-bottom:12px;padding:10px 16px;background:#fffbeb;border:1px solid #fcd34d;border-radius:8px;font-size:13px;color:#92400e;">
        <i class="fa fa-exclamation-triangle" style="margin-right:6px;"></i>
        <span id="gz-api-note-text"></span>
    </div>

    <!-- Table -->
    <div class="hp-card" style="margin-bottom:16px;">
        <div class="hp-card-header">
            <h4><i class="fa fa-table"></i> Daily Breakdown — <span id="gz-table-title"></span></h4>
            <button class="btn btn-sm btn-default" onclick="gzDownloadCSV()"
                    style="float:right;margin-top:-4px;">
                <i class="fa fa-download"></i> Download CSV
            </button>
        </div>
        <div class="hp-card-body" style="padding:0;overflow-x:auto;">
            <table id="gz-table" class="table table-striped table-bordered" style="margin-bottom:0;">
                <thead>
                    <tr style="background:#4a5568;color:#fff;text-align:center;">
                        <th>Date</th>
                        <th>Your Revenue</th>
                        <th>Total Revenue</th>
                        <th>Impressions</th>
                        <th>eCPM</th>
                        <th>Clicks</th>
                    </tr>
                </thead>
                <tbody id="gz-tbody"></tbody>
            </table>
        </div>
    </div>

    <!-- Chart -->
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-line-chart"></i> Revenue Trend — Last 5 Days</h4>
        </div>
        <div class="hp-card-body">
            <canvas id="gz-chart" style="max-height:280px;"></canvas>
            <div id="gz-chart-empty" style="display:none;text-align:center;padding:40px;color:#a0aec0;">
                <i class="fa fa-bar-chart" style="font-size:36px;display:block;margin-bottom:10px;"></i>
                No stored chart data available for the last 5 days.
            </div>
        </div>
    </div>

</div><!-- /gz-results -->

<!-- All-Partners Date-wise (shown when no partner selected) -->
<div id="gz-all-results" style="display:none;">
    <div id="gz-all-header" style="margin-bottom:12px;padding:10px 14px;background:#ebf4ff;border:1px solid #bee3f8;border-radius:8px;font-size:13px;color:#2b6cb0;">
        <i class="fa fa-info-circle" style="margin-right:6px;"></i>
        Showing date-wise data for all partners — <strong><span id="gz-all-title"></span></strong>
        <button class="btn btn-sm btn-default" onclick="gzAllDownloadCSV()" style="float:right;margin-top:-3px;">
            <i class="fa fa-download"></i> Download CSV
        </button>
    </div>
    <div id="gz-all-cards"></div>
</div>

</div><!-- /hp-content -->
</div><!-- /hp-main -->

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
var gzChart = null;

$(document).ready(function () {

    // Load partner dropdown
    $.post('ajax/handler.php', { action: 'gamezop_partners' }, function (data) {
        var $sel = $('#gz-partner').empty().append('<option value="">-- Select Partner --</option>');
        $.each(data, function (i, p) {
            $sel.append($('<option>').val(p.userid).text(p.name));
        });
        $sel.prop('disabled', false);
        $('#gz-partner-spinner').hide();
        checkReady();
    }, 'json').fail(function () {
        $('#gz-partner').html('<option value="">-- Failed to load --</option>');
        $('#gz-partner-spinner').hide();
    });

    // Date pickers
    $('#gz-start, #gz-end').daterangepicker({
        singleDatePicker: true,
        autoApply: true,
        maxDate: moment(),
        locale: { format: 'DD-MM-YYYY' }
    }).on('apply.daterangepicker', function () { checkReady(); });

    $('#gz-partner').on('change', checkReady);
    $('#gz-search-btn').on('click', gzSearch);
});

function checkReady() {
    var ok = !!($('#gz-start').val() && $('#gz-end').val());
    $('#gz-search-btn').prop('disabled', !ok);
}

function toYMD(s) {
    var p = s.split('-');
    return p[2] + '-' + p[1] + '-' + p[0];
}

function gzSearch() {
    var ymdStart = toYMD($('#gz-start').val());
    var ymdEnd   = toYMD($('#gz-end').val());
    var partner  = $('#gz-partner').val();
    if (ymdStart > moment().format('YYYY-MM-DD') || ymdEnd > moment().format('YYYY-MM-DD')) {
        alert('Future dates are not allowed.');
        return;
    }

    $('#gz-results').hide();
    $('#gz-all-results').hide();
    $('#gz-loading').show();
    $('#gz-search-btn').prop('disabled', true);

    if (partner) {
        // ── Single-partner flow ───────────────────────────────────────────────
        $.post('ajax/handler.php', {
            action:     'gamezop_report_load',
            userid:     partner,
            start_date: ymdStart,
            end_date:   ymdEnd
        }, function (r) {
            $('#gz-loading').hide();
            $('#gz-search-btn').prop('disabled', false);

            if (!r.success) { alert(r.error || 'Failed to load data.'); return; }

            if (r.api_note) { $('#gz-api-note-text').text(r.api_note); $('#gz-api-note').show(); }
            else            { $('#gz-api-note').hide(); }

            $('#gz-your-rev').text(parseFloat(r.stats.your_revenue).toFixed(2));
            $('#gz-total-rev').text(parseFloat(r.stats.total_revenue).toFixed(2));
            $('#gz-impressions').text(parseInt(r.stats.impressions).toLocaleString());
            $('#gz-ecpm').text(parseFloat(r.stats.ecpm).toFixed(2));
            $('#gz-clicks').text(parseInt(r.stats.clicks).toLocaleString());

            if (gzChart) { gzChart.destroy(); gzChart = null; }
            if (r.chart.labels.length > 0) {
                $('#gz-chart').show(); $('#gz-chart-empty').hide();
                gzChart = new Chart($('#gz-chart')[0].getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: r.chart.labels,
                        datasets: [{
                            label: 'Total Revenue',
                            data: r.chart.data,
                            borderColor: '#fbbf24',
                            backgroundColor: 'rgba(251,191,36,0.15)',
                            fill: true, tension: 0.5, pointRadius: 5, pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: false } }
                    }
                });
            } else {
                $('#gz-chart').hide(); $('#gz-chart-empty').show();
            }

            $('#gz-table-title').text(r.partner_name);
            var $tbody = $('#gz-tbody').empty();
            if (r.rows.length === 0) {
                $tbody.append('<tr><td colspan="6" style="text-align:center;padding:32px;color:#a0aec0;">' +
                    '<i class="fa fa-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>' +
                    'No stored records found for this date range.</td></tr>');
            } else {
                $.each(r.rows, function (i, row) {
                    $tbody.append($('<tr>').css('text-align', 'center').append(
                        $('<td>').text(row.date),
                        $('<td>').text(parseFloat(row.your_rev).toFixed(2)),
                        $('<td>').text(parseFloat(row.total_rev).toFixed(2)),
                        $('<td>').text(parseInt(row.impressions).toLocaleString()),
                        $('<td>').text(parseFloat(row.ecpm).toFixed(2)),
                        $('<td>').text(parseInt(row.clicks).toLocaleString())
                    ));
                });
            }
            $('#gz-results').show();

        }, 'json').fail(function () {
            $('#gz-loading').hide();
            $('#gz-search-btn').prop('disabled', false);
            alert('Server error. Please try again.');
        });

    } else {
        // ── All-partners flow ─────────────────────────────────────────────────
        $.post('ajax/handler.php', {
            action:     'gamezop_all_partners_report',
            start_date: ymdStart,
            end_date:   ymdEnd
        }, function (r) {
            $('#gz-loading').hide();
            $('#gz-search-btn').prop('disabled', false);

            if (!r.success) { alert(r.error || 'Failed to load data.'); return; }

            var label = $('#gz-start').val() + ' — ' + $('#gz-end').val();
            $('#gz-all-title').text(label);

            var $cards = $('#gz-all-cards').empty();

            if (!r.partners || r.partners.length === 0) {
                $cards.html('<div style="text-align:center;padding:48px;color:#a0aec0;">' +
                    '<i class="fa fa-inbox" style="font-size:36px;display:block;margin-bottom:10px;"></i>' +
                    'No stored records found for any partner in this date range.</div>');
            } else {
                // Build two-per-row layout
                var $row;
                $.each(r.partners, function (i, partner) {
                    if (i % 2 === 0) {
                        $row = $('<div class="row">').css('margin-bottom', '0');
                        $cards.append($row);
                    }

                    // Build table rows
                    var $tbody = $('<tbody>');
                    $.each(partner.rows, function (j, d) {
                        $tbody.append($('<tr>').append(
                            $('<td>').css('text-align','center').text(d.date),
                            $('<td>').css('text-align','center').text(parseFloat(d.total_rev).toFixed(2)),
                            $('<td>').css('text-align','center').text(parseFloat(d.your_rev).toFixed(2)),
                            $('<td>').css('text-align','center').text(parseInt(d.impressions).toLocaleString()),
                            $('<td>').css('text-align','center').text(parseFloat(d.ecpm).toFixed(2)),
                            $('<td>').css('text-align','center').text(parseInt(d.clicks).toLocaleString())
                        ));
                    });

                    var $card = $('<div class="col-md-6 col-sm-12">').css('margin-bottom','16px').append(
                        $('<div class="hp-card">').css('margin-bottom','0').append(
                            $('<div class="hp-card-header">').append(
                                $('<h4>').append(
                                    $('<i>').addClass('fa fa-gamepad').css('margin-right','6px'),
                                    document.createTextNode(partner.name)
                                )
                            ),
                            $('<div class="hp-card-body">').css({padding:'0','overflow-x':'auto'}).append(
                                $('<table class="table table-striped table-bordered">').css('margin-bottom','0').append(
                                    $('<thead>').append(
                                        $('<tr>').css({background:'#4a5568',color:'#fff','text-align':'center'}).append(
                                            $('<th>').text('Date'),
                                            $('<th>').text('Total Rev'),
                                            $('<th>').text('Your Rev'),
                                            $('<th>').text('Impr.'),
                                            $('<th>').text('eCPM'),
                                            $('<th>').text('Clicks')
                                        )
                                    ),
                                    $tbody
                                )
                            )
                        )
                    );
                    $row.append($card);
                });
            }

            $('#gz-all-results').show();

        }, 'json').fail(function () {
            $('#gz-loading').hide();
            $('#gz-search-btn').prop('disabled', false);
            alert('Server error. Please try again.');
        });
    }
}

function gzDownloadCSV() {
    var csv = [];
    $('#gz-table tr').each(function () {
        var cols = [];
        $(this).find('th, td').each(function () {
            cols.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
        });
        csv.push(cols.join(','));
    });
    var blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
    var url  = URL.createObjectURL(blob);
    $('<a>').attr({ href: url, download: 'gamezop_report.csv' }).appendTo('body')[0].click();
    $('a[download="gamezop_report.csv"]').remove();
    URL.revokeObjectURL(url);
}

function gzAllDownloadCSV() {
    var csv = [];
    // Each partner card has its own table — loop all of them
    $('#gz-all-cards .hp-card').each(function () {
        var partnerName = $(this).find('.hp-card-header h4').text().trim();
        csv.push('"' + partnerName.replace(/"/g, '""') + '"');
        $(this).find('table tr').each(function () {
            var cols = [];
            $(this).find('th, td').each(function () {
                cols.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
            });
            csv.push(cols.join(','));
        });
        csv.push(''); // blank line between partners
    });
    var blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
    var url  = URL.createObjectURL(blob);
    $('<a>').attr({ href: url, download: 'gamezop_all_partners.csv' }).appendTo('body')[0].click();
    $('a[download="gamezop_all_partners.csv"]').remove();
    URL.revokeObjectURL(url);
}
</script>
