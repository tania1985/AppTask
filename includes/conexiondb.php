<?php
// Comprobar si la sesión no ha sido iniciada aún
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Solo iniciar la sesión si no está activa
}

define("HOST", "localhost");
define("DB_USER", "chicas");
define("DB_PASS", "1234");
define("DB_DATABASE", "AppTask");

try {
    $pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Aquí puedes continuar con tu lógica de base de datos, como el registro o validación
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}
?>
