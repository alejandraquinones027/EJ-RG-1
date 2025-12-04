<?php
require_once __DIR__ . '/../config/database.php';

class Cliente {

    public static function all() {
        global $conexion;
        $stmt = $conexion->query("SELECT * FROM clientes ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public static function find($id) {
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function create($data) {
        global $conexion;
        $stmt = $conexion->prepare("
            INSERT INTO clientes (nombre, email, telefono, ciudad)
            VALUES (:n, :e, :t, :c)
        ");
        return $stmt->execute([
            ':n' => $data['nombre'],
            ':e' => $data['email'] ?? null,
            ':t' => $data['telefono'] ?? null,
            ':c' => $data['ciudad'] ?? null,
        ]);
    }

    public static function update($data) {
        global $conexion;
        $stmt = $conexion->prepare("
            UPDATE clientes
            SET nombre = :n, email = :e, telefono = :t, ciudad = :c
            WHERE id = :id
        ");
        return $stmt->execute([
            ':n'  => $data['nombre'],
            ':e'  => $data['email'] ?? null,
            ':t'  => $data['telefono'] ?? null,
            ':c'  => $data['ciudad'] ?? null,
            ':id' => $data['id'],
        ]);
    }

    public static function delete($id) {
        global $conexion;
        $stmt = $conexion->prepare("DELETE FROM clientes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
