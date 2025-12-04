<?php
// frontend/pages/login.php

// Si el usuario ya está logueado, lo puedes enviar directo a clientes o dashboard
require_once __DIR__ . '/../../backend/core/session.php';
if (isset($_SESSION['usuario_id'])) {
    header("Location: clientes.php"); // o la página principal que quieras
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login - AzuraShirts</title>

    <!-- Si usas Bootstrap, puedes dejar esto, sino quítalo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="card card-login shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3 text-center">AzuraShirts</h1>
            <p class="text-center text-muted mb-4">Inicia sesión para gestionar la tienda</p>

            <form id="formLogin" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Entrar
                </button>
            </form>

            <p id="mensaje" class="mt-3 text-center"></p>
        </div>
    </div>
</div>

<script>
document.getElementById('formLogin').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const mensaje = document.getElementById('mensaje');

    try {
        const res = await fetch('../../backend/api/auth.php?action=login', {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (data.success) {
            mensaje.style.color = 'green';
            mensaje.textContent = data.message || 'Inicio de sesión correcto';

            // Redirigir a la página protegida principal (ajusta si quieres otra)
            window.location.href = 'clientes.php';
        } else {
            mensaje.style.color = 'red';
            mensaje.textContent = data.message || 'Usuario o contraseña incorrectos';
        }
    } catch (err) {
        console.error(err);
        mensaje.style.color = 'red';
        mensaje.textContent = 'Error al conectar con el servidor';
    }
});
</script>

</body>
</html>
