<?php

class ProductController extends Controller
{
    private Product $productModel;
    private Category $categoryModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index(): void
    {
        Auth::requireLogin();
        $this->view('products/index', [
            'title' => 'Productos',
            'products' => $this->productModel->all(),
            'categories' => $this->categoryModel->all(),
        ]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        $this->view('products/create', [
            'title' => 'Nuevo producto',
            'categories' => $this->categoryModel->all(),
        ]);
    }

    public function store(): void
    {
        Auth::requireLogin();

        try {
            $this->productModel->create($this->validatedData());

            if ($this->isAjax()) {
                $this->json([
                    'success' => true,
                    'message' => 'Producto creado correctamente.',
                    'products' => $this->productModel->all(),
                ]);
            }

            $_SESSION['success'] = 'Producto creado correctamente.';
        } catch (Throwable) {
            if ($this->isAjax()) {
                $this->json([
                    'success' => false,
                    'message' => 'No se pudo crear el producto.',
                ], 422);
            }

            $_SESSION['error'] = 'No se pudo crear el producto.';
        }

        $this->redirect('products');
    }

    public function edit(?int $id = null): void
    {
        Auth::requireLogin();
        $id = $id ?? (int) ($_GET['id'] ?? 0);
        $product = $this->productModel->find($id);

        if (!$product) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Producto no encontrado.'], 404);
            }

            $this->redirect('products');
        }

        if ($this->isAjax()) {
            $this->json([
                'success' => true,
                'product' => $product,
            ]);
        }

        $this->view('products/edit', [
            'title' => 'Editar producto',
            'product' => $product,
            'categories' => $this->categoryModel->all(),
        ]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->productModel->update($id, $this->validatedData());

            if ($this->isAjax()) {
                $this->json([
                    'success' => true,
                    'message' => 'Producto actualizado correctamente.',
                    'products' => $this->productModel->all(),
                ]);
            }

            $_SESSION['success'] = 'Producto actualizado correctamente.';
        } catch (Throwable) {
            if ($this->isAjax()) {
                $this->json([
                    'success' => false,
                    'message' => 'No se pudo actualizar el producto.',
                ], 422);
            }

            $_SESSION['error'] = 'No se pudo actualizar el producto.';
        }

        $this->redirect('products');
    }

    public function updateStock(): void
    {
        Auth::requireLogin();
        $id = (int) ($_POST['id'] ?? 0);
        $stock = max(0, (int) ($_POST['stock'] ?? 0));

        try {
            $this->productModel->updateStock($id, $stock);

            if ($this->isAjax()) {
                $this->json([
                    'success' => true,
                    'message' => 'Stock actualizado correctamente.',
                    'products' => $this->productModel->all(),
                ]);
            }

            $_SESSION['success'] = 'Stock actualizado correctamente.';
        } catch (Throwable) {
            if ($this->isAjax()) {
                $this->json([
                    'success' => false,
                    'message' => 'No se pudo actualizar el stock.',
                ], 422);
            }

            $_SESSION['error'] = 'No se pudo actualizar el stock.';
        }

        $this->redirect('products');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->productModel->delete($id);

            if ($this->isAjax()) {
                $this->json([
                    'success' => true,
                    'message' => 'Producto eliminado correctamente.',
                    'products' => $this->productModel->all(),
                ]);
            }

            $_SESSION['success'] = 'Producto eliminado correctamente.';
        } catch (Throwable) {
            if ($this->isAjax()) {
                $this->json([
                    'success' => false,
                    'message' => 'No se puede eliminar un producto usado en ventas.',
                ], 409);
            }

            $_SESSION['error'] = 'No se puede eliminar un producto usado en ventas.';
        }

        $this->redirect('products');
    }

    private function validatedData(): array
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'price' => (float) ($_POST['price'] ?? 0),
            'stock' => max(0, (int) ($_POST['stock'] ?? 0)),
            'category_id' => (int) ($_POST['category_id'] ?? 0),
        ];
    }

    private function isAjax(): bool
    {
        return ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
    }

    private function json(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload);
        exit;
    }
}