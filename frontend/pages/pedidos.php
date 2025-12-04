<?php
// frontend/pages/pedidos.php
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hacer pedido - AzuraShirts</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tu CSS general -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="header">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">AzuraShirts</div>
        <a href="../../public/index.php" class="btn btn-outline-secondary btn-sm">
            ← Volver al inicio
        </a>
    </div>
</header>

<main class="container wrapper-pedido mb-5">
    <div class="card-pedido-form bg-white p-4">
        <h1 class="h4 mb-3 text-center">Formulario de pedido</h1>
        <p class="text-muted text-center mb-4">
            Completa tus datos para que podamos contactarte por WhatsApp.
        </p>

        <form id="formPedido">
            <div class="mb-3">
                <label class="form-label" for="producto">Producto</label>
                <select id="producto" class="form-select" required>
                    <option value="">Cargando productos...</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="talla">Talla</label>
                <select id="talla" class="form-select" required>
                    <option value="">Selecciona un producto primero</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="color">Color</label>
                <select id="color" class="form-select" required>
                    <option value="">Selecciona un producto primero</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" class="form-control" value="1" min="1" required>
            </div>

            <hr>

            <div class="mb-3">
                <label class="form-label" for="nombre_cliente">Tu nombre</label>
                <input type="text" id="nombre_cliente" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="telefono">Teléfono / WhatsApp</label>
                <input type="text" id="telefono" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="direccion">Dirección (opcional)</label>
                <input type="text" id="direccion" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Enviar pedido
            </button>
        </form>

        <p id="mensaje" class="mt-3 text-center"></p>
    </div>
</main>

<script src="../../backend/js/pedidos.js"></script>
</body>
</html>
