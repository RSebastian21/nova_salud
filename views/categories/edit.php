<h1 class="h3 mb-3">Editar categoría</h1>

<?php if (!isset($category) || !is_array($category)) { ?>
<p>Categoría no encontrada.</p>
<?php } else { ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="<?= url('categories/update') ?>">
            <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="<?= e($category['name']) ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a class="btn btn-secondary" href="<?= url('categories') ?>">Cancelar</a>
        </form>
    </div>
</div>

<?php } ?>

