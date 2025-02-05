<?php
// Comprobar si la sesión no ha sido iniciada aún
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Solo iniciar la sesión si no está activa
}

// Aquí va tu código de conexión a la base de datos
include('config.php'); 

try {
    $pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Aquí puedes continuar con tu lógica de base de datos, como el registro o validación
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
