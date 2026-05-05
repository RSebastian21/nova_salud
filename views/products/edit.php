<h1 class="h3 mb-3">Editar producto</h1>

<div class="panel-card">
    <div class="card-body p-4">
        <form method="post" action="<?= url('products/update') ?>" class="ajax-product-form">
            <input type="hidden" name="id" value="<?= isset($product['id']) ? (int) $product['id'] : 0 ?>">
            <?php
            if (!isset($product) || !is_array($product)) {
                $product = [];
            }
            require __DIR__ . '/form.php';
            ?>
            <button type="submit" class="btn btn-success btn-loading">
                <span class="btn-text"><i class="bi bi-save"></i> Actualizar</span>
                <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
            </button>
            <a class="btn btn-secondary" href="<?= url('products') ?>">Cancelar</a>
        </form>
    </div>
</div>