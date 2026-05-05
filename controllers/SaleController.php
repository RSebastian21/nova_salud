<?php

class SaleController extends Controller
{
    private Sale $saleModel;
    private Product $productModel;

    public function __construct()
    {
        $this->saleModel = new Sale();
        $this->productModel = new Product();
    }

    public function index(): void
    {
        Auth::requireLogin();
        $this->view('sales/index', [
            'title' => 'Ventas',
            'sales' => $this->saleModel->all(),
        ]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        $this->view('sales/create', [
            'title' => 'Nueva venta',
            'products' => $this->productModel->available(),
        ]);
    }

    public function store(): void
    {
        Auth::requireLogin();

        try {
            $items = $_POST['items'] ?? [];
            $saleId = $this->saleModel->create($items, (int) Auth::user()['id']);

            if ($this->isAjax()) {
                $this->json([
                    'success' => true,
                    'message' => 'Venta registrada correctamente.',
                    'sale_id' => $saleId,
                    'products' => $this->productModel->available(),
                ]);
            }

            $_SESSION['success'] = 'Venta registrada correctamente.';
            $this->redirect('sales');
        } catch (Throwable $exception) {
            if ($this->isAjax()) {
                $this->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                ], 422);
            }

            $_SESSION['error'] = $exception->getMessage();
            $this->redirect('sales/create');
        }
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