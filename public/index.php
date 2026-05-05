<?php

session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Sale.php';

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/CategoryController.php';
require_once __DIR__ . '/../controllers/SaleController.php';

$routes = [
    '' => [AuthController::class, 'login'],
    'login' => [AuthController::class, 'login'],
    'authenticate' => [AuthController::class, 'authenticate'],
    'logout' => [AuthController::class, 'logout'],
    'dashboard' => [DashboardController::class, 'index'],
    'products' => [ProductController::class, 'index'],
    'products/create' => [ProductController::class, 'create'],
    'products/store' => [ProductController::class, 'store'],
    'products/edit' => [ProductController::class, 'edit'],
    'products/update' => [ProductController::class, 'update'],
    'products/updateStock' => [ProductController::class, 'updateStock'],
    'products/delete' => [ProductController::class, 'delete'],
    'categories' => [CategoryController::class, 'index'],
    'categories/create' => [CategoryController::class, 'create'],
    'categories/store' => [CategoryController::class, 'store'],
    'categories/edit' => [CategoryController::class, 'edit'],
    'categories/update' => [CategoryController::class, 'update'],
    'categories/delete' => [CategoryController::class, 'delete'],
    'sales' => [SaleController::class, 'index'],
    'sales/create' => [SaleController::class, 'create'],
    'sales/store' => [SaleController::class, 'store'],
];

$path = trim($_GET['url'] ?? '', '/');
$params = [];

if (preg_match('#^products/edit/(\d+)$#', $path, $matches)) {
    $path = 'products/edit';
    $_GET['id'] = $matches[1];
    $params[] = (int) $matches[1];
}

if (!array_key_exists($path, $routes)) {
    http_response_code(404);
    $controller = new Controller();
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('view');
    $method->setAccessible(true);
    $method->invoke($controller, 'errors/404', ['title' => '404']);
    exit;
}

[$controllerClass, $method] = $routes[$path];
$controller = new $controllerClass();
$controller->$method(...$params);