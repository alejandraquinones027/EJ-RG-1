<?php

$host = "localhost";
$port = "5432";
$dbname = "azurashirts";
$user = "postgres";
$pass = "Tumaco2025";            // Cambia si ya pusiste otra contraseña

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $conexion = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

} catch (PDOException $e) {
    die(" Error al conectar a PostgreSQL: " . $e->getMessage());
}
