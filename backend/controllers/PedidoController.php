<?php
// backend/controllers/PedidoController.php
require_once __DIR__ . '/../models/Pedido.php';

class PedidoController
{
    public static function listar()
    {
        return Pedido::all();
    }

    public static function obtener($id)
    {
        return Pedido::find($id);
    }

    public static function crear($data)
    {
        $producto_id    = $data['producto_id'] ?? null;
        $nombre_cliente = trim($data['nombre_cliente'] ?? '');
        $telefono       = trim($data['telefono'] ?? '');
        $direccion      = trim($data['direccion'] ?? '');
        $talla          = trim($data['talla'] ?? '');
        $color          = trim($data['color'] ?? '');
        $cantidad       = $data['cantidad'] ?? 1;

        if (empty($producto_id) || !is_numeric($producto_id)) {
            return [false, 'Producto inválido'];
        }

        if ($nombre_cliente === '') {
            return [false, 'El nombre del cliente es obligatorio'];
        }

        if ($telefono === '') {
            return [false, 'El teléfono es obligatorio'];
        }

        if (!is_numeric($cantidad) || $cantidad <= 0) {
            return [false, 'La cantidad debe ser mayor que 0'];
        }

        $pedidoId = Pedido::create([
            'producto_id'    => (int)$producto_id,
            'nombre_cliente' => $nombre_cliente,
            'telefono'       => $telefono,
            'direccion'      => $direccion,
            'talla'          => $talla,
            'color'          => $color,
            'cantidad'       => (int)$cantidad,
        ]);

        return [true, "Pedido registrado correctamente. N° {$pedidoId}"];
    }
}
