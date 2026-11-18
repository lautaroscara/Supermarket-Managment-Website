<?php
$conexion = new mysqli("host", "user", "password", "database_name");

if ($conexion->connect_error) {
    http_response_code(500);
    die("No se pudo conectar con la base de datos.");
}

$conexion->set_charset("utf8mb4");

function escapar($valor): string {
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}