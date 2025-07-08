<?php
declare(strict_types=1);

// Ensure correct base path
require_once dirname(__DIR__) . '/bootstrap.php';
require_once VENDOR_PATH . 'autoload.php';
require_once UTILS_PATH . 'envSetter.util.php';
require_once UTILS_PATH . 'auth.util.php';

// Start session
Auth::init();

// Setup DB connection
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// Handle login
$action = $_REQUEST['action'] ?? null;

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameInput = trim($_POST['username'] ?? '');
    $passwordInput = trim($_POST['password'] ?? '');

    if (Auth::login($pdo, $usernameInput, $passwordInput)) {
        $user = Auth::user();
        error_log("[auth.handler.php] ✅ Login successful for user_id={$user['id']}");
        header('Location: /pages/login/index.php'); // ✅ Adjust to your success page
        exit;
    } else {
        error_log("[auth.handler.php] ❌ Login failed for username='{$usernameInput}'");
        header('Location: /index.php?error=Invalid%20Credentials');
        exit;
    }
}

// Handle logout
if ($action === 'logout') {
    Auth::logout();
    header('Location: /index.php');
    exit;
}
