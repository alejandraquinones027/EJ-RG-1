<?php
require_once __DIR__ . '/../core/session.php';
require_once __DIR__ . '/../helpers/response.php';
require_once __DIR__ . '/../controllers/ProductoController.php';

$action = $_GET['action'] ?? '';

// 👉 Solo obligo sesión para acciones de admin:
if (in_array($action, ['create', 'update', 'delete'])) {
    require_login_api();  // debe estar logueado
}

switch ($action) {

    case 'list':
        $productos = ProductoController::listar();
        json_success(['data' => $productos]);
        break;

    case 'get':
        $id = (int)($_GET['id'] ?? 0);
        $producto = ProductoController::obtener($id);
        if ($producto) {
            json_success(['producto' => $producto]);
        } else {
            json_error('Producto no encontrado', 404);
        }
        break;

    case 'create':
        list($ok, $msg) = ProductoController::crear($_POST);
        $ok ? json_success(['message' => $msg])
            : json_error($msg);
        break;

    case 'update':
        list($ok, $msg) = ProductoController::actualizar($_POST);
        $ok ? json_success(['message' => $msg])
            : json_error($msg);
        break;

    case 'delete':
        $id = (int)($_POST['id'] ?? 0);
        list($ok, $msg) = ProductoController::eliminar($id);
        $ok ? json_success(['message' => $msg])
            : json_error($msg);
        break;

    default:
        json_error('Acción no válida', 400);
}
