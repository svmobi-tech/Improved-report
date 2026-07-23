<?php
require_once __DIR__ . '/config.php';

define('TRUSTED_DEVICE_LIMIT', 5);      // ek user ke max 5 trusted devices
define('TRUSTED_DEVICE_DAYS', 90);      // kitne din tak device trusted rahega
define('TRUSTED_DEVICE_TABLE', 'gamebardb_vodafone_qatar_report.trusted_devices');

// ─── Naya trusted device register karo ───────────────────────────────────────
function register_trusted_device(mysqli $con, int $userid, string $device_label = ''): bool {
    $table = TRUSTED_DEVICE_TABLE;

    // 1. Purane expired tokens saaf karo
    $stmt = $con->prepare("DELETE FROM {$table} WHERE user_id=? AND expires_at < NOW()");
    if (!$stmt) return false;
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->close();

    // 2. Limit check — sabse purana hata do agar limit cross ho rahi ho
    $stmt = $con->prepare("SELECT COUNT(*) AS c FROM {$table} WHERE user_id=?");
    if (!$stmt) return false;
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $res   = $stmt->get_result();
    $count = $res ? (int)($res->fetch_assoc()['c'] ?? 0) : 0;
    $stmt->close();

    if ($count >= TRUSTED_DEVICE_LIMIT) {
        $stmt = $con->prepare("DELETE FROM {$table} WHERE user_id=? ORDER BY created_at ASC LIMIT 1");
        if (!$stmt) return false;
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $stmt->close();
    }

    // 3. Token generate karo
    $selector  = bin2hex(random_bytes(9));   // 18 chars — fits varchar(24)
    $validator = bin2hex(random_bytes(32));  // 64 chars — kabhi DB mein plain store nahi hota
    $hash      = password_hash($validator, PASSWORD_DEFAULT);
    $expires   = date('Y-m-d H:i:s', time() + TRUSTED_DEVICE_DAYS * 86400);

    // device_label: User-Agent truncate karo (col is varchar(100))
    $raw_label = $device_label ?: ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown');
    $label     = mb_substr($raw_label, 0, 100);

    // 4. DB mein row insert karo
    $stmt = $con->prepare(
        "INSERT INTO {$table} (user_id, selector, validator_hash, device_label, created_at, expires_at)
         VALUES (?, ?, ?, ?, NOW(), ?)"
    );
    if (!$stmt) return false;

    $stmt->bind_param('issss', $userid, $selector, $hash, $label, $expires);
    $ok = $stmt->execute();
    $stmt->close();

    if (!$ok) return false;   // INSERT failed — cookie set mat karo

    // 5. Sirf tab cookie set karo jab DB row confirm ho gaya
    setcookie('trusted_device', $selector . ':' . $validator, [
        'expires'  => time() + TRUSTED_DEVICE_DAYS * 86400,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    return true;
}

// ─── Cookie validate karo aur agar valid ho to userid return karo ────────────
function check_trusted_device(mysqli $con): ?array {
    if (empty($_COOKIE['trusted_device'])) return null;

    $parts = explode(':', $_COOKIE['trusted_device'], 2);
    if (count($parts) !== 2) return null;
    [$selector, $validator] = $parts;

    $table = TRUSTED_DEVICE_TABLE;
    $stmt  = $con->prepare(
        "SELECT * FROM {$table} WHERE selector=? AND expires_at > NOW() LIMIT 1"
    );
    if (!$stmt) return null;
    $stmt->bind_param('s', $selector);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
    $stmt->close();
    if (!$row) return null;

    if (!password_verify($validator, $row['validator_hash'])) return null;

    // Valid — last_used_at update karo
    $stmt = $con->prepare("UPDATE {$table} SET last_used_at=NOW() WHERE id=?");
    if ($stmt) {
        $stmt->bind_param('i', $row['id']);
        $stmt->execute();
        $stmt->close();
    }

    return ['userid' => (int)$row['user_id']];
}

// ─── Logout par trusted device revoke karo ───────────────────────────────────
function revoke_trusted_device(mysqli $con): void {
    if (empty($_COOKIE['trusted_device'])) return;

    [$selector] = explode(':', $_COOKIE['trusted_device'], 2);
    $table = TRUSTED_DEVICE_TABLE;
    $stmt  = $con->prepare("DELETE FROM {$table} WHERE selector=?");
    if ($stmt) {
        $stmt->bind_param('s', $selector);
        $stmt->execute();
        $stmt->close();
    }
    setcookie('trusted_device', '', [
        'expires'  => time() - 3600,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}
