<?php
session_start();
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

require_once 'includes/config.php';
require_once 'includes/totp_helper.php';
require_once 'includes/device_trust.php';

if (isset($_GET['cancel'])) {
    session_unset();
    session_destroy();
    header('Location: login.php'); exit;
}

if (empty($_SESSION['2fa_pending'])) {
    header('Location: login.php'); exit;
}

$error = '';

if (isset($_POST['otp'])) {
    $entered = preg_replace('/\D/', '', trim($_POST['otp'] ?? ''));
    if (strlen($entered) !== 6) {
        $error = 'Please enter the complete 6-digit code from your authenticator app.';
    } elseif (totp_verify($_SESSION['2fa_secret'], $entered)) {
        $_SESSION['userid']   = $_SESSION['2fa_userid'];
        $_SESSION['admin']    = $_SESSION['2fa_admin'];
        $_SESSION['username'] = $_SESSION['2fa_username'];
        if (!empty($_SESSION['2fa_trust_device'])) {
            register_trusted_device($con, (int) $_SESSION['userid']);
        }
        unset($_SESSION['2fa_pending'], $_SESSION['2fa_secret'], $_SESSION['2fa_trust_device'],
              $_SESSION['2fa_userid'], $_SESSION['2fa_admin'], $_SESSION['2fa_username']);
        header('Location: dashboard.php'); exit;
    } else {
        $error = 'Invalid code. Please wait for the next code and try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SVMobi — 2FA Verification</title>
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/auth.css" rel="stylesheet">
</head>
<body>

  <div class="card">

    <!-- Logo -->
    <div class="card-logo-wrap">
      <img src="images/logo.png" alt="SVMobi" class="card-logo"
           onerror="this.style.display='none'">
      <span class="card-brand-label">SVMobi Reports</span>
    </div>

    <!-- Shield icon -->
    <div class="shield-wrap">
      <i class="fa fa-shield"></i>
    </div>

    <!-- Heading -->
    <h1 class="card-title">2FA Verification</h1>
    <p class="card-sub">
      Open <strong>Google Authenticator</strong> or <strong>Authy</strong><br>
      and enter the 6-digit code for SVMobi.
    </p>

    <!-- Error -->
    <?php if ($error): ?>
    <div class="err">
      <i class="fa fa-exclamation-circle"></i>
      <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="post" autocomplete="off" id="otpForm">
      <input type="hidden" name="otp" id="otp-real">

      <!-- 6 digit boxes -->
      <div class="otp-row" id="otpRow">
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]" autocomplete="one-time-code">
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]">
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]">
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]">
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]">
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]">
      </div>

      <!-- Timer -->
      <div class="timer-hint">
        <i class="fa fa-refresh"></i>
        Code refreshes in <span class="timer-num" id="timerNum">30</span>s
      </div>

      <button type="submit" class="btn" id="verifyBtn">
        <i class="fa fa-check-circle"></i>&nbsp; Verify
      </button>
    </form>

    <a href="otp_verify.php?cancel=1" class="back-link">
      <i class="fa fa-arrow-left"></i> Back to Login
    </a>

  </div>

<script>
(function () {
  var boxes = document.querySelectorAll('.otp-box');
  var real  = document.getElementById('otp-real');
  var form  = document.getElementById('otpForm');

  function sync() {
    var val = '';
    boxes.forEach(function (b) { val += b.value; });
    real.value = val;
    boxes.forEach(function (b) {
      b.classList.toggle('filled', b.value !== '');
    });
  }

  boxes.forEach(function (box, i) {
    box.addEventListener('input', function (e) {
      var v = box.value.replace(/\D/g, '');
      box.value = v ? v[v.length - 1] : '';
      sync();
      if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
    });

    box.addEventListener('keydown', function (e) {
      if (e.key === 'Backspace') {
        if (!box.value && i > 0) {
          boxes[i - 1].value = '';
          boxes[i - 1].focus();
          sync();
        }
      } else if (e.key === 'ArrowLeft' && i > 0) {
        boxes[i - 1].focus();
      } else if (e.key === 'ArrowRight' && i < boxes.length - 1) {
        boxes[i + 1].focus();
      }
    });

    /* paste support */
    box.addEventListener('paste', function (e) {
      e.preventDefault();
      var pasted = (e.clipboardData || window.clipboardData)
                    .getData('text').replace(/\D/g, '').slice(0, 6);
      pasted.split('').forEach(function (ch, j) {
        if (boxes[j]) boxes[j].value = ch;
      });
      sync();
      var next = Math.min(pasted.length, boxes.length - 1);
      boxes[next].focus();
    });
  });

  /* auto-submit when all 6 filled */
  form.addEventListener('input', function () {
    if (real.value.length === 6) form.submit();
  });

  /* focus first empty box on load */
  boxes[0].focus();

  /* 30-second countdown timer (visual only) */
  var timerEl = document.getElementById('timerNum');
  function startTimer() {
    var sec = 30 - (Math.floor(Date.now() / 1000) % 30);
    timerEl.textContent = sec;
    setTimeout(startTimer, 1000);
  }
  startTimer();
})();
</script>
</body>
</html>
