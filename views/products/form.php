<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" data-product-field="name" class="form-control form-control-lg" value="<?= e((string) ($product['name'] ?? old('name'))) ?>" required>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Precio</label>
        <input type="number" step="0.01" min="0" name="price" data-product-field="price" class="form-control" value="<?= e((string) ($product['price'] ?? old('price'))) ?>" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Stock</label>
        <input type="number" min="0" name="stock" data-product-field="stock" class="form-control" value="<?= e((string) ($product['stock'] ?? old('stock'))) ?>" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Categoría</label>
        <select name="category_id" data-product-field="category_id" class="form-select" required>
            <option value="">Seleccione</option>
            <?php $categories = $categories ?? []; ?>
            <?php foreach ($categories as $category): ?>
                <?php $selected = (int) ($product['category_id'] ?? old('category_id', 0)) === (int) $category['id']; ?>
                <option value="<?= (int) $category['id'] ?>" <?= $selected ? 'selected' : '' ?>>
                    <?= e($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>