<?php
// public/index.php
// Punto de entrada público de la tienda

require_once __DIR__ . '/../backend/core/session.php';
$logeado = isset($_SESSION['usuario_id']);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Inicio - AzuraShirts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f4f6fb, #dde9ff);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            min-height: 100vh;
        }
        .inicio-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card-inicio {
            max-width: 800px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
            background: #ffffff;
        }
        .logo-inicio {
            width: 140px;
            height: 140px;
            object-fit: contain;
        }
        .badge-marca {
            background: #0d6efd11;
            color: #0d6efd;
            border-radius: 999px;
            padding: 4px 14px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
    </style>
</head>
<body>

<div class="inicio-wrapper">
    <div class="card card-inicio border-0">
        <div class="card-body p-4 p-md-5 text-center">

            <!-- LOGO (ajusta la ruta si tu logo está en otra carpeta) -->
            <img src="../Logo.png" alt="Logo AzuraShirts" class="logo-inicio mb-3">

            <div class="mb-2">
                <span class="badge-marca">Tienda de camisetas </span>
            </div>

            <h1 class="h3 mb-2">Bienvenido a <span class="text-primary">AzuraShirts</span></h1>
            <p class="text-muted mb-4">
                Aquí podrás ver nuestro catálogo de camisetas, hacer pedidos rápidos
                por web y, si eres administrador, gestionar clientes y pedidos.
            </p>

            <div class="row g-3 justify-content-center mb-3">
                <div class="col-12 col-md-4">
                    <a href="../frontend/pages/productos.php" class="btn btn-primary w-100">
                        Ver catálogo de camisetas
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="../frontend/pages/pedidos.php" class="btn btn-outline-primary w-100">
                        Hacer un pedido
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <?php if ($logeado): ?>
                        <a href="../frontend/pages/inicio.php" class="btn btn-outline-secondary w-100">
                            Ir al panel de administración
                        </a>
                    <?php else: ?>
                        <a href="../frontend/pages/login.php" class="btn btn-outline-secondary w-100">
                            Soy administrador
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <p class="text-muted small mb-0">
                Proyecto académico · Tienda virtual AzuraShirts
            </p>
        </div>
    </div>
</div>

</body>
</html>
