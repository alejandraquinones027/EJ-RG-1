<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController
{
    // Lista todas las camisetas
    public static function listar()
    {
        return Producto::all();
    }

    // Obtiene un producto por ID
    public static function obtener($id)
    {
        return Producto::find($id);
    }

    // Crea un nuevo producto
    public static function crear($data)
    {
        $sku    = trim($data['sku'] ?? '');
        $nombre = trim($data['nombre'] ?? '');
        $precio = $data['precio'] ?? null;
        $stock  = $data['stock'] ?? null;

        if ($sku === '' || $nombre === '') {
            return [false, 'SKU y nombre son obligatorios'];
        }

        if (!is_numeric($precio) || $precio <= 0) {
            return [false, 'El precio debe ser un número mayor que 0'];
        }

        if (!is_numeric($stock) || $stock < 0) {
            return [false, 'El stock debe ser un número mayor o igual a 0'];
        }

        // Si pasa las validaciones, creamos el producto
        Producto::create($data);
        return [true, 'Producto creado correctamente'];
    }

    // Actualiza un producto
    public static function actualizar($data)
    {
        $id     = $data['id'] ?? null;
        $sku    = trim($data['sku'] ?? '');
        $nombre = trim($data['nombre'] ?? '');
        $precio = $data['precio'] ?? null;
        $stock  = $data['stock'] ?? null;

        if (empty($id)) {
            return [false, 'ID de producto inválido'];
        }

        if ($sku === '' || $nombre === '') {
            return [false, 'SKU y nombre son obligatorios'];
        }

        if (!is_numeric($precio) || $precio <= 0) {
            return [false, 'El precio debe ser un número mayor que 0'];
        }

        if (!is_numeric($stock) || $stock < 0) {
            return [false, 'El stock debe ser un número mayor o igual a 0'];
        }

        Producto::update($data);
        return [true, 'Producto actualizado correctamente'];
    }

    // Elimina un producto
    public static function eliminar($id)
    {
        if (!$id) {
            return [false, 'ID inválido'];
        }

        Producto::delete($id);
        return [true, 'Producto eliminado correctamente'];
    }
}
