<?php
// ── TOTP Secret Generator ──────────────────────────────────────────
// Use this page to generate a secret, add it to Google Authenticator,
// then run the shown SQL in phpMyAdmin. Delete this file after setup.
// ──────────────────────────────────────────────────────────────────

require_once 'includes/totp_helper.php';

// Generate once per session
session_start();
if (empty($_SESSION['gen_secret'])) {
    $_SESSION['gen_secret'] = totp_generate_secret();
}
$secret   = $_SESSION['gen_secret'];
$username = $_GET['user'] ?? 'durgesh'; // pass ?user=Mehul to generate for other users
$qr_uri   = totp_qr_uri($secret, $username);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>TOTP Secret Generator</title>
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <style>
    body { background:#f4f7fb; font-family:sans-serif; padding:30px; }
    .box { max-width:560px; margin:0 auto; background:#fff; border-radius:10px;
           padding:30px; box-shadow:0 2px 16px rgba(0,0,0,0.10); }
    h2 { color:#667eea; margin-bottom:4px; }
    .step { background:#f8f9ff; border-left:4px solid #667eea; padding:12px 16px;
            border-radius:0 6px 6px 0; margin:14px 0; font-size:14px; }
    .step strong { display:block; margin-bottom:4px; color:#333; }
    .secret-val { font-family:monospace; font-size:18px; letter-spacing:3px;
                  background:#eef2ff; padding:10px 16px; border-radius:6px;
                  display:inline-block; color:#3730a3; word-break:break-all; }
    .sql-box { background:#1e1e2e; color:#a6da95; font-family:monospace;
               font-size:13px; padding:14px; border-radius:6px; word-break:break-all;
               white-space:pre-wrap; margin:8px 0; }
    .warn { background:#fff3cd; border:1px solid #ffc107; color:#856404;
            padding:10px 14px; border-radius:6px; font-size:13px; margin-top:20px; }
    .btn-regen { background:#667eea; color:#fff; border:none; padding:8px 18px;
                 border-radius:6px; cursor:pointer; font-size:13px; margin-top:10px; }
    .btn-regen:hover { background:#5a6fd6; }
  </style>
</head>
<body>
<div class="box">
  <h2><i class="fa fa-shield"></i> TOTP Secret Generator</h2>
  <p style="color:#888;font-size:13px">For user: <strong><?php echo htmlspecialchars($username); ?></strong>
    &nbsp;|&nbsp;
    <a href="?user=Mehul">Mehul</a> &nbsp;
    <a href="?user=durgesh">durgesh</a> &nbsp;
    <a href="?user=admin">admin</a>
  </p>

  <!-- Step 1: Secret key -->
  <div class="step">
    <strong>Step 1 — Your Secret Key</strong>
    <div class="secret-val"><?php echo htmlspecialchars($secret); ?></div>
  </div>

  <!-- Step 2: QR Code -->
  <div class="step">
    <strong>Step 2 — Scan QR Code in Google Authenticator</strong>
    <div style="text-align:center;margin:10px 0">
      <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?php echo rawurlencode($qr_uri); ?>"
           alt="QR Code" width="220" height="220"
           style="border:6px solid #fff;box-shadow:0 2px 10px rgba(0,0,0,0.15);border-radius:6px"
           onerror="this.style.display='none';document.getElementById('qf').style.display='block'">
      <div id="qf" style="display:none;color:#856404;background:#fff3cd;padding:10px;border-radius:6px;margin-top:6px;font-size:12px">
        QR image didn't load (no internet). Use manual key above in Google Authenticator.
      </div>
    </div>
    <p style="font-size:12px;color:#888;text-align:center;margin:4px 0">
      Google Authenticator → <b>+</b> → <b>Scan QR code</b><br>
      OR <b>Enter a setup key</b> → paste the key above
    </p>
  </div>

  <!-- Step 3: SQL -->
  <div class="step">
    <strong>Step 3 — Run this SQL in phpMyAdmin</strong>
    <div class="sql-box">UPDATE gamebardb_vodafone_qatar_report.login
SET totp_secret='<?php echo $secret; ?>'
WHERE username='<?php echo htmlspecialchars($username); ?>';</div>
    <p style="font-size:12px;color:#888;margin:6px 0 0">
      phpMyAdmin → SQL tab → paste → Go
    </p>
  </div>

  <!-- Step 4 -->
  <div class="step">
    <strong>Step 4 — Test Login</strong>
    <p style="margin:0;font-size:13px">
      Go to <a href="login.php">login.php</a> → enter username &amp; password →
      enter the 6-digit code from Google Authenticator → done ✓
    </p>
  </div>

  <form method="get" style="margin-top:4px">
    <input type="hidden" name="user" value="<?php echo htmlspecialchars($username); ?>">
    <input type="hidden" name="regen" value="1">
    <button type="submit" class="btn-regen" onclick="<?php
      if (isset($_GET['regen'])) unset($_SESSION['gen_secret']);
    ?>">
      <i class="fa fa-refresh"></i> Generate New Secret
    </button>
  </form>

  <div class="warn">
    <i class="fa fa-exclamation-triangle"></i>
    <strong>Delete this file after setup!</strong>
    This page has no authentication. Remove <code>gen_totp.php</code> once all users are enrolled.
  </div>
</div>

<?php
// Handle regenerate
if (isset($_GET['regen'])) {
    unset($_SESSION['gen_secret']);
    header('Location: gen_totp.php?user=' . urlencode($username)); exit;
}
?>
</body>
</html>
