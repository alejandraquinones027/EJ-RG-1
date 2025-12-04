<?php
// frontend/pages/pedidos_admin.php
require_once __DIR__ . '/../../backend/core/session.php';
require_login_page();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos - AzuraShirts</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tus estilos generales -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- HEADER IGUAL AL DE CLIENTES, PERO CON "VOLVER A CLIENTES" -->
<header class="header">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">AzuraShirts - Admin</div>

        <div class="d-flex align-items-center gap-2">
            <a href="clientes.php" class="btn btn-outline-primary btn-sm">
                Volver a clientes
            </a>

            <span class="text-muted small">
                Usuario:
                <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? ''); ?></strong>
            </span>

            <a href="logout.php" class="btn btn-outline-danger btn-sm">
                Cerrar sesión
            </a>
        </div>
    </div>
</header>

<!-- CONTENIDO PRINCIPAL -->
<div class="wrapper container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Pedidos</h1>
    </div>

    <div class="tabla-wrapper">
        <p class="text-muted mb-2">
            Listado de pedidos registrados en el sistema.
        </p>

        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Cantidad</th>
                        <th>Nombre cliente</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody id="tbodyPedidos">
                    <!-- filas generadas por JS -->
                </tbody>
            </table>
        </div>

        <p id="mensajePedidos" class="mt-2 text-center text-muted"></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tbody  = document.getElementById('tbodyPedidos');
    const msg    = document.getElementById('mensajePedidos');
    const apiUrl = '../../backend/api/pedidos.php';

    const cargarPedidos = async () => {
        tbody.innerHTML = '';
        msg.textContent = 'Cargando pedidos...';
        msg.classList.remove('text-danger');
        msg.classList.add('text-muted');

        try {
            const res  = await fetch(apiUrl + '?action=list');
            const data = await res.json();

            if (!data.success) {
                msg.textContent = data.message || 'No se pudieron cargar los pedidos.';
                msg.classList.remove('text-muted');
                msg.classList.add('text-danger');
                return;
            }

            const pedidos = data.data || [];

            if (pedidos.length === 0) {
                msg.textContent = 'Todavía no hay pedidos registrados.';
                msg.classList.remove('text-danger');
                msg.classList.add('text-muted');
                return;
            }

            msg.textContent = '';
            pedidos.forEach(p => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${p.id ?? ''}</td>
                    <td>${p.producto ?? ''}</td>
                    <td>${p.talla ?? ''}</td>
                    <td>${p.color ?? ''}</td>
                    <td>${p.cantidad ?? ''}</td>
                    <td>${p.nombre_cliente ?? ''}</td>
                    <td>${p.telefono ?? ''}</td>
                    <td>${p.direccion ?? ''}</td>
                    <td>${p.fecha ?? ''}</td>
                `;
                tbody.appendChild(tr);
            });

        } catch (error) {
            console.error(error);
            msg.textContent = 'Error al conectar con la API de pedidos.';
            msg.classList.remove('text-muted');
            msg.classList.add('text-danger');
        }
    };

    cargarPedidos();
});
</script>

</body>
</html>
