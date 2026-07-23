<?php
// Load .env from project root (two levels up from admin/includes/)
$_envFile = dirname(dirname(__DIR__)) . '/.env';
if (file_exists($_envFile)) {
    foreach (file($_envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $_line) {
        $_line = trim($_line);
        if ($_line === '' || $_line[0] === '#') continue;
        $_parts = explode('=', $_line, 2);
        if (count($_parts) !== 2) continue;
        $key = trim($_parts[0]);
        $val = trim($_parts[1]);
        $_ENV[$key] = $val;
        putenv("$key=$val");
    }
}
unset($_envFile, $_line, $_parts, $key, $val);

define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'gamebardb_vodafone_qatar_report');
define('DB_PORT', $_ENV['DB_PORT'] ?? '3306');
define('DB_PROD_HOST', $_ENV['DB_PROD_HOST'] ?? '10.34.240.214');
define('DB_PROD_PORT', $_ENV['DB_PROD_PORT'] ?? '3306');

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);


$con55 = mysqli_connect(
    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME,
    DB_PORT
);

$con11 = new mysqli(
    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME,
    DB_PORT
);

if ($con->connect_errno) {
    die('Database connection failed: ' . $con->connect_error);
}
