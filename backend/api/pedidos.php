<?php
require_once __DIR__ . '/../core/session.php';
require_once __DIR__ . '/../helpers/response.php';
require_once __DIR__ . '/../controllers/PedidoController.php';

// Solo usuarios autenticados
require_login_api();

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'list':
        // Lista de pedidos (para DataTables)
        $pedidos = PedidoController::listar();
        json_success(['data' => $pedidos]);
        break;

    case 'get':
        $id = (int)($_GET['id'] ?? 0);
        $pedido = PedidoController::obtener($id);
        if ($pedido) {
            json_success(['pedido' => $pedido]);
        } else {
            json_error('Pedido no encontrado', 404);
        }
        break;

    case 'create':
        // Datos vienen por POST desde el formulario de pedidos
        list($ok, $msg) = PedidoController::crear($_POST);
        if ($ok) {
            json_success(['message' => $msg]);
        } else {
            json_error($msg);
        }
        break;

    case 'update':
        list($ok, $msg) = PedidoController::actualizar($_POST);
        if ($ok) {
            json_success(['message' => $msg]);
        } else {
            json_error($msg);
        }
        break;

    case 'delete':
        $id = (int)($_POST['id'] ?? 0);
        list($ok, $msg) = PedidoController::eliminar($id);
        if ($ok) {
            json_success(['message' => $msg]);
        } else {
            json_error($msg);
        }
        break;

    default:
        json_error('Acción no válida', 400);
}
