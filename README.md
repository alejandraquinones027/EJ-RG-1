-- GUIA PASO A PASO PARA IMPLEMENTAR LA BASE DE DATOS DEL PROYECTO "AZURASHIRTS"
-- (Listo para usar en PostgreSQL desde PgAdmin)

--------------------------------------------------------------------
-- 0. CREAR LA BASE DE DATOS
--------------------------------------------------------------------
-- En PgAdmin (Server > Databases > Query Tool en el servidor), ejecuta:
CREATE DATABASE azurashirts_db;

-- Luego, en PgAdmin, conéctate a azurashirts_db (doble clic)
-- y el resto de sentencias ejecútalas ya DENTRO de esa base.

--------------------------------------------------------------------
-- 0.1 OPCIONAL: EXTENSIÓN PARA HASHEAR CONTRASEÑAS (pgcrypto)
--------------------------------------------------------------------
-- Solo si quieres usar crypt()/gen_salt() para el usuario admin:
CREATE EXTENSION IF NOT EXISTS pgcrypto;

1. TABLA PRODUCTOS 
```sql
CREATE TABLE productos (
    id          SERIAL PRIMARY KEY,
    nombre      VARCHAR(120) NOT NULL,
    sku         VARCHAR(50) UNIQUE NOT NULL,
    descripcion TEXT,
    precio      INT NOT NULL,          
    imagen      VARCHAR(255) 
);
```
CREATE TABLE productos (
    id          SERIAL PRIMARY KEY,
    nombre      VARCHAR(120) NOT NULL,
    sku         VARCHAR(50) UNIQUE NOT NULL,
    descripcion TEXT,
    precio      INT NOT NULL,          -- precio en pesos enteros
    imagen      VARCHAR(255)           -- nombre del archivo de la imagen (ej: "camiseta1.jpg")
);

-- CONSULTAS ÚTILES
-- Ver productos
--   SELECT * FROM productos;
-- Borrar todo (pero mantener la tabla)
--   TRUNCATE TABLE productos RESTART IDENTITY;

--------------------------------------------------------------------
-- 2. TABLA CLIENTES (PANEL DE ADMIN)
--------------------------------------------------------------------
CREATE TABLE clientes (
    id       SERIAL PRIMARY KEY,
    nombre   VARCHAR(120) NOT NULL,
    email    VARCHAR(150),
    telefono VARCHAR(30),
    ciudad   VARCHAR(100),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CONSULTAS ÚTILES
--   SELECT * FROM clientes;
--   TRUNCATE TABLE clientes RESTART IDENTITY;

--------------------------------------------------------------------
-- 3. TABLA PEDIDOS (PEDIDOS HECHOS DESDE LA WEB)
--------------------------------------------------------------------
CREATE TABLE pedidos (
    id             SERIAL PRIMARY KEY,
    producto       VARCHAR(150) NOT NULL,   -- nombre de la camiseta que seleccionó el cliente
    talla          VARCHAR(10),             -- S, M, L, XL...
    color          VARCHAR(30),             -- Blanco, Negro, Beige...
    cantidad       INT NOT NULL,
    nombre_cliente VARCHAR(120) NOT NULL,
    telefono       VARCHAR(30) NOT NULL,
    direccion      VARCHAR(200),
    fecha          TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- OJO:
-- Los nombres de columnas coinciden con lo que usa backend/api/pedidos.php
-- (producto, talla, color, cantidad, nombre_cliente, telefono, direccion, fecha)

-- CONSULTAS ÚTILES
--   SELECT * FROM pedidos;
--   TRUNCATE TABLE pedidos RESTART IDENTITY;

--------------------------------------------------------------------
-- 4. TABLA USUARIOS (ADMINISTRADORES DEL PANEL)
--------------------------------------------------------------------
CREATE TABLE usuarios (
    id            SERIAL PRIMARY KEY,
    username      VARCHAR(50) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    nombre        VARCHAR(120) NOT NULL,
    creado_en     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Esta tabla es la que usa auth.php para el login de "admin".

--------------------------------------------------------------------
-- 4.1 INSERTAR USUARIO ADMIN (CONTRASEÑA HASHEADA)
--------------------------------------------------------------------
-- Solo si activaste pgcrypto arriba.
-- Cambia 'admin123' por la clave real que quieras usar.
INSERT INTO usuarios (username, password_hash, nombre)
VALUES (
    'admin',
    crypt('admin123', gen_salt('bf')),
    'Admin AzuraShirts'
);

-- Para ver los usuarios:
--   SELECT * FROM usuarios;

--------------------------------------------------------------------
-- FIN DE LA GUIA SQL
--------------------------------------------------------------------
-- Resumen de lo que acaba de quedar creado:
--   - Base de datos: azurashirts_db
--   - Tablas: productos, clientes, pedidos, usuarios
--   - Usuario admin por defecto: username = 'admin', password = 'admin123'
--
-- Después de esto:
--   1) Asegúrate de que en backend/config/database.php (o donde tengas la conexión)
--      el nombre de la base de datos coincida con azurashirts_db.
--   2) Inicia la app en el navegador:
--        - /public/index.php  -> portada
--        - /frontend/pages/login.php -> login admin (usa admin / admin123)
--   3) Desde el panel de clientes podrás registrar clientes.
--   4) Desde el formulario de pedido, los datos irán a la tabla pedidos.


# Sistema de Tienda Virtual por WhatsApp 👕📱

Emprendimiento de venta de ropa que opera por WhatsApp (estados y chat).El sistema permite generar cards listas para publicar, con foto, SKU, talla, color, precio, logo Además controla inventario por variantes (modelo–talla–color), pedidos, pagos, envíos y devoluciones.
# Instalación y Ejecución.
1. Clonar el repositorio: `git clone https://github.com/alejandraquinones027/EJ-RG-1.git`
2. Entrar a la carpeta del proyecto: `cd EJ-RG-1`
3. Seguir las instrucciones del docente para ejecutar o documentar los módulos (usuarios, productos, drops).
#  Características del proyecto
- Tipo de tienda: virtual por WhatsApp, sin catálogo público
- Generación de cards  con sello “AGOTADO”
- Gestión de usuarios y roles (administrador, vendedor, cliente)
- Inventario con variantes modelo–talla–color y SKU único (sin stock negativo)
- Registro de pedidos desde el chat de WhatsApp con reserva de 30 min
- Pagos, envíos, devoluciones y reportes diarios/kardex
 # Fragmento de Código
```python
print("Sistema de tienda virtual iniciado...")
```
## Enlace
[Mi perfil de GitHub](https://github.com/alejandraquinones027)
## Logo
<img src="https://github.com/alejandraquinones027/EJ-RG-1/raw/main/Logo.png" alt="Logo ComixStore" width="250">





