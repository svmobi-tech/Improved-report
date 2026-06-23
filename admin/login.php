<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
date_default_timezone_set("Asia/Calcutta");

require_once 'includes/config.php';
/** @var mysqli $con */
require_once 'includes/totp_helper.php';

$error = '';

if (!empty($_SESSION['userid'])) {
    header('Location: dashboard.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
    session_start();
}

if (isset($_POST['submit'])) {
    $username    = trim($_POST['username'] ?? '');
    $password    = trim($_POST['password'] ?? '');
    $userid      = null;
    $admin       = null;
    $totp_secret = null;

    $stmt = $con->prepare(
        'SELECT userid, admin, totp_secret FROM login WHERE username=? AND password=?'
    );
    if ($stmt === false) {
        $error = 'Database error. Please contact administrator.';
    } else {
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $stmt->bind_result($userid, $admin, $totp_secret);
        $stmt->fetch();
        $stmt->close();

        if (!empty($userid)) {
            $_SESSION['2fa_userid']   = $userid;
            $_SESSION['2fa_admin']    = $admin;
            $_SESSION['2fa_username'] = $username;

            if (empty($totp_secret)) {
                $_SESSION['2fa_setup'] = true;
                header('Location: totp_setup.php'); exit;
            } else {
                $_SESSION['2fa_pending'] = true;
                $_SESSION['2fa_secret']  = $totp_secret;
                header('Location: otp_verify.php'); exit;
            }
        } else {
            $error = 'Username or password is incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SVMobi Reports — Login</title>
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/auth.css" rel="stylesheet">
</head>
<body>

  <div class="card">

    <!-- Logo + brand -->
    <div class="card-logo-wrap">
      <img src="images/logo.png" alt="SVMobi" class="card-logo"
           onerror="this.style.display='none'">
      <span class="card-brand-label">SVMobi Reports</span>
    </div>

    <!-- Heading -->
    <h1 class="card-title">Welcome back</h1>
    <p class="card-sub">Sign in to continue to your account.</p>

    <!-- Error -->
    <?php if ($error): ?>
    <div class="err">
      <i class="fa fa-exclamation-circle"></i>
      <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="post" autocomplete="off" novalidate>

      <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username"
               placeholder="Enter your username" required autofocus
               value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
      </div>

      <div class="field">
        <label for="password">Password</label>
        <div class="pw-wrap">
          <input type="password" id="password" name="password"
                 placeholder="Enter your password" required>
          <button type="button" class="pw-eye" onclick="togglePw(this)" aria-label="Toggle password">
            <i class="fa fa-eye"></i>
          </button>
        </div>
      </div>

      <button type="submit" name="submit" class="btn">Sign In</button>

    </form>

    <!-- Footer -->
    <div class="note">
      <i class="fa fa-shield"></i>
      Secured with Two-Factor Authentication (2FA)
    </div>

  </div>

<script>
function togglePw(btn) {
  var inp  = btn.closest('.pw-wrap').querySelector('input');
  var icon = btn.querySelector('i');
  if (inp.type === 'password') {
    inp.type = 'text';
    icon.className = 'fa fa-eye-slash';
  } else {
    inp.type = 'password';
    icon.className = 'fa fa-eye';
  }
}
</script>
</body>
</html>
