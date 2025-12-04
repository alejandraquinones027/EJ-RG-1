## GUIA PASO A PASO PARA IMPLEMENTAR LA BASE DE DATOS DEL PROYECTO "AZURASHIRTS"

CREAR LA BASE DE DATOS
```sql
CREATE DATABASE azurashirts_db;
```

```sql
CREATE EXTENSION IF NOT EXISTS pgcrypto;
```

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


2. TABLA CLIENTES (PANEL DE ADMIN)
```sql
CREATE TABLE clientes (
    id       SERIAL PRIMARY KEY,
    nombre   VARCHAR(120) NOT NULL,
    email    VARCHAR(150),
    telefono VARCHAR(30),
    ciudad   VARCHAR(100),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3.TABLA PEDIDOS (PEDIDOS HECHOS DESDE LA WEB)
```sql
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
```
4. TABLA USUARIOS (ADMINISTRADORES DEL PANEL)
```sql
CREATE TABLE usuarios (
    id            SERIAL PRIMARY KEY,
    username      VARCHAR(50) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    nombre        VARCHAR(120) NOT NULL,
    creado_en     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

CONSULTAS ÚTILES
```sql
SELECT * FROM productos;
SELECT * FROM clientes;
SELECT * FROM pedidos;
SELECT * FROM usuarios;
```


## INSERTAR USUARIO ADMIN (CONTRASEÑA HASHEADA)

Solo si activaste pgcrypto arriba.
Cambia 'admin123' por la clave real que quieras usar.

Resumen de lo que acaba de quedar creado:
Base de datos: azurashirts_db
Tablas: productos, clientes, pedidos, usuarios
Usuario admin por defecto: username = 'admin', password = 'admin123'

Después de esto:
1.Asegúrate de que en backend/config/database.php (o donde tengas la conexión)
nombre de la base de datos coincida con azurashirts_db.
2.Inicia la app en el navegador:
/public/index.php  -> portada
/frontend/pages/login.php -> login admin (usa admin / admin123)
3.Desde el panel de clientes podrás registrar clientes.
4.Desde el formulario de pedido, los datos irán a la tabla pedidos.

