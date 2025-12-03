<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController {

    public static function listar() {
        return Cliente::all();
    }

    public static function obtener($id) {
        return Cliente::find($id);
    }

    public static function crear($data) {
        // Validaciones mínimas para la tienda por WhatsApp
        if (trim($data['nombre'] ?? '') === '') {
            return [false, 'El nombre es obligatorio'];
        }

        if (trim($data['whatsapp'] ?? '') === '') {
            return [false, 'El número de WhatsApp es obligatorio'];
        }

        // barrio y dirección los dejamos opcionales
        Cliente::create($data);
        return [true, 'Cliente creado correctamente'];
    }

    public static function actualizar($data) {
        if (empty($data['id'])) {
            return [false, 'ID del cliente inválido'];
        }

        if (trim($data['nombre'] ?? '') === '') {
            return [false, 'El nombre es obligatorio'];
        }

        if (trim($data['whatsapp'] ?? '') === '') {
            return [false, 'El número de WhatsApp es obligatorio'];
        }

        Cliente::update($data);
        return [true, 'Cliente actualizado correctamente'];
    }

    public static function eliminar($id) {
        if (!$id) {
            return [false, 'ID inválido'];
        }
        Cliente::delete($id);
        return [true, 'Cliente eliminado correctamente'];
    }
}
