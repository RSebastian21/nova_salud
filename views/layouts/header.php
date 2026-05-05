<?php
$user = Auth::user();
$assetBase = BASE_URL === '' ? '' : BASE_URL;
$flashSuccess = $_SESSION['success'] ?? null;
$flashError = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? APP_NAME) ?> - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= $assetBase ?>/css/style.css" rel="stylesheet">
</head>
<body>
<div id="flash-messages"
     data-success="<?= e((string) $flashSuccess) ?>"
     data-error="<?= e((string) $flashError) ?>"></div>

<?php if ($user): ?>
<div class="app-shell">
    <aside class="app-sidebar">
        <a class="brand" href="<?= url('dashboard') ?>">
            <span class="brand-mark"><i class="bi bi-capsule-pill"></i></span>
            <span><?= APP_NAME ?></span>
        </a>
        <nav class="sidebar-nav">
            <a href="<?= url('dashboard') ?>"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a href="<?= url('products') ?>"><i class="bi bi-box-seam"></i> Productos</a>
            <a href="<?= url('categories') ?>"><i class="bi bi-tags"></i> Categorías</a>
            <a href="<?= url('sales') ?>"><i class="bi bi-receipt"></i> Ventas</a>
        </nav>
    </aside>

    <div class="app-content">
        <header class="topbar">
            <div>
                <span class="eyebrow">Sistema de farmacia</span>
                <h1><?= e($title ?? APP_NAME) ?></h1>
            </div>
            <div class="user-menu">
                <span class="user-avatar"><?= e(strtoupper(substr($user['name'], 0, 1))) ?></span>
                <span class="d-none d-sm-inline"><?= e($user['name']) ?></span>
                <a class="btn btn-outline-secondary btn-sm" href="<?= url('logout') ?>">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>
            </div>
        </header>
        <main class="page fade-in">
<?php else: ?>
    <main class="auth-page fade-in">
<?php endif; ?>