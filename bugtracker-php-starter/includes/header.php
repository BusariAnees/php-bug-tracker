
<?php require_once __DIR__.'/../config.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h(APP_NAME) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/"><?= h(APP_NAME) ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (!empty($_SESSION['user'])): ?>
        <li class="nav-item"><a class="nav-link" href="/">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="/tickets/create.php">New Ticket</a></li>
        <?php if ($_SESSION['user']['is_admin'] == 1): ?>
        <li class="nav-item"><a class="nav-link" href="/users/index.php">Users</a></li>
        <?php endif; ?>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
        <?php if (empty($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="/register.php">Register</a></li>
        <?php else: ?>
          <li class="nav-item"><span class="navbar-text me-2">Hi, <?= h($_SESSION['user']['name']) ?></span></li>
          <li class="nav-item"><a class="btn btn-sm btn-outline-dark" href="/logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container py-4">
<?php if ($m = flash('success')): ?>
  <div class="alert alert-success"><?= h($m) ?></div>
<?php endif; ?>
<?php if ($m = flash('error')): ?>
  <div class="alert alert-danger"><?= h($m) ?></div>
<?php endif; ?>
