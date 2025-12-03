<?php
require_once __DIR__ . '/../../backend/core/session.php';
require_login_page();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Acerca de - Gestor Clientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../partials/navbar.php'; ?>

<div class="container">
  <h3>Acerca de esta aplicación</h3>
  <p>
    Esta aplicación se desarrolló como ejemplo para la asignatura de Programación Web.
    Integra:
  </p>
  <ul>
    <li>Bootstrap para el diseño responsivo.</li>
    <li>jQuery y AJAX para las peticiones asíncronas.</li>
    <li>DataTables para el manejo avanzado de tablas.</li>
    <li>PHP con variables de sesión para la autenticación.</li>
    <li>PostgreSQL como gestor de base de datos.</li>
  </ul>
  <p>
    El objetivo pedagógico es que el estudiante comprenda la separación entre frontend y backend,
    el consumo de APIs desde el navegador y la implementación completa de un CRUD.
  </p>
</div>

</body>
</html>
