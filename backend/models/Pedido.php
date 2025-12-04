<?php
// backend/models/Pedido.php
require_once __DIR__ . '/../config/database.php';

class Pedido
{
    // Crear un nuevo pedido
    public static function create($data)
    {
        global $conexion;

        $sql = "INSERT INTO pedidos
                (producto_id, nombre_cliente, telefono, direccion, talla, color, cantidad,
                 estado_pago, estado_envio)
                VALUES
                (:producto_id, :nombre_cliente, :telefono, :direccion, :talla, :color, :cantidad,
                 'pendiente', 'pendiente')";

        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':producto_id'    => $data['producto_id'],
            ':nombre_cliente' => $data['nombre_cliente'],
            ':telefono'       => $data['telefono'],
            ':direccion'      => $data['direccion'] ?? null,
            ':talla'          => $data['talla'] ?? null,
            ':color'          => $data['color'] ?? null,
            ':cantidad'       => $data['cantidad'] ?? 1,
        ]);

        return $conexion->lastInsertId();
    }

    // Listar todos los pedidos
    public static function all()
    {
        global $conexion;

        $sql = "SELECT p.id, p.nombre_cliente, p.telefono, p.direccion,
                       p.talla, p.color, p.cantidad,
                       p.estado_pago, p.estado_envio, p.creado_en,
                       pr.nombre AS producto_nombre, pr.sku
                FROM pedidos p
                JOIN productos pr ON pr.id = p.producto_id
                ORDER BY p.id DESC";

        $stmt = $conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un pedido por id
    public static function find($id)
    {
        global $conexion;

        $sql = "SELECT p.*, pr.nombre AS producto_nombre, pr.sku
                FROM pedidos p
                JOIN productos pr ON pr.id = p.producto_id
                WHERE p.id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
