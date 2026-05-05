const NovaSalud = {
    swalSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Listo',
            text: message,
            confirmButtonColor: '#16a34a',
            timer: 1800,
            timerProgressBar: true
        });
    },

    swalError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonColor: '#dc2626'
        });
    },

    async confirm(title, text = 'Esta acción no se puede deshacer.', confirmButtonText = 'Sí, continuar') {
        const result = await Swal.fire({
            icon: 'warning',
            title,
            text,
            showCancelButton: true,
            confirmButtonText,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b'
        });

        return result.isConfirmed;
    },

    cleanupModalState() {
        if (document.activeElement && document.activeElement.closest('.modal')) {
            document.activeElement.blur();
        }

        setTimeout(() => {
            if (document.querySelector('.modal.show')) {
                return;
            }

            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }, 100);
    },

    cleanupModals() {
        this.cleanupModalState();
    },

    closeModal(element) {
        if (!element) {
            this.cleanupModalState();
            return;
        }

        if (document.activeElement && element.contains(document.activeElement)) {
            document.activeElement.blur();
        }

        const modal = bootstrap.Modal.getInstance(element);
        if (modal) {
            modal.hide();
        }
    },
    setLoading(button, isLoading) {
        if (!button) {
            return;
        }

        const text = button.querySelector('.btn-text');
        const spinner = button.querySelector('.spinner-border');
        button.disabled = isLoading;

        if (text && spinner) {
            text.classList.toggle('d-none', isLoading);
            spinner.classList.toggle('d-none', !isLoading);
        }
    },

    money(value) {
        return Number(value || 0).toFixed(2);
    },

    escape(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    },

    async postForm(form) {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        let data;
        try {
            data = await response.json();
        } catch (error) {
            throw new Error('Respuesta inválida del servidor.');
        }

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'No se pudo completar la acción.');
        }

        return data;
    },

    initFlashMessages() {
        const flash = document.getElementById('flash-messages');
        if (!flash) {
            return;
        }

        if (flash.dataset.success) {
            this.swalSuccess(flash.dataset.success);
        }

        if (flash.dataset.error) {
            this.swalError(flash.dataset.error);
        }
    },

    initModalSafety() {
        document.addEventListener('show.bs.modal', event => {
            const opened = document.querySelector('.modal.show');
            if (opened && opened !== event.target) {
                const openedInstance = bootstrap.Modal.getInstance(opened);
                if (openedInstance) {
                    openedInstance.hide();
                }
            }
        });

        document.addEventListener('hide.bs.modal', event => {
            if (document.activeElement && event.target.contains(document.activeElement)) {
                document.activeElement.blur();
            }
        });

        document.addEventListener('hidden.bs.modal', () => {
            this.cleanupModalState();
        });
    },
    renderProductRows(products) {
        const tbody = document.getElementById('productsTableBody');
        if (!tbody) {
            return false;
        }

        if (!products.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Sin productos registrados</td></tr>';
            return true;
        }

        const deleteUrl = tbody.dataset.deleteUrl || 'index.php?url=products/delete';

        tbody.innerHTML = products.map(product => {
            const stock = Number(product.stock);
            const stockBadge = stock < 10
                ? `<span class="badge text-bg-danger">${stock}</span>`
                : `<span class="badge text-bg-success">${stock}</span>`;
            const lowStock = stock < 10
                ? '<small class="text-danger"><i class="bi bi-exclamation-triangle"></i> Bajo stock</small>'
                : '';

            return `
                <tr data-product-id="${product.id}" data-name="${this.escape(product.name)}" data-price="${product.price}" data-stock="${stock}" data-category-id="${product.category_id}" class="row-fade">
                    <td>${product.id}</td>
                    <td><div class="fw-semibold">${this.escape(product.name)}</div>${lowStock}</td>
                    <td>${this.escape(product.category_name)}</td>
                    <td>S/ ${this.money(product.price)}</td>
                    <td>${stockBadge}</td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-success btn-icon js-restock-product" data-bs-toggle="modal" data-bs-target="#stockProductModal" title="Reabastecer">
                            <i class="bi bi-plus-square"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-icon js-edit-product" data-bs-toggle="modal" data-bs-target="#editProductModal" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form method="post" action="${deleteUrl}" class="d-inline ajax-delete-product">
                            <input type="hidden" name="id" value="${product.id}">
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            `;
        }).join('');

        return true;
    },

    fillProductForm(form, product) {
        const id = form.querySelector('[data-product-field="id"]');
        if (id) {
            id.value = product.id;
        }
        form.querySelector('[data-product-field="name"]').value = product.name;
        form.querySelector('[data-product-field="price"]').value = product.price;
        form.querySelector('[data-product-field="stock"]').value = product.stock;
        form.querySelector('[data-product-field="category_id"]').value = product.category_id;
    },

    getProductFromRow(button) {
        const row = button.closest('tr');
        return {
            id: row.dataset.productId,
            name: row.dataset.name,
            price: row.dataset.price,
            stock: row.dataset.stock,
            category_id: row.dataset.categoryId
        };
    },

    initProducts() {
        document.addEventListener('click', event => {
            const editButton = event.target.closest('.js-edit-product');
            if (editButton) {
                const modal = document.getElementById('editProductModal');
                const form = modal?.querySelector('form');
                if (form) {
                    this.fillProductForm(form, this.getProductFromRow(editButton));
                }
            }

            const stockButton = event.target.closest('.js-restock-product');
            if (stockButton) {
                const product = this.getProductFromRow(stockButton);
                const modal = document.getElementById('stockProductModal');
                if (modal) {
                    modal.querySelector('[data-stock-field="id"]').value = product.id;
                    modal.querySelector('[data-stock-field="stock"]').value = product.stock;
                    modal.querySelector('[data-stock-label="name"]').textContent = product.name;
                }
            }
        });

        document.querySelectorAll('.ajax-product-form, .ajax-stock-form').forEach(form => {
            form.addEventListener('submit', async event => {
                event.preventDefault();

                const button = form.querySelector('[type="submit"]');
                this.setLoading(button, true);

                try {
                    const data = await this.postForm(form);
                    this.renderProductRows(data.products || []);
                    form.reset();
                    this.closeModal(form.closest('.modal'));
                    this.swalSuccess(data.message || 'Operación realizada correctamente.');
                } catch (error) {
                    this.swalError(error.message);
                } finally {
                    this.setLoading(button, false);
                }
            });
        });

        document.addEventListener('submit', async event => {
            const form = event.target.closest('.ajax-delete-product');
            if (!form) {
                return;
            }

            event.preventDefault();

            const confirmed = await this.confirm('¿Eliminar este producto?', 'Esta acción no se puede deshacer.', 'Sí, eliminar');
            if (!confirmed) {
                return;
            }

            const button = form.querySelector('[type="submit"]');
            this.setLoading(button, true);

            try {
                const data = await this.postForm(form);
                this.renderProductRows(data.products || []);
                this.swalSuccess(data.message || 'Producto eliminado correctamente.');
            } catch (error) {
                this.swalError(error.message);
            } finally {
                this.setLoading(button, false);
            }
        });
    },

    renderCategoryRows(categories) {
        const tbody = document.getElementById('categoriesTableBody');
        if (!tbody) {
            return false;
        }

        if (!categories.length) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-4">Sin categorías registradas</td></tr>';
            return true;
        }

        const deleteUrl = tbody.dataset.deleteUrl || 'index.php?url=categories/delete';

        tbody.innerHTML = categories.map(category => `
            <tr data-category-id="${category.id}" data-name="${this.escape(category.name)}" class="row-fade">
                <td>${category.id}</td>
                <td class="fw-semibold">${this.escape(category.name)}</td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-primary btn-icon js-edit-category" data-bs-toggle="modal" data-bs-target="#editCategoryModal" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form method="post" action="${deleteUrl}" class="d-inline ajax-category-delete">
                        <input type="hidden" name="id" value="${category.id}">
                        <button type="submit" class="btn btn-sm btn-outline-danger btn-icon" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        `).join('');

        return true;
    },

    getCategoryFromRow(button) {
        const row = button.closest('tr');
        return {
            id: row.dataset.categoryId,
            name: row.dataset.name
        };
    },

    fillCategoryForm(form, category) {
        form.querySelector('[data-category-field="id"]').value = category.id;
        form.querySelector('[data-category-field="name"]').value = category.name;
    },

    initCategories() {
        document.addEventListener('click', event => {
            const editButton = event.target.closest('.js-edit-category');
            if (!editButton) {
                return;
            }

            const modal = document.getElementById('editCategoryModal');
            const form = modal?.querySelector('form');
            if (form) {
                this.fillCategoryForm(form, this.getCategoryFromRow(editButton));
            }
        });

        document.querySelectorAll('.ajax-category-form').forEach(form => {
            form.addEventListener('submit', async event => {
                event.preventDefault();

                const button = form.querySelector('[type="submit"]');
                this.setLoading(button, true);

                try {
                    const data = await this.postForm(form);
                    this.renderCategoryRows(data.data || []);
                    form.reset();
                    this.closeModal(form.closest('.modal'));
                    this.swalSuccess(data.message || 'Categoría guardada correctamente.');
                } catch (error) {
                    this.swalError(error.message);
                } finally {
                    this.setLoading(button, false);
                }
            });
        });

        document.addEventListener('submit', async event => {
            const form = event.target.closest('.ajax-category-delete');
            if (!form) {
                return;
            }

            event.preventDefault();

            const confirmed = await this.confirm('¿Eliminar esta categoría?', 'No podrás eliminar categorías que tengan productos asociados.', 'Sí, eliminar');
            if (!confirmed) {
                return;
            }

            const button = form.querySelector('[type="submit"]');
            this.setLoading(button, true);

            try {
                const data = await this.postForm(form);
                this.renderCategoryRows(data.data || []);
                this.swalSuccess(data.message || 'Categoría eliminada correctamente.');
            } catch (error) {
                this.swalError(error.message);
            } finally {
                this.setLoading(button, false);
            }
        });
    },



    initPOS() {
        const form = document.getElementById('saleForm');
        const productsData = document.getElementById('posProductsData');
        if (!form || !productsData) {
            return;
        }

        let products = JSON.parse(productsData.textContent || '[]');
        let itemIndex = 0;
        const items = document.getElementById('items');
        const totalLabel = document.getElementById('saleTotal');

        const productOptions = () => products.map(product => `
            <option value="${product.id}" data-price="${product.price}" data-stock="${product.stock}">
                ${this.escape(product.name)} - S/ ${this.money(product.price)} - Stock: ${product.stock}
            </option>
        `).join('');

        const addRow = () => {
            const row = document.createElement('div');
            row.className = 'row g-2 align-items-end sale-item mb-2 row-fade';
            row.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label">Producto</label>
                    <select name="items[${itemIndex}][product_id]" class="form-select product-select" required>
                        <option value="">Seleccione</option>
                        ${productOptions()}
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Cantidad</label>
                    <input type="number" min="1" name="items[${itemIndex}][quantity]" class="form-control quantity-input" value="1" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Subtotal</label>
                    <input type="text" class="form-control subtotal-input" value="0.00" readonly>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100 remove-item"><i class="bi bi-trash"></i></button>
                </div>
            `;
            items.appendChild(row);
            itemIndex++;
            calculateTotals();
        };

        const calculateTotals = () => {
            let total = 0;
            document.querySelectorAll('.sale-item').forEach(row => {
                const select = row.querySelector('.product-select');
                const selected = select.options[select.selectedIndex];
                const price = Number(selected?.dataset.price || 0);
                const stock = Number(selected?.dataset.stock || 0);
                const quantityInput = row.querySelector('.quantity-input');
                let quantity = Number(quantityInput.value || 0);

                if (stock > 0) {
                    quantityInput.max = stock;
                }

                if (quantity > stock && stock > 0) {
                    quantity = stock;
                    quantityInput.value = stock;
                    this.swalError('No puedes vender más unidades que el stock disponible.');
                }

                const subtotal = price * quantity;
                row.querySelector('.subtotal-input').value = this.money(subtotal);
                total += subtotal;
            });
            totalLabel.textContent = this.money(total);
            return total;
        };

        const validateStock = () => {
            const totalsByProduct = new Map();
            for (const row of document.querySelectorAll('.sale-item')) {
                const select = row.querySelector('.product-select');
                const selected = select.options[select.selectedIndex];
                const productId = select.value;
                const stock = Number(selected?.dataset.stock || 0);
                const quantity = Number(row.querySelector('.quantity-input').value || 0);

                if (!productId || quantity <= 0) {
                    continue;
                }

                const current = totalsByProduct.get(productId) || { quantity: 0, stock };
                current.quantity += quantity;
                totalsByProduct.set(productId, current);
            }

            for (const item of totalsByProduct.values()) {
                if (item.quantity > item.stock) {
                    this.swalError('La venta supera el stock disponible de un producto.');
                    return false;
                }
            }

            return true;
        };

        document.getElementById('addItem')?.addEventListener('click', addRow);
        document.addEventListener('input', event => {
            if (event.target.matches('.product-select, .quantity-input')) {
                calculateTotals();
            }
        });
        document.addEventListener('click', event => {
            if (event.target.closest('.remove-item')) {
                const rows = document.querySelectorAll('.sale-item');
                if (rows.length > 1) {
                    event.target.closest('.sale-item').remove();
                    calculateTotals();
                }
            }
        });

        form.addEventListener('submit', async event => {
            event.preventDefault();
            const total = calculateTotals();

            if (total <= 0 || !validateStock()) {
                return;
            }

            const confirmed = await this.confirm('¿Registrar venta?', `Total: S/ ${this.money(total)}`, 'Sí, cobrar');
            if (!confirmed) {
                return;
            }

            const button = form.querySelector('[type="submit"]');
            this.setLoading(button, true);

            try {
                const data = await this.postForm(form);
                products = data.products || [];
                items.innerHTML = '';
                itemIndex = 0;
                addRow();
                this.swalSuccess(data.message || 'Venta registrada correctamente.');
            } catch (error) {
                this.swalError(error.message);
            } finally {
                this.setLoading(button, false);
            }
        });

        addRow();
    },

    init() {
        this.initModalSafety();
        this.initFlashMessages();
        this.initProducts();
        this.initCategories();
        this.initPOS();
    }
};

document.addEventListener('DOMContentLoaded', () => NovaSalud.init());