<?php
// frontend/pages/logout.php
require_once __DIR__ . '/../../backend/core/session.php';

// Cerrar la sesión
session_unset();
session_destroy();

// Redirigir al login
header('Location: login.php');
exit;
