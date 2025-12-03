<?php
require_once __DIR__ . '/../config/database.php';

class Cliente {

    public static function all() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM clientes ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO clientes (nombre, whatsapp, barrio, direccion)
            VALUES (:n, :w, :b, :d)
        ");
        return $stmt->execute([
            ':n' => $data['nombre'],
            ':w' => $data['whatsapp'] ?? null,
            ':b' => $data['barrio']   ?? null,
            ':d' => $data['direccion'] ?? null,
        ]);
    }

    public static function update($data) {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE clientes
            SET nombre   = :n,
                whatsapp = :w,
                barrio   = :b,
                direccion= :d
            WHERE id = :id
        ");
        return $stmt->execute([
            ':n'  => $data['nombre'],
            ':w'  => $data['whatsapp'] ?? null,
            ':b'  => $data['barrio']   ?? null,
            ':d'  => $data['direccion'] ?? null,
            ':id' => $data['id'],
        ]);
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
