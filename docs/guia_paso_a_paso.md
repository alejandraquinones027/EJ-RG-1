
````markdown
# Guía paso a paso para implementar el Sistema de Tienda Virtual por WhatsApp 👗📱


---

## Paso 1. Preparar la base de datos en PostgreSQL

1. Crear la base de datos (por ejemplo):

   ```sql
   CREATE DATABASE tienda_whatsapp;
   CREATE EXTENSION IF NOT EXISTS pgcrypto;
````

2. Ejecutar el **script SQL completo** del proyecto para crear las tablas principales:

   * `roles`
   * `usuarios`
   * `clientes`
   * `productos`
   * `drops` y `drop_productos`
   * `pedidos` y `pedido_items`
   * `pagos`
   * `envios`
   * `devoluciones` y `devolucion_items`
   * `kardex_movimientos`
   * `bitacora`

   Este script debe estar en el repositorio (por ejemplo, `docs/database_tienda.sql`)
   y se ejecuta dentro de la base de datos `tienda_whatsapp`.

3. Verificar que existan al menos:

   ```sql
   SELECT * FROM usuarios;
   SELECT * FROM clientes;
   SELECT * FROM productos;
   ```

   Debe existir un usuario administrador inicial (por ejemplo, `admin` con contraseña
   `admin123` en formato hash usando `crypt()`).

---

## Paso 2. Configurar el backend (PHP + PDO)

1. Abrir `backend/config/database.php` y configurar las credenciales reales de PostgreSQL:

   * Host (por ejemplo, `localhost`)
   * Puerto (por ejemplo, `5432`)
   * Nombre de base de datos (`tienda_whatsapp`)
   * Usuario (por ejemplo, `postgres`)
   * Contraseña

2. Recordar:

   * Usar `try/catch` para capturar errores de conexión.
   * Activar el modo de errores de PDO:

     ```php
     $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     ```

3. Revisar los modelos básicos:

   * `backend/models/Usuario.php` → login y datos del usuario.
   * `backend/models/Cliente.php` → CRUD de clientes.
   * `backend/models/Producto.php` → CRUD de productos / variantes.
   * (En etapas posteriores) `Drop.php`, `Pedido.php`, `Pago.php`, `Envio.php`, `Devolucion.php`.

---

## Paso 3. Manejo de sesiones

1. Revisar `backend/core/session.php`:

   * Llamada a `session_start()`.
   * Funciones de apoyo, por ejemplo:

     * `require_login_api()` → proteger las APIs.
     * `require_login_page()` → proteger las páginas internas.

2. Revisar el flujo general:

   * El login guarda datos del usuario en `$_SESSION`.
   * Las APIs protegidas usan `require_login_api()` para verificar que haya sesión.
   * Las páginas internas (`dashboard.php`, `clientes.php`, `productos.php`, etc.)
     usan `require_login_page()` para redirigir al login si no hay usuario autenticado.

---

## Paso 4. Implementar la autenticación (login/logout)

1. Revisar `backend/controllers/AuthController.php`:

   * Validación de usuario y contraseña.
   * Consulta a la tabla `usuarios`.
   * Verificación del hash con `crypt()`.

2. Revisar `backend/api/auth.php`:

   * Endpoint `action=login` para procesar el formulario de login vía AJAX.
   * Endpoint `action=logout` para cerrar la sesión y limpiar `$_SESSION`.

3. Revisar `frontend/pages/login.php`:

   * Formulario de login con Bootstrap.
   * Envío de datos usando jQuery AJAX hacia `backend/api/auth.php`.
   * Manejo de mensajes de error si las credenciales no son válidas.

---

## Paso 5. Implementar el módulo de clientes (CRUD)

1. Revisar `backend/models/Cliente.php`:

   * Métodos `all`, `find`, `create`, `update`, `delete` (eliminación lógica).

2. Revisar `backend/controllers/ClientesController.php`:

   * Lógica de validación (campos obligatorios, formato de WhatsApp, etc.).
   * Respuestas estandarizadas (éxito / error) para las APIs.

3. Revisar `backend/api/clientes.php`:

   * Acciones típicas:

     * `list` → listar clientes para DataTables.
     * `get` → obtener un cliente por `id`.
     * `create` → crear cliente nuevo.
     * `update` → actualizar datos.
     * `delete` → marcar como inactivo.

4. Revisar `frontend/pages/clientes.php`:

   * Tabla inicializada con **DataTables** usando fuente AJAX.
   * Modales de Bootstrap para crear/editar clientes.
   * Botones de editar y eliminar que disparan peticiones AJAX a `backend/api/clientes.php`.

---

## Paso 6. Implementar el módulo de productos e inventario

1. Crear o revisar `backend/models/Producto.php`:

   * Campos básicos: `sku`, `nombre`, `marca`, `talla`, `color`, `costo`, `precio`, `stock`, `activo`.
   * Métodos: `all`, `find`, `create`, `update`, `desactivar`.

2. Crear `backend/controllers/ProductosController.php`:

   * Validar:

     * SKU único.
     * Stock no negativo.
     * Campos obligatorios (nombre, talla, color, precio).
   * Encapsular la lógica antes de llamar al modelo.

3. Crear `backend/api/productos.php`:

   * Acciones:

     * `list` → lista de productos para DataTables (con filtros si se desea).
     * `get` → obtener un producto por `id`.
     * `create` → crear producto / variante.
     * `update` → actualizar datos de un producto.
     * `toggle_active` o `delete` → activar/desactivar producto.

4. Crear o revisar `frontend/pages/productos.php`:

   * Tabla con **DataTables** para ver el inventario.
   * Formulario (modal) para registrar nuevas variantes de producto.
   * Filtros por talla, color y disponibilidad (con stock / agotado).

---

## Paso 7. Implementar drops, pedidos, pagos, envíos y devoluciones (etapas posteriores)

> Este paso normalmente se desarrolla en sprints posteriores, reutilizando el mismo patrón:
> **modelo → controlador → API → página frontend**.

1. **Drops y cards**

   * `backend/models/Drop.php` y `backend/api/drops.php`.
   * `frontend/pages/drops.php` para:

     * Crear drops.
     * Asociar productos a cada drop.
     * Generar cards listas para publicar.

2. **Pedidos y pagos**

   * `backend/models/Pedido.php`, `backend/models/Pago.php`.
   * `backend/api/pedidos.php`, `backend/api/pagos.php`.
   * `frontend/pages/pedidos.php` para registrar pedidos desde WhatsApp y confirmar pagos.

3. **Envíos y devoluciones**

   * `backend/models/Envio.php`, `backend/models/Devolucion.php`.
   * `backend/api/envios.php`, `backend/api/devoluciones.php`.
   * Actualizar reportes y kardex cuando se registren envíos y devoluciones.

4. **Reportes / kardex**

   * `backend/controllers/ReportesController.php`, `backend/api/reportes.php`.
   * `frontend/pages/reportes.php` para mostrar:

     * Reporte diario de ventas.
     * Kardex por producto (movimientos de entrada y salida).

---

## Paso 8. Separación frontend/backend y uso de parciales

1. Explorar la estructura de carpetas:

   * `frontend/pages` → páginas como `login.php`, `clientes.php`, `productos.php`, etc.
   * `frontend/partials` → componentes reutilizables:

     * `navbar.php`
   * `backend/api` → endpoints para AJAX.
   * `backend/models` → clases que hablan con la BD.
   * `backend/controllers` → lógica de negocio.

2. Revisar `frontend/partials/navbar.php`:

   * Debe leer la información del usuario desde `$_SESSION`.
   * Debe incluir enlaces a:

     * Clientes
     * Productos
     * Drops
     * Pedidos
     * Reportes
   * El botón de logout debe llamar a `backend/api/auth.php?action=logout`.

3. Añadir más páginas si se requiere (por ejemplo, un `dashboard.php` con resumen del día).

---

## Paso 9. Ajustes sugeridos de estudio

* Extender la tabla `clientes` con más campos (por ejemplo, redes sociales, tipo de cliente).
* Añadir validaciones del lado del cliente (HTML5 y jQuery) en los formularios.
* Implementar filtros avanzados en DataTables (por talla, color, barrio, fechas).
* Completar los módulos de:

  * Drops
  * Pedidos
  * Pagos
  * Envíos
  * Devoluciones
* Mejorar la interfaz gráfica de las cards generadas para estados de WhatsApp
  (tipografías, colores, logo y sello “AGOTADO”).

```


