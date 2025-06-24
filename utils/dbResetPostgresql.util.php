<?php
declare(strict_types=1);

// 1) Composer autoload
require 'vendor/autoload.php';

// 2) Bootstrap (defines BASE_PATH, UTILS_PATH, etc.)
require 'bootstrap.php';

// 3) Load environment variables and database config
require_once UTILS_PATH . 'envSetter.util.php';

// ——— Connect to PostgreSQL ———
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// ——— Apply SQL schema files in correct order ———
$schemas = [
    'users.model.sql',
    'meetings.model.sql',
    'meeting_users.model.sql',
    'tasks.model.sql'
];

echo "🚀 Applying schema files...\n";

foreach ($schemas as $schemaFile) {
    $path = BASE_PATH . "/database/{$schemaFile}";
    echo "📄 Applying schema from {$path}...\n";
    
    $sql = file_get_contents($path);
    if ($sql === false) {
        throw new RuntimeException("❌ Could not read {$path}");
    }

    $pdo->exec($sql);
    echo "✅ Applied {$schemaFile}\n";
}

// ——— Truncate tables for a clean reset ———
echo "🧹 Truncating tables…\n";
foreach (['meeting_users', 'tasks', 'meetings', 'users'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}
echo "✅ Tables truncated and reset successfully.\n";
