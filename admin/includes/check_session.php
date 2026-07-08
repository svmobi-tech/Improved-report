<?php
error_reporting(0);
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/device_trust.php';

if (empty($_SESSION['userid']) && empty($_SESSION['2fa_pending']) && empty($_SESSION['2fa_setup'])) {
    // Session nahi hai — trusted device cookie check karo
    $device = check_trusted_device($con);
    if ($device) {
        $stmt = $con->prepare('SELECT userid, username, admin FROM gamebardb_vodafone_qatar_report.login WHERE userid=?');
        $stmt->bind_param('i', $device['userid']);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if ($user) {
            $_SESSION['userid']   = $user['userid'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin']    = $user['admin'];
        }
    }
}

if (!empty($_SESSION['2fa_pending']) && empty($_SESSION['userid'])) {
    header('Location: otp_verify.php'); exit;
}
if (!empty($_SESSION['2fa_setup']) && empty($_SESSION['userid'])) {
    header('Location: totp_setup.php'); exit;
}
if (empty($_SESSION['userid'])) {
    header('Location: login.php'); exit;
}
?>
