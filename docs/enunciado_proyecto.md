# Proyecto: Sistema de Tienda Virtual por WhatsApp (Venta de Ropa) 👗📱

## Contexto

El emprendimiento de venta de ropa opera como **tienda virtual por WhatsApp**, usando
principalmente los **Estados** y el **chat** como vitrina de sus productos, sin catálogo
público externo.

Actualmente la gestión se hace de forma manual (chats, notas y hojas de cálculo), lo que
genera:

- Ofrecer prendas que ya están agotadas.
- Pérdida de tiempo repitiendo la misma información en cada conversación.
- Dificultad para identificar qué publicaciones o “drops” han funcionado mejor.
- Poco control sobre pedidos, pagos, envíos y devoluciones.
- Falta de un histórico claro del movimiento diario de inventario.

El sistema propuesto es una aplicación web clásica que permitirá:

- Administrar inventario de prendas por variantes **modelo–talla–color**, con un **SKU único**.
- Generar **cards** listas para publicar en Estados y posts (1080×1920 y 1080×1080), con
  foto, código/SKU, talla, color, precio, logo y QR a WhatsApp, incluyendo un sello
  automático **“AGOTADO”** cuando el producto no tenga stock.
- Gestionar **drops** (publicaciones o colecciones) de ropa.
- Registrar pedidos que llegan por el chat de WhatsApp y controlar reservas de stock.
- Registrar pagos, envíos y devoluciones, y generar reportes diarios y kardex por producto.

El sistema debe desarrollarse como una aplicación web clásica usando:

- **Frontend:** HTML, CSS, Bootstrap, jQuery, DataTables
- **Backend:** PHP con variables de sesión, organizado en carpetas
- **Base de datos:** PostgreSQL
- **Comunicación:** AJAX (sin recargar la página en las operaciones principales)

---

## Requerimientos funcionales

1. **Autenticación y roles**
   - Debe existir una pantalla de login.
   - Solo usuarios autenticados pueden acceder al sistema.
   - Las credenciales se validan contra la tabla `usuarios` en PostgreSQL.
   - Deben manejarse al menos los roles **ADMINISTRADOR** y **VENDEDOR**.
   - Debe utilizarse manejo de **sesión en PHP**.
   - Los cambios relevantes (creación/edición de usuarios, configuración) deben registrarse
     en una **bitácora**.

2. **Gestión de clientes**
   - Listado de clientes en una tabla interactiva con:
     - Búsqueda
     - Ordenamiento
     - Paginación
   - La tabla debe implementarse con **DataTables**.
   - Debe permitir:
     - Crear un nuevo cliente
     - Editar un cliente existente
     - Eliminar (lógicamente) un cliente
   - Datos mínimos: identificación, nombre, WhatsApp, barrio, dirección.
   - Todas las operaciones se deben realizar vía **AJAX**, consumiendo APIs en PHP.

3. **Gestión de productos e inventario**
   - Registrar productos y sus variantes **modelo–talla–color**, generando un **SKU único**
     por combinación.
   - Definir para cada variante: nombre, marca, talla, color, costo, precio y stock.
   - No se debe permitir stock negativo.
   - Permitir activar/desactivar productos sin perder histórico (eliminación lógica).
   - Disponer de un catálogo interno con:
     - Búsqueda por nombre o SKU.
     - Filtros por talla, color y disponibilidad (con stock / agotado).

4. **Gestión de drops y generación de cards**
   - Crear y administrar **drops** (colecciones de prendas) con estados:
     - BORRADOR / PUBLICADO / CERRADO.
   - Asociar productos/variantes a cada drop.
   - Generar **cards** para Estados/Posts en dos formatos:
     - 1080×1080
     - 1080×1920
   - Cada card debe incluir: foto, código/SKU, talla, color, precio, logo y QR a WhatsApp.
   - Cuando un producto esté sin stock, la card debe mostrar un sello diagonal
     **“AGOTADO”** con contraste legible.

5. **Pedidos, pagos, envíos y devoluciones**
   - Registrar pedidos generados desde el chat de WhatsApp, asociados a un cliente.
   - El pedido debe incluir líneas con SKU, cantidad y precio.
   - Manejar una **reserva de 30 minutos** sobre el stock de los productos del pedido, sin
     permitir stock negativo.
   - Registrar **pagos** indicando método (efectivo, transferencia, contraentrega), valor y
     soporte.
   - Registrar **envíos/entregas** indicando: tipo (moto, recogida, transportadora), costo,
     fecha y estado (en tránsito, entregado).
   - Registrar **devoluciones o cambios de talla**, indicando:
     - Pedido al que pertenecen
     - Motivo
     - Prendas devueltas
     - Si el stock se reingresa o no
     - Nota de crédito si aplica

6. **Reportes y kardex**
   - Generar un **reporte diario** con:
     - Totales por medio de pago
     - Pedidos entregados
     - Anulaciones
     - Devoluciones
     - Productos más vendidos
   - Generar un **kardex por producto** con los movimientos cronológicos:
     - Entradas (compras, reingresos por devoluciones, ajustes)
     - Salidas (ventas, bajas, ajustes)
     - Saldo resultante
   - Permitir exportar los reportes en formatos **PDF y Excel**.

7. **Múltiples páginas**
   - Debe existir al menos:
     - `login.php`: pantalla de autenticación.
     - `dashboard.php`: resumen del día (pedidos, ventas, productos agotados).
     - `clientes.php`: módulo de clientes.
     - `productos.php`: módulo de inventario.
     - `drops.php`: módulo de drops y cards.
     - `pedidos.php`: módulo de pedidos.
     - `reportes.php`: reportes diarios y kardex.
   - Todas las páginas internas deben incluir un **navbar** común (parcial/plantilla).

8. **Arquitectura**
   - Debe existir una separación explícita entre:
     - `frontend/` (páginas, assets)
     - `backend/` (API, modelos, controladores, configuración)
   - El backend debe exponer endpoints en `/backend/api/*.php`.
   - Las consultas a la base de datos se deben realizar usando **PDO**.

---

## Requerimientos no funcionales

- Código organizado y comentado.
- Nombres de carpetas y archivos coherentes con la arquitectura propuesta.
- Manejo básico de errores (mensajes si falla el login o alguna operación CRUD).
- Validaciones mínimas en los formularios (campos obligatorios, formatos básicos).
- **Usabilidad:** generación de cards en ≤ 2 segundos; sello “AGOTADO” legible (contraste mínimo AA).
- **Integridad:** no permitir stock negativo ni SKUs duplicados.
- **Portabilidad:** las imágenes exportadas de cards deben pesar ≤ 400 KB; los reportes deben
  poder descargarse como PDF y Excel.
- **Trazabilidad:** bitácora de cambios en configuración, precios y otras acciones relevantes.

---

## Entregables

1. Código fuente completo del proyecto con la estructura de carpetas organizada (`frontend/`,
   `backend/`, `docs/`, `public/`).
2. Script SQL para crear la base de datos y todas las tablas necesarias para la tienda virtual
   por WhatsApp.
3. Breve documento (1–2 páginas) que explique:
   - Estructura de carpetas.
   - Flujo de autenticación.
   - Flujo general desde que se genera una card y se publica un drop, hasta el registro del
     pedido, el pago, el envío y, en caso necesario, la devolución.
