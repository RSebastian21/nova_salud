<?php
$totalProducts = $totalProducts ?? 0;
$totalSales = $totalSales ?? 0;
$totalRevenue = $totalRevenue ?? 0;
$lowStockCount = $lowStockCount ?? 0;
$lowStock = $lowStock ?? [];
?>

<div class="page-heading">
    <div>
        <span class="eyebrow">Operación comercial</span>
        <h2>Panel de Control</h2>
    </div>
    <span class="badge bg-white text-dark border p-2">
        <i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y') ?>
    </span>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <span>Productos</span>
                <strong><?= (int) $totalProducts ?></strong>
            </div>
            <i class="bi bi-box-seam text-primary"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <span>Ventas</span>
                <strong><?= (int) $totalSales ?></strong>
            </div>
            <i class="bi bi-receipt text-success"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <span>Ingresos</span>
                <strong>S/ <?= money($totalRevenue) ?></strong>
            </div>
            <i class="bi bi-cash-stack text-success"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div>
                <span>Bajo stock</span>
                <strong><?= (int) $lowStockCount ?></strong>
            </div>
            <i class="bi bi-exclamation-triangle text-danger"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="panel-card p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="eyebrow">Resumen</span>
                    <h3 class="h5 mb-0">Estado general</h3>
                </div>
                <i class="bi bi-bar-chart fs-3 text-primary"></i>
            </div>
            <div class="mt-4">
                <p class="text-muted mb-3">
                    <i class="bi bi-info-circle me-2"></i>
                    Total de ingresos registrados: <strong>S/ <?= money($totalRevenue) ?></strong>
                </p>
                <p class="text-muted mb-3">
                    <i class="bi bi-receipt me-2"></i>
                    Total de transacciones: <strong><?= (int) $totalSales ?></strong>
                </p>
                <p class="text-muted">
                    <i class="bi bi-box-seam me-2"></i>
                    Productos en catálogo: <strong><?= (int) $totalProducts ?></strong>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="panel-card h-100">
            <div class="p-4 border-bottom d-flex align-items-center justify-content-between">
                <div>
                    <span class="eyebrow">Alertas</span>
                    <h3 class="h5 mb-0">Stock crítico</h3>
                </div>
                <span class="badge rounded-pill text-bg-danger">Menor a 10</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th class="ps-4">Producto</th>
                        <th>Categoría</th>
                        <th class="text-center">Stock</th>
                        <th class="text-end pe-4">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($lowStock as $product): ?>
                        <tr>
                            <td class="ps-4 fw-semibold"><?= e($product['name']) ?></td>
                            <td class="text-muted small"><?= e($product['category_name']) ?></td>
                            <td class="text-center"><span class="badge text-bg-danger"><?= (int) $product['stock'] ?></span></td>
                            <td class="text-end pe-4">
                                <a href="<?= url('products/edit/' . (int) $product['id']) ?>" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-plus-square"></i> Reabastecer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($lowStock) === 0): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-check-circle text-success d-block mb-2 fs-1"></i>
                                No hay alertas de stock pendientes
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>