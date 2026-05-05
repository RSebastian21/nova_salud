<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="post" action="<?= url('categories/store') ?>" class="ajax-category-form">

                <div class="modal-header">
                    <div>
                        <span class="eyebrow">Gestión</span>
                        <h5 class="modal-title">Nueva categoría</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control form-control-lg"
                               value="<?= e((string) old('name')) ?>" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit" class="btn btn-success btn-loading">
                        <span class="btn-text">
                            <i class="bi bi-check-circle"></i> Guardar
                        </span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>