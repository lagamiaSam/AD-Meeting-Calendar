<?php
require_once VENDOR_PATH . 'autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Mongo config from .env
$mongoConfig = [
    'uri' => $_ENV['MONGO_URI'],
];

// PostgreSQL config from .env
$pgConfig = [
    'host' => $_ENV['PG_HOST'],
    'port' => $_ENV['PG_PORT'],
    'user' => $_ENV['PG_USER'],
    'pass' => $_ENV['PG_PASS'],
    'db'   => $_ENV['PG_DB'],
];
