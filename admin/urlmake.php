<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'URL Maker';
$pageIcon  = 'fa-link';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-search"></i> Search URLs</h4>
    </div>
    <div class="hp-card-body">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Product</label>
                    <select id="um-product" class="form-control">
                        <option value="">-- Select Product --</option>
                        <option value="gamebar">Gamebar</option>
                        <option value="glambar">Glambar</option>
                        <option value="11Players">11Players</option>
                        <option value="Contest">Contest</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Operator</label>
                    <select id="um-operator" class="form-control" disabled>
                        <option value="">-- Select Operator --</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Advertiser</label>
                    <select id="um-advertiser" class="form-control" disabled>
                        <option value="">-- Select Advertiser --</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button id="um-btn" class="btn btn-primary btn-block" disabled>
                        <i class="fa fa-search"></i> Generate URL
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="um-result" style="display:none;">
    <div class="hp-card">
        <div class="hp-card-header">
            <h4><i class="fa fa-link"></i> Generated URL</h4>
        </div>
        <div class="hp-card-body" style="overflow-x:auto;">
            <table class="table table-bordered" style="font-size:13px;">
                <thead style="background:#4a5568; color:#fff;">
                    <tr>
                        <th>Advertiser ID</th>
                        <th>Advertiser Name</th>
                        <th>URL</th>
                        <th style="width:90px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="um-advid"   style="white-space:nowrap;"></td>
                        <td id="um-advname" style="white-space:nowrap;"></td>
                        <td id="um-url"     style="word-break:break-all;"></td>
                        <td>
                            <button class="btn btn-xs btn-default" id="um-copy-btn" onclick="umCopy(this)">
                                <i class="fa fa-copy"></i> Copy
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="um-error" class="alert alert-danger" style="display:none;margin-top:10px;"></div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    // Product → load operators
    $('#um-product').on('change', function () {
        var product = $(this).val();
        $('#um-operator').html('<option value="">-- Select Operator --</option>').prop('disabled', true);
        $('#um-advertiser').html('<option value="">-- Select Advertiser --</option>').prop('disabled', true);
        $('#um-btn').prop('disabled', true);
        $('#um-result, #um-error').hide();

        if (!product) return;

        $('#um-operator').html('<option value="">Loading...</option>');
        $.post('ajax/handler.php', { action: 'urlmake_operators', product: product })
            .done(function (ops) {
                var $sel = $('#um-operator').empty().append('<option value="">-- Select Operator --</option>');
                $.each(ops, function (i, op) {
                    $sel.append($('<option>', { value: op, text: op }));
                });
                $sel.prop('disabled', ops.length === 0);
            })
            .fail(function () {
                $('#um-operator').html('<option value="">-- Error loading operators --</option>');
            });
    });

    // Operator → load advertisers
    $('#um-operator').on('change', function () {
        var operator = $(this).val();
        var product  = $('#um-product').val();
        $('#um-advertiser').html('<option value="">-- Select Advertiser --</option>').prop('disabled', true);
        $('#um-btn').prop('disabled', true);
        $('#um-result, #um-error').hide();

        if (!operator) return;

        $('#um-advertiser').html('<option value="">Loading...</option>');
        $.post('ajax/handler.php', { action: 'urlmake_advertisers', product: product, operator: operator })
            .done(function (advs) {
                var $sel = $('#um-advertiser').empty().append('<option value="">-- Select Advertiser --</option>');
                $.each(advs, function (i, adv) {
                    $sel.append($('<option>', { value: adv.id, text: adv.name }));
                });
                $sel.prop('disabled', advs.length === 0);
            })
            .fail(function () {
                $('#um-advertiser').html('<option value="">-- Error loading advertisers --</option>');
            });
    });

    // Advertiser → enable button
    $('#um-advertiser').on('change', function () {
        $('#um-btn').prop('disabled', !$(this).val());
        $('#um-result, #um-error').hide();
    });

    // Generate URL
    $('#um-btn').on('click', function () {
        var product      = $('#um-product').val();
        var operator     = $('#um-operator').val();
        var advertiserid = $('#um-advertiser').val();

        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating...');
        $('#um-result, #um-error').hide();

        $.post('ajax/handler.php', {
            action      : 'urlmake_generate',
            product     : product,
            operator    : operator,
            advertiserid: advertiserid
        })
        .done(function (data) {
            if (data.error) {
                $('#um-error').text(data.error).show();
            } else {
                $('#um-advid').text(data.advid);
                $('#um-advname').text(data.advname);
                $('#um-url').text(data.url);
                $('#um-copy-btn').html('<i class="fa fa-copy"></i> Copy');
                $('#um-result').show();
            }
        })
        .fail(function () {
            $('#um-error').text('Request failed. Please try again.').show();
        })
        .always(function () {
            $('#um-btn').prop('disabled', false).html('<i class="fa fa-search"></i> Generate URL');
        });
    });
});

function umCopy(btn) {
    var url = document.getElementById('um-url').innerText;
    var orig = btn.innerHTML;
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(function () {
            btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
            setTimeout(function () { btn.innerHTML = orig; }, 1500);
        });
    } else {
        var ta = document.createElement('textarea');
        ta.value = url;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
        btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
        setTimeout(function () { btn.innerHTML = orig; }, 1500);
    }
}
</script>
