<?php
declare(strict_types=1);

// Setup
require_once 'bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';
require_once UTILS_PATH . 'envSetter.util.php';
require_once HANDLERS_PATH . 'mongodbChecker.handler.php';
require_once HANDLERS_PATH . 'postgreChecker.handler.php';

Auth::init();

// Handle login error display
$error = trim((string) ($_GET['error'] ?? ''));
$error = str_replace("%", " ", $error);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Meeting Calendar - Login</title>
    <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
    <h2>🔐 Log In to Meeting Calendar</h2>

    <form action="/handlers/auth.handler.php" method="POST">
        <label for="username" class="label">Username</label>
        <input id="username" name="username" type="text" required class="input" />

        <label for="password" class="label">Password</label>
        <input id="password" name="password" type="password" required class="input" />

        <input type="hidden" name="action" value="login" />
        <button type="submit" class="button">Log In</button>

        <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
    </form>

    <hr />

</body>
</html>
