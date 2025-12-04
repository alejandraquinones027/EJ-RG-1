<?php
// frontend/pages/productos.php
require_once __DIR__ . '/../../backend/models/Producto.php';

$productos = Producto::all();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - AzuraShirts</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tus estilos generales -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="header">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">👕 AzuraShirts</div>
        <a href="../../public/index.php" class="btn btn-outline-secondary btn-sm">
            ← Volver al inicio
        </a>
    </div>
</header>

<main class="container mb-5">
    <h1 class="h3 mb-4">Nuestras camisetas</h1>

    <?php if (empty($productos)): ?>
        <p class="text-muted">Todavía no hay productos registrados.</p>
    <?php else: ?>
        <section class="grid-productos">
            <?php foreach ($productos as $p): ?>
                <?php
                    $nombre  = $p['nombre'] ?? '';
                    $sku     = $p['sku'] ?? '';
                    $precio  = $p['precio'] ?? 0;
                    $img     = $p['imagen'] ?? '';
                    $desc    = $p['descripcion'] ?? 'Camiseta disponible.';
                ?>
                <article class="card card-producto"
                         data-nombre="<?php echo htmlspecialchars($nombre); ?>"
                         data-sku="<?php echo htmlspecialchars($sku); ?>"
                         data-precio="<?php echo htmlspecialchars($precio); ?>"
                         data-imagen="<?php echo '../../backend/img/' . htmlspecialchars($img); ?>">

                    <?php if ($img): ?>
                        <img src="<?php echo '../../backend/img/' . htmlspecialchars($img); ?>"
                             class="card-img-top"
                             alt="<?php echo htmlspecialchars($nombre); ?>">
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($nombre); ?></h5>
                        <p class="card-text text-muted mb-2">
                            <?php echo htmlspecialchars($desc); ?>
                        </p>
                        <p class="fw-semibold mb-3">
                            $<?php echo number_format($precio, 0, ',', '.'); ?>
                        </p>

                        <!-- Enlace al formulario de pedido -->
                        <a href="pedidos.php" class="btn btn-primary btn-sm mt-auto">
                            Hacer pedido
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</main>

</body>
</html>
