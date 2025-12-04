<?php
// frontend/pages/productos.php
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - AzuraShirts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .header {
            padding: 15px 0;
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        .logo {
            font-weight: 700;
            font-size: 1.3rem;
        }
        .grid-productos {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        }
        .card-producto img {
            height: 180px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<header class="header">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">👕 AzuraShirts</div>
        <nav class="d-flex gap-3">
            <a href="productos.php" class="link-secondary text-decoration-none">Catálogo</a>
            <a href="pedidos.php" class="link-secondary text-decoration-none">Hacer pedido</a>
            <a href="login.php" class="link-secondary text-decoration-none">Admin</a>
        </nav>
    </div>
</header>

<main class="container mb-5">
    <h1 class="h3 mb-4">Nuestras camisetas</h1>

    <section class="grid-productos">
        <!-- Tarjeta 1 -->
        <article class="card card-producto"
                 data-nombre="Camiseta básica blanca"
                 data-sku="CAM-001"
                 data-precio="45000"
                 data-imagen="../../backend/img/Camiseta.jpg">
            <img src="../../backend/img/Camiseta.jpg" class="card-img-top" alt="Camiseta básica blanca">
            <div class="card-body">
                <h5 class="card-title">Camiseta básica blanca</h5>
                <p class="card-text text-muted mb-2">Perfecta para uso diario.</p>
                <p class="fw-semibold mb-3">$45.000</p>
                <button class="btn btn-primary btn-sm btn-hacer-pedido">Hacer pedido</button>
            </div>
        </article>

        <!-- Aquí puedes agregar más productos estáticos si quieres -->
        <article class="card card-producto"
                 data-nombre="Camiseta Nike"
                 data-sku="NIKE-001"
                 data-precio="75000"
                 data-imagen="../../backend/img/nike.jpg">
            <img src="../../backend/img/nike.jpg" class="card-img-top" alt="Camiseta Nike">
            <div class="card-body">
                <h5 class="card-title">Camiseta Nike</h5>
                <p class="card-text text-muted mb-2">Estilo deportivo.</p>
                <p class="fw-semibold mb-3">$75.000</p>
                <button class="btn btn-primary btn-sm btn-hacer-pedido">Hacer pedido</button>
            </div>
        </article>

    </section>
</main>

<script src="../../backend/js/productos.js"></script>
</bod
