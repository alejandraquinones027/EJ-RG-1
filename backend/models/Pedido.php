<?php
require_once __DIR__ . '/../config/database.php';

class Pedido {

    public static function all() {
        global $pdo;
        // Traemos también el nombre del cliente para mostrarlo en la tabla
        $sql = "
            SELECT p.id,
                   p.id_cliente,
                   c.nombre AS cliente,
                   p.fecha,
                   p.estado,
                   p.total
            FROM pedidos p
            JOIN clientes c ON c.id = p.id_cliente
            ORDER BY p.id DESC
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function find($id) {
        global $pdo;
        $sql = "
            SELECT p.id,
                   p.id_cliente,
                   c.nombre AS cliente,
                   p.fecha,
                   p.estado,
                   p.total
            FROM pedidos p
            JOIN clientes c ON c.id = p.id_cliente
            WHERE p.id = :id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO pedidos (id_cliente, fecha, estado, total)
            VALUES (:id_cliente, :fecha, :estado, :total)
        ");

        // Si no te mandan fecha desde el formulario, usamos la actual
        $fecha = $data['fecha'] ?? date('Y-m-d H:i:s');

        return $stmt->execute([
            ':id_cliente' => $data['id_cliente'],
            ':fecha'      => $fecha,
            ':estado'     => $data['estado'],
            ':total'      => $data['total'],
        ]);
    }

    public static function update($data) {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE pedidos
            SET id_cliente = :id_cliente,
                fecha      = :fecha,
                estado     = :estado,
                total      = :total
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id'         => $data['id'],
            ':id_cliente' => $data['id_cliente'],
            ':fecha'      => $data['fecha'],
            ':estado'     => $data['estado'],
            ':total'      => $data['total'],
        ]);
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM pedidos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
