<div class="page-heading">
    <div>
        <span class="eyebrow">Clasificación</span>
        <h2>Categorías</h2>
    </div>
    <button type="button" class="btn btn-success btn-action" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        <i class="bi bi-plus-lg"></i> Nueva categoría
    </button>
</div>

<div class="panel-card">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0 modern-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody id="categoriesTableBody" data-delete-url="<?= url('categories/delete') ?>">
            <?php foreach ($categories ?? [] as $category): ?>
                <tr data-category-id="<?= (int) $category['id'] ?>" data-name="<?= e($category['name']) ?>">
                    <td><?= (int) $category['id'] ?></td>
                    <td class="fw-semibold"><?= e($category['name']) ?></td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-primary btn-icon js-edit-category" data-bs-toggle="modal" data-bs-target="#editCategoryModal" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form method="post" action="<?= url('categories/delete') ?>" class="d-inline ajax-category-delete">
                            <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($categories ?? []) === 0): ?>
                <tr><td colspan="3" class="text-center text-muted py-4">Sin categorías registradas</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= url('categories/store') ?>" class="ajax-category-form">
                <div class="modal-header">
                    <div>
                        <span class="eyebrow">Nueva clasificación</span>
                        <h5 class="modal-title">Crear categoría</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control form-control-lg" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-loading">
                        <span class="btn-text"><i class="bi bi-check2-circle"></i> Guardar categoría</span>
                        <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= url('categories/update') ?>" class="ajax-category-form">
                <input type="hidden" name="id" data-category-field="id">
                <div class="modal-header">
                    <div>
                        <span class="eyebrow">Edición rápida</span>
                        <h5 class="modal-title">Editar categoría</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" data-category-field="name" class="form-control form-control-lg" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-loading">
                        <span class="btn-text"><i class="bi bi-save"></i> Actualizar categoría</span>
                        <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>