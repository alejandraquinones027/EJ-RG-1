<?php
// frontend/pages/pedidos_admin.php
require_once __DIR__ . '/../../backend/core/session.php';
require_login_page(); // solo usuarios logueados
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pedidos - AzuraShirts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .wrapper {
            padding: 20px;
        }
        .tabla-wrapper {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
    </style>
</head>
<body>

<div class="wrapper container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Pedidos</h1>
        <div class="d-flex gap-2 align-items-center">
            <a href="clientes.php" class="btn btn-outline-secondary btn-sm">
                Clientes
            </a>
            <a href="productos.php" class="btn btn-outline-secondary btn-sm">
                Catálogo público
            </a>
            <span class="text-muted">
                Usuario: <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? ''); ?></strong>
            </span>
            <a href="../../backend/api/auth.php?action=logout" class="btn btn-outline-danger btn-sm">
                Cerrar sesión
            </a>
        </div>
    </div>

    <div class="tabla-wrapper">
        <p class="text-muted mb-2">
            Pedidos realizados desde la tienda.
        </p>

        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Producto</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Cant.</th>
                        <th>Estado pago</th>
                        <th>Estado envío</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody id="tbodyPedidos">
                    <!-- filas desde la API -->
                </tbody>
            </table>
        </div>

        <p id="mensajePedidos" class="mt-2 text-center text-muted"></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const tbody = document.getElementById('tbodyPedidos');
    const msg   = document.getElementById('mensajePedidos');

    try {
        const res = await fetch('../../backend/api/pedidos.php?action=list');
        const data = await res.json();

        if (!data.success) {
            msg.textContent = data.message || 'No se pudieron cargar los pedidos.';
            msg.classList.remove('text-muted');
            msg.classList.add('text-danger');
            return;
        }

        const pedidos = data.data || [];

        if (pedidos.length === 0) {
            msg.textContent = 'No hay pedidos registrados aún.';
            return;
        }

        pedidos.forEach(p => {
            const tr = document.createElement('tr');

            tr.innerHTML = `
                <td>${p.id}</td>
                <td>${p.nombre_cliente ?? ''}</td>
                <td>${p.telefono ?? ''}</td>
                <td>${p.producto_nombre ?? ''} (${p.sku ?? ''})</td>
                <td>${p.talla ?? ''}</td>
                <td>${p.color ?? ''}</td>
                <td>${p.cantidad ?? ''}</td>
                <td>${p.estado_pago ?? ''}</td>
                <td>${p.estado_envio ?? ''}</td>
                <td>${p.creado_en ?? ''}</td>
            `;

            tbody.appendChild(tr);
        });

    } catch (error) {
        console.error(error);
        msg.textContent = 'Error al conectar con la API de pedidos.';
        msg.classList.remove('text-muted');
        msg.classList.add('text-danger');
    }
});
</script>

</body>
</html>
