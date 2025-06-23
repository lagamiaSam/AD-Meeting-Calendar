<?php
echo "<h2>Database Connection Check</h2>";

require_once 'bootstrap.php';

// Define HANDLERS_PATH constant
define('HANDLERS_PATH', __DIR__ . '/handlers/');

require_once HANDLERS_PATH . 'mongodbChecker.handler.php';
require_once HANDLERS_PATH . 'postgreChecker.handler.php';
?>