<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
date_default_timezone_set("Asia/Calcutta");

require_once 'includes/config.php';
require_once 'includes/totp_helper.php';
require_once 'includes/device_trust.php';

if (empty($_SESSION['2fa_setup'])) {
    header('Location: login.php'); exit;
}

$error   = '';
$success = '';

// Generate a temp secret once per setup session
if (empty($_SESSION['2fa_temp_secret'])) {
    $_SESSION['2fa_temp_secret'] = totp_generate_secret();
}

$secret   = $_SESSION['2fa_temp_secret'];
$username = $_SESSION['2fa_username'] ?? 'admin';
$qr_uri   = totp_qr_uri($secret, $username);

// Verify confirmation code and save
if (isset($_POST['otp'])) {
    $entered = preg_replace('/\D/', '', trim($_POST['otp'] ?? ''));
    if (strlen($entered) !== 6) {
        $error = 'Please enter the 6-digit code shown in your authenticator app.';
    } elseif (totp_verify($secret, $entered)) {
        // Save secret to DB
        $stmt = $con->prepare('UPDATE login SET totp_secret=? WHERE userid=?');
        $stmt->bind_param('si', $secret, $_SESSION['2fa_userid']);
        $stmt->execute();
        $stmt->close();

        // Complete login
        $_SESSION['userid']   = $_SESSION['2fa_userid'];
        $_SESSION['admin']    = $_SESSION['2fa_admin'];
        $_SESSION['username'] = $_SESSION['2fa_username'];
        if (!empty($_SESSION['2fa_trust_device'])) {
            register_trusted_device($con, (int) $_SESSION['userid']);
        }
        unset($_SESSION['2fa_setup'], $_SESSION['2fa_temp_secret'], $_SESSION['2fa_trust_device'],
              $_SESSION['2fa_userid'], $_SESSION['2fa_admin'], $_SESSION['2fa_username']);

        header('Location: dashboard.php'); exit;
    } else {
        $error = 'Invalid code. Please wait for the next 6-digit code and try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Setup Two-Factor Authentication</title>
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <style>
    .setup-steps { text-align:left; font-size:13px; color:#555; padding:0 10px; margin-bottom:14px; }
    .setup-steps li { margin-bottom:6px; }
    .secret-box {
      font-family: monospace; font-size:13px; background:#f4f4f4;
      border:1px solid #ddd; border-radius:4px; padding:6px 10px;
      word-break:break-all; margin:8px 0 14px; text-align:center; letter-spacing:2px;
    }
    .otp-input {
      font-size:22px; letter-spacing:8px; text-align:center;
      width:160px; margin:0 auto 14px; display:block; border-radius:6px;
    }
    .app-badges { margin:10px 0; }
    .app-badge {
      display:inline-block; background:#f0f0f0; border:1px solid #ddd;
      border-radius:4px; padding:3px 10px; font-size:11px; color:#555; margin:2px;
    }
  </style>
</head>
<body style="background:#F7F7F7;">
<div class="">
  <div id="wrapper">
    <div id="login" class="form" style="width:420px;">
      <section class="login_content">
        <h1><i class="fa fa-shield" style="color:#667eea"></i> Setup 2FA</h1>

        <?php if ($error): ?>
        <div class="alert alert-danger" style="margin-bottom:10px"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <p style="font-size:12px;color:#777;margin-bottom:10px">
          Scan this QR code with your authenticator app, then enter the 6-digit code to activate.
        </p>

        <div class="app-badges">
          <span class="app-badge"><i class="fa fa-mobile"></i> Google Authenticator</span>
          <span class="app-badge"><i class="fa fa-mobile"></i> Authy</span>
          <span class="app-badge"><i class="fa fa-mobile"></i> Microsoft Authenticator</span>
        </div>

        <!-- QR Code image via QR Server API -->
        <div style="text-align:center;margin:14px 0 8px">
          <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo rawurlencode($qr_uri); ?>"
               alt="QR Code" width="200" height="200"
               style="border:4px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.12);border-radius:6px"
               onerror="this.style.display='none';document.getElementById('qr-fallback').style.display='block'">
          <div id="qr-fallback" style="display:none;padding:10px;background:#fff3cd;border-radius:6px;font-size:12px;color:#856404">
            <i class="fa fa-exclamation-triangle"></i> QR code image could not load.<br>Use the manual key below.
          </div>
        </div>

        <!-- Manual key fallback -->
        <p style="font-size:11px;color:#888;text-align:center;margin-bottom:2px">
          Can't scan? Enter this key manually in your app:
        </p>
        <div class="secret-box"><?php echo htmlspecialchars($secret); ?></div>

        <!-- Confirmation form -->
        <form method="post">
          <ol class="setup-steps">
            <li>Open your authenticator app</li>
            <li>Tap <strong>+</strong> → <em>Scan QR code</em> (or <em>Enter key manually</em>)</li>
            <li>Enter the 6-digit code shown below</li>
          </ol>
          <input type="text" name="otp" class="form-control otp-input"
                 placeholder="000000" maxlength="6" pattern="\d{6}"
                 inputmode="numeric" autocomplete="one-time-code" required>
          <div>
            <input type="submit" value="Activate 2FA" class="btn btn-default submit" style="width:100%">
          </div>
        </form>

        <div class="clearfix"></div>
        <div class="separator" style="margin-top:14px">
          <p style="font-size:11px;color:#aaa;text-align:center">
            <i class="fa fa-lock"></i> Keep your authenticator app safe.<br>
            If you lose access, ask your admin to reset your 2FA.
          </p>
        </div>
      </section>
    </div>
  </div>
</div>
</body>
</html>
