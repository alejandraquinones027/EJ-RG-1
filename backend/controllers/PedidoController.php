<?php
require_once __DIR__ . '/../models/Pedido.php';

class PedidoController {

    public static function listar() {
        return Pedido::all();
    }

    public static function obtener($id) {
        return Pedido::find($id);
    }

    public static function crear($data) {
        // Validaciones básicas
        if (empty($data['id_cliente'])) {
            return [false, 'El cliente es obligatorio'];
        }

        if (trim($data['estado'] ?? '') === '') {
            return [false, 'El estado del pedido es obligatorio'];
        }

        if (!isset($data['total']) || !is_numeric($data['total']) || $data['total'] <= 0) {
            return [false, 'El total del pedido debe ser mayor a cero'];
        }

        // Si no envían fecha desde el formulario, se deja que el modelo ponga la actual
        Pedido::create($data);
        return [true, 'Pedido creado correctamente'];
    }

    public static function actualizar($data) {
        if (empty($data['id'])) {
            return [false, 'ID de pedido inválido'];
        }

        if (empty($data['id_cliente'])) {
            return [false, 'El cliente es obligatorio'];
        }

        if (trim($data['estado'] ?? '') === '') {
            return [false, 'El estado del pedido es obligatorio'];
        }

        if (!isset($data['total']) || !is_numeric($data['total']) || $data['total'] <= 0) {
            return [false, 'El total del pedido debe ser mayor a cero'];
        }

        Pedido::update($data);
        return [true, 'Pedido actualizado correctamente'];
    }

    public static function eliminar($id) {
        if (!$id) {
            return [false, 'ID inválido'];
        }
        Pedido::delete($id);
        return [true, 'Pedido eliminado correctamente'];
    }
}
