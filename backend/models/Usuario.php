<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {

    public static function findByUsername($username) {
        global $conexion;
        $sql  = "SELECT * FROM usuarios WHERE username = :u";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':u' => $username]);
        return $stmt->fetch();
    }
}
