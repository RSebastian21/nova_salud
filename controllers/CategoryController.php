<?php

class CategoryController extends Controller
{
    private Category $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index(): void
    {
        Auth::requireLogin();
        $this->view('categories/index', [
            'title' => 'Categorías',
            'categories' => $this->categoryModel->all(),
        ]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        $this->view('categories/create', ['title' => 'Nueva categoría']);
    }

    public function store(): void
    {
        Auth::requireLogin();

        try {
            $this->categoryModel->create($this->validatedData());

            if ($this->isAjax()) {
                $this->json([
                    'success' => true,
                    'message' => 'Categoría creada correctamente.',
                    'data' => $this->categoryModel->all(),
                ]);
            }

            $_SESSION['success'] = 'Categoría creada correctamente.';
        } catch (Throwable) {
            if ($this->isAjax()) {
                $this->json([
                    'success' => false,
                    'message' => 'No se pudo crear la categoría.',
                ], 422);
            }

            $_SESSION['error'] = 'No se pudo crear la categoría.';
        }

        $this->redirect('categories');
    }

    public function edit(): void
    {
        Auth::requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        $category = $this->categoryModel->find($id);

        if (!$category) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Categoría no encontrada.'], 404);
            }

            $this->redirect('categories');
        }

        if ($this->isAjax()) {
            $this->json([
                'success' => true,
                'category' => $category,
            ]);
        }

        $this->view('categories/edit', [
            'title' => 'Editar categoría',
            'category' => $category,
        ]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->categoryModel->update($id, $this->validatedData());

            if ($this->isAjax()) {
                $this->json([
                    'success' => true,
                    'message' => 'Categoría actualizada correctamente.',
                    'data' => $this->categoryModel->all(),
                ]);
            }

            $_SESSION['success'] = 'Categoría actualizada correctamente.';
        } catch (Throwable) {
            if ($this->isAjax()) {
                $this->json([
                    'success' => false,
                    'message' => 'No se pudo actualizar la categoría.',
                ], 422);
            }

            $_SESSION['error'] = 'No se pudo actualizar la categoría.';
        }

        $this->redirect('categories');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->categoryModel->delete($id);

            if ($this->isAjax()) {
                $this->json([
                    'success' => true,
                    'message' => 'Categoría eliminada correctamente.',
                    'data' => $this->categoryModel->all(),
                ]);
            }

            $_SESSION['success'] = 'Categoría eliminada correctamente.';
        } catch (Throwable) {
            if ($this->isAjax()) {
                $this->json([
                    'success' => false,
                    'message' => 'No se puede eliminar una categoría con productos.',
                ], 409);
            }

            $_SESSION['error'] = 'No se puede eliminar una categoría con productos.';
        }

        $this->redirect('categories');
    }

    private function validatedData(): array
    {
        return ['name' => trim($_POST['name'] ?? '')];
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