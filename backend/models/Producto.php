<?php
// backend/models/Producto.php
require_once __DIR__ . '/../config/database.php';

class Producto
{
    public static function all()
    {
        global $conexion;
        $sql = "SELECT * FROM productos ORDER BY id";
        $stmt = $conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conexion;
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        global $conexion;
        $sql = "INSERT INTO productos
                    (sku, nombre, descripcion, precio, stock, color_principal, imagen)
                VALUES
                    (:sku, :nombre, :descripcion, :precio, :stock, :color_principal, :imagen)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':sku'             => $data['sku'],
            ':nombre'          => $data['nombre'],
            ':descripcion'     => $data['descripcion'] ?? null,
            ':precio'          => $data['precio'],
            ':stock'           => $data['stock'],
            ':color_principal' => $data['color_principal'] ?? null,
            ':imagen'          => $data['imagen'] ?? null,
        ]);
        return $conexion->lastInsertId();
    }

    public static function update($data)
    {
        global $conexion;
        $sql = "UPDATE productos SET
                    sku = :sku,
                    nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    stock = :stock,
                    color_principal = :color_principal,
                    imagen = :imagen
                WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':id'              => $data['id'],
            ':sku'             => $data['sku'],
            ':nombre'          => $data['nombre'],
            ':descripcion'     => $data['descripcion'] ?? null,
            ':precio'          => $data['precio'],
            ':stock'           => $data['stock'],
            ':color_principal' => $data['color_principal'] ?? null,
            ':imagen'          => $data['imagen'] ?? null,
        ]);
    }

    public static function delete($id)
    {
        global $conexion;
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
