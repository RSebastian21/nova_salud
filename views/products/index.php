<div class="page-heading">
    <div>
        <span class="eyebrow">Inventario comercial</span>
        <h2>Productos</h2>
    </div>
    <button type="button" class="btn btn-success btn-action" data-bs-toggle="modal" data-bs-target="#createProductModal">
        <i class="bi bi-plus-lg"></i> Nuevo producto
    </button>
</div>

<?php if (!isset($products) || !is_iterable($products)) {
    $products = [];
} ?>

<div class="panel-card">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0 modern-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody id="productsTableBody"
                   data-update-url="<?= url('products/update') ?>"
                   data-delete-url="<?= url('products/delete') ?>"
                   data-update-stock-url="<?= url('products/updateStock') ?>">
            <?php foreach ($products as $product): ?>
                <tr data-product-id="<?= (int) $product['id'] ?>"
                    data-name="<?= e($product['name']) ?>"
                    data-price="<?= e((string) $product['price']) ?>"
                    data-stock="<?= (int) $product['stock'] ?>"
                    data-category-id="<?= (int) $product['category_id'] ?>">
                    <td><?= (int) $product['id'] ?></td>
                    <td>
                        <div class="fw-semibold"><?= e($product['name']) ?></div>
                        <?php if ((int) $product['stock'] < 10): ?>
                            <small class="text-danger"><i class="bi bi-exclamation-triangle"></i> Bajo stock</small>
                        <?php endif; ?>
                    </td>
                    <td><?= e($product['category_name']) ?></td>
                    <td>S/ <?= money($product['price']) ?></td>
                    <td>
                        <?php if ((int) $product['stock'] < 10): ?>
                            <span class="badge text-bg-danger"><?= (int) $product['stock'] ?></span>
                        <?php else: ?>
                            <span class="badge text-bg-success"><?= (int) $product['stock'] ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-success btn-icon js-restock-product" data-bs-toggle="modal" data-bs-target="#stockProductModal" title="Reabastecer">
                            <i class="bi bi-plus-square"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-icon js-edit-product" data-bs-toggle="modal" data-bs-target="#editProductModal" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form method="post" action="<?= url('products/delete') ?>" class="d-inline ajax-delete-product">
                            <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($products) === 0): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Sin productos registrados</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="createProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= url('products/store') ?>" class="ajax-product-form">
                <div class="modal-header">
                    <div>
                        <span class="eyebrow">Nuevo inventario</span>
                        <h5 class="modal-title">Crear producto</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <?php $product = null; require __DIR__ . '/form.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-loading">
                        <span class="btn-text"><i class="bi bi-check2-circle"></i> Guardar producto</span>
                        <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= url('products/update') ?>" class="ajax-product-form">
                <input type="hidden" name="id" data-product-field="id">
                <div class="modal-header">
                    <div>
                        <span class="eyebrow">Edición rápida</span>
                        <h5 class="modal-title">Editar producto</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <?php $product = null; require __DIR__ . '/form.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-loading">
                        <span class="btn-text"><i class="bi bi-save"></i> Actualizar producto</span>
                        <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="stockProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form method="post" action="<?= url('products/updateStock') ?>" class="ajax-stock-form">
                <input type="hidden" name="id" data-stock-field="id">
                <div class="modal-header">
                    <div>
                        <span class="eyebrow">Reabastecer</span>
                        <h5 class="modal-title" data-stock-label="name">Producto</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Stock actual</label>
                    <input type="number" min="0" name="stock" class="form-control form-control-lg" data-stock-field="stock" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-loading">
                        <span class="btn-text"><i class="bi bi-box-arrow-in-down"></i> Guardar stock</span>
                        <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>