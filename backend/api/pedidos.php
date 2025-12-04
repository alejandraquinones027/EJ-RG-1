<?php
require_once __DIR__ . '/../helpers/response.php';
require_once __DIR__ . '/../controllers/PedidoController.php';
require_once __DIR__ . '/../core/session.php';

function get_request_data() {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (stripos($contentType, 'application/json') !== false) {
        $raw  = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }
    return $_POST;
}

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'create':
        // Aquí NO exijo login: el cliente puede pedir sin usuario del sistema
        $data = get_request_data();
        list($ok, $msg) = PedidoController::crear($data);
        $ok ? json_success(['message' => $msg])
            : json_error($msg);
        break;

    case 'list':
    case 'get':
        // 👉 Solo el admin (o usuario del sistema) puede ver pedidos
        require_login_api();
        if ($action === 'list') {
            $pedidos = PedidoController::listar();
            json_success(['data' => $pedidos]);
        } else {
            $id = (int)($_GET['id'] ?? 0);
            $pedido = PedidoController::obtener($id);
            $pedido
                ? json_success(['pedido' => $pedido])
                : json_error('Pedido no encontrado', 404);
        }
        break;

    default:
        json_error('Acción no válida', 400);
}
