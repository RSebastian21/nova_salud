<?php

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $productModel = new Product();
        $saleModel = new Sale();
        $lowStock = $productModel->lowStock();

        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'totalProducts' => $productModel->countAll(),
            'totalSales' => $saleModel->countAll(),
            'totalRevenue' => $saleModel->totalRevenue(),
            'lowStock' => $lowStock,
            'lowStockCount' => count($lowStock),
        ]);
    }
}