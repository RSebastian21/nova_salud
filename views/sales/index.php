<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Ventas</h1>
    <a class="btn btn-success" href="<?= url('sales/create') ?>">Nueva venta</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sales ?? [] as $sale): ?>
                <tr>
                    <td><?= (int) $sale['id'] ?></td>
                    <td><?= e($sale['user_name']) ?></td>
                    <td>S/ <?= money($sale['total']) ?></td>
                    <td><?= e($sale['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($sales ?? []) === 0): ?>
                <tr><td colspan="4" class="text-center text-muted">Sin ventas registradas</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

