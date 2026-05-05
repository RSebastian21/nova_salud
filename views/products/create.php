<h1 class="h3 mb-3">Nuevo producto</h1>

<div class="panel-card">
    <div class="card-body p-4">
        <form method="post" action="<?= url('products/store') ?>" class="ajax-product-form">
            <?php require __DIR__ . '/form.php'; ?>
            <button type="submit" class="btn btn-success btn-loading">
                <span class="btn-text"><i class="bi bi-check2-circle"></i> Guardar</span>
                <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
            </button>
            <a class="btn btn-secondary" href="<?= url('products') ?>">Cancelar</a>
        </form>
    </div>
</div>