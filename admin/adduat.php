<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'Add UAT';
$pageIcon  = 'fa-plus-circle';

include("includes/check_session.php");
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

<div id="uat-alert" style="display:none;margin-bottom:16px;"></div>

<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-plus-circle"></i> Add UAT Record</h4>
    </div>
    <div class="hp-card-body">
        <form id="adduat-form" autocomplete="off">

            <table class="table table-bordered" style="width:100%;table-layout:fixed;">
                <colgroup>
                    <col style="width:48px">
                    <col style="width:46%">
                    <col>
                </colgroup>
                <tbody>

                <!-- ── Basic Info ─────────────────────────────────────────── -->
                <tr>
                    <td colspan="3" style="background:#f8f9fa;padding:10px 14px;">
                        <strong style="color:#667eea;font-size:13px;">
                            <i class="fa fa-info-circle"></i> Basic Information
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>1.</strong></td>
                    <td>Product</td>
                    <td><input name="product" class="form-control" type="text" required placeholder="e.g. gamebar"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>2.</strong></td>
                    <td>Country</td>
                    <td><input name="country" class="form-control" type="text" required placeholder="e.g. Qatar"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>3.</strong></td>
                    <td>Operator</td>
                    <td><input name="operator" class="form-control" type="text" required placeholder="e.g. Vodafone_Qatar"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>4.</strong></td>
                    <td>Test URL</td>
                    <td><input name="url" class="form-control" type="text" required placeholder="https://..."></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>5.</strong></td>
                    <td>Price Point</td>
                    <td><input name="pricepoint" class="form-control" type="text" required placeholder="e.g. 1.5 QAR"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>6.</strong></td>
                    <td>Days of Price Point</td>
                    <td><input name="pricepointdays" class="form-control" type="text" required placeholder="e.g. 7"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>7.</strong></td>
                    <td>Free Trial</td>
                    <td><input name="freetrial" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>8.</strong></td>
                    <td>Free Trial Days</td>
                    <td><input name="freetrialdays" class="form-control" type="text" required placeholder="e.g. 3"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>9.</strong></td>
                    <td>Fallback</td>
                    <td><input name="fallback" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>10.</strong></td>
                    <td>Fallback Amount</td>
                    <td><input name="actfallbackamount" class="form-control" type="text" required placeholder="e.g. 0.5 QAR"></td>
                </tr>

                <!-- ── Landing Page ──────────────────────────────────────── -->
                <tr>
                    <td colspan="3" style="background:#f8f9fa;padding:10px 14px;">
                        <strong style="color:#e53935;font-size:13px;">
                            <i class="fa fa-mobile"></i> Landing Page Must Include
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>11.</strong></td>
                    <td>Subscribe Button</td>
                    <td><input name="subscribebutton" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>12.</strong></td>
                    <td>Service Name</td>
                    <td><input name="servicename" class="form-control" type="text" required placeholder="e.g. GameBar"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>13.</strong></td>
                    <td>Price Point on Landing</td>
                    <td><input name="pricepointonlanding" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>14.</strong></td>
                    <td>Service Terms and Conditions</td>
                    <td><input name="servicetnc" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>15.</strong></td>
                    <td>Opening the MDN entry page / HE page / Landing page</td>
                    <td><input name="openinglp" class="form-control" type="text" required placeholder="MDN / HE / LP"></td>
                </tr>

                <!-- ── Consent Page ──────────────────────────────────────── -->
                <tr>
                    <td colspan="3" style="background:#f8f9fa;padding:10px 14px;">
                        <strong style="color:#e53935;font-size:13px;">
                            <i class="fa fa-shield"></i> Consent Page
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>16.</strong></td>
                    <td>Redirecting to Consent page — handled by Operator or Pin Page handled by us</td>
                    <td><input name="consenthandle" class="form-control" type="text" required placeholder="Operator / Us"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>17.</strong></td>
                    <td>Is the sub getting activated properly &amp; captured in the reporting tool?</td>
                    <td><input name="activatedsuccessfully" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>18.</strong></td>
                    <td>Are we getting activation callback &amp; amount in the success callback?</td>
                    <td><input name="activationcallbackwithamount" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>19.</strong></td>
                    <td>Are we getting fallbacks in the activation callback?</td>
                    <td><input name="fallbackinactivationcallback" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>20.</strong></td>
                    <td>How many retries are there in the activation of a subscriber?</td>
                    <td><input name="retriesoftheactivation" class="form-control" type="text" required placeholder="e.g. 3"></td>
                </tr>

                <!-- ── Unsub Flow ─────────────────────────────────────────── -->
                <tr>
                    <td colspan="3" style="background:#f8f9fa;padding:10px 14px;">
                        <strong style="color:#e53935;font-size:13px;">
                            <i class="fa fa-sign-out"></i> Unsub Flow
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>21.</strong></td>
                    <td>User is able to Unsub the service</td>
                    <td><input name="unsubbyuser" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>22.</strong></td>
                    <td>Is the churn captured correctly &amp; getting in the reporting tool?</td>
                    <td><input name="unsubinreport" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>

                <!-- ── Renewal Flow ───────────────────────────────────────── -->
                <tr>
                    <td colspan="3" style="background:#f8f9fa;padding:10px 14px;">
                        <strong style="color:#e53935;font-size:13px;">
                            <i class="fa fa-refresh"></i> Renewal Flow
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>23.</strong></td>
                    <td>Are we getting the renewal of the subscriber?</td>
                    <td><input name="renewalgetting" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>24.</strong></td>
                    <td>Are we getting fallbacks in the renewal?</td>
                    <td><input name="fallbackinrenewal" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>25.</strong></td>
                    <td>Amount of fallbacks in the renewal</td>
                    <td><input name="renfallbackamount" class="form-control" type="text" required placeholder="e.g. 0.5 QAR"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>26.</strong></td>
                    <td>How many retries are there in the renewal of a subscriber?</td>
                    <td><input name="daysforrenewal" class="form-control" type="text" required placeholder="e.g. 3"></td>
                </tr>

                <!-- ── Content Flow ───────────────────────────────────────── -->
                <tr>
                    <td colspan="3" style="background:#f8f9fa;padding:10px 14px;">
                        <strong style="color:#e53935;font-size:13px;">
                            <i class="fa fa-gamepad"></i> Content Flow
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>27.</strong></td>
                    <td>Are we directing the user to the content page?</td>
                    <td><input name="directcontentpage" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>28.</strong></td>
                    <td>Is the user able to download the games?</td>
                    <td><input name="downloadcontentbyuser" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>29.</strong></td>
                    <td>New portal is being displayed to the user</td>
                    <td><input name="newportal" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>

                <!-- ── Callbacks ──────────────────────────────────────────── -->
                <tr>
                    <td colspan="3" style="background:#f8f9fa;padding:10px 14px;">
                        <strong style="color:#e53935;font-size:13px;">
                            <i class="fa fa-bell"></i> Call-backs
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>30.</strong></td>
                    <td>Is the callback being sent to the publisher?</td>
                    <td><input name="callbacksent" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>31.</strong></td>
                    <td>Have you placed the geo in reporting tool? (Activation, Perform, Trend &amp; Last Activity)</td>
                    <td><input name="completereport" class="form-control" type="text" required placeholder="Yes / No"></td>
                </tr>

                </tbody>
            </table>

            <div style="margin-top:16px;">
                <button type="submit" id="uat-submit-btn" class="btn btn-primary">
                    <i class="fa fa-save"></i> Submit UAT Record
                </button>
                <button type="reset" class="btn btn-default" style="margin-left:8px;">
                    <i class="fa fa-times"></i> Clear Form
                </button>
            </div>

        </form>
    </div>
</div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {

    $('#adduat-form').on('submit', function (e) {
        e.preventDefault();

        // Trigger native browser validation UI
        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        var $btn = $('#uat-submit-btn');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        $('#uat-alert').hide();

        $.post('ajax/handler.php', $(this).serialize() + '&action=uat_add', function (res) {
            if (res.ok) {
                $('#uat-alert')
                    .removeClass('alert-danger').addClass('alert alert-success')
                    .html('<i class="fa fa-check-circle"></i> <strong>' + res.msg + '</strong>')
                    .show();
                $('#adduat-form')[0].reset();
                $('html, body').animate({ scrollTop: 0 }, 400);
            } else {
                $('#uat-alert')
                    .removeClass('alert-success').addClass('alert alert-danger')
                    .html('<i class="fa fa-exclamation-circle"></i> <strong>Save failed:</strong> ' + (res.msg || 'Unknown error.'))
                    .show();
            }
        }, 'json')
        .fail(function () {
            $('#uat-alert')
                .removeClass('alert-success').addClass('alert alert-danger')
                .html('<i class="fa fa-exclamation-circle"></i> <strong>Request failed.</strong> Please try again.')
                .show();
        })
        .always(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Submit UAT Record');
        });
    });

});
</script>
