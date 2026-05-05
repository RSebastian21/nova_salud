<?php $products = $products ?? []; ?>

<div class="page-heading">
    <div>
        <span class="eyebrow">Punto de venta</span>
        <h2>Nueva venta</h2>
    </div>
    <a class="btn btn-outline-secondary" href="<?= url('sales') ?>">
        <i class="bi bi-clock-history"></i> Historial
    </a>
</div>

<script type="application/json" id="posProductsData">
<?= json_encode($products, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>
</script>

<form method="post" action="<?= url('sales/store') ?>" id="saleForm" class="pos-form">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="panel-card p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <span class="eyebrow">Carrito</span>
                        <h3 class="h5 mb-0">Productos de la venta</h3>
                    </div>
                    <button type="button" class="btn btn-outline-success" id="addItem">
                        <i class="bi bi-plus-lg"></i> Agregar
                    </button>
                </div>
                <div id="items" class="pos-items"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel-card p-4 pos-summary">
                <span class="eyebrow">Resumen</span>
                <div class="d-flex justify-content-between align-items-center my-3">
                    <span class="text-muted">Total</span>
                    <strong class="display-6">S/ <span id="saleTotal">0.00</span></strong>
                </div>
                <div class="alert alert-light border small mb-3">
                    <i class="bi bi-shield-check text-success"></i>
                    El sistema valida stock antes de registrar la venta.
                </div>
                <button type="submit" class="btn btn-success btn-lg w-100 btn-loading">
                    <span class="btn-text"><i class="bi bi-check2-circle"></i> Cobrar y registrar</span>
                    <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                </button>
                <a class="btn btn-light w-100 mt-2" href="<?= url('sales') ?>">Cancelar</a>
            </div>
        </div>
    </div>
</form>