<?php
require_once dirname(__DIR__, 2) . '/utils/auth.util.php';
Auth::init();
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
  <h1>✅ Welcome, <?= htmlspecialchars($user['full_name']) ?>!</h1>
  <p>You are logged in as <strong><?= htmlspecialchars($user['role']) ?></strong> from <strong><?= htmlspecialchars($user['group_name']) ?></strong> group.</p>

  <form action="/handlers/auth.handler.php?action=logout" method="POST">
    <button type="submit">Logout</button>
  </form>
</body>
</html>