<?php
echo "<h2>Database Connection Check</h2>";

require_once 'bootstrap.php';

// Define HANDLERS_PATH constant
require_once HANDLERS_PATH . 'mongodbChecker.handler.php';
require_once HANDLERS_PATH . 'postgreChecker.handler.php';
?>