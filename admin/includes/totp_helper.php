<?php
// Pure PHP TOTP (RFC 6238) — no Composer, no external library.

function totp_generate_secret(): string {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $s = '';
    for ($i = 0; $i < 16; $i++) $s .= $chars[random_int(0, 31)];
    return $s;
}

function totp_verify(string $secret, string $code): bool {
    // Check current step and ±1 window to tolerate clock drift
    for ($d = -1; $d <= 1; $d++) {
        if (hash_equals(totp_code($secret, $d), $code)) return true;
    }
    return false;
}

function totp_code(string $secret, int $drift = 0): string {
    $t    = floor(time() / 30) + $drift;
    $key  = _totp_b32decode($secret);
    $bin  = pack('N*', 0) . pack('N*', $t);
    $hash = hash_hmac('sha1', $bin, $key, true);
    $off  = ord($hash[19]) & 0xf;
    $code = (
        ((ord($hash[$off])   & 0x7f) << 24) |
        ((ord($hash[$off+1]) & 0xff) << 16) |
        ((ord($hash[$off+2]) & 0xff) <<  8) |
         (ord($hash[$off+3]) & 0xff)
    ) % 1000000;
    return str_pad($code, 6, '0', STR_PAD_LEFT);
}

function totp_qr_uri(string $secret, string $user, string $issuer = 'SVMobi'): string {
    return 'otpauth://totp/' . rawurlencode($issuer . ':' . $user)
         . '?secret=' . $secret
         . '&issuer=' . rawurlencode($issuer)
         . '&algorithm=SHA1&digits=6&period=30';
}

function _totp_b32decode(string $s): string {
    $map  = array_flip(str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ234567'));
    $s    = strtoupper($s);
    $out  = '';
    $bits = 0;
    $acc  = 0;
    foreach (str_split($s) as $c) {
        if (!isset($map[$c])) continue;
        $acc = ($acc << 5) | $map[$c];
        $bits += 5;
        if ($bits >= 8) {
            $bits -= 8;
            $out  .= chr(($acc >> $bits) & 0xff);
        }
    }
    return $out;
}
