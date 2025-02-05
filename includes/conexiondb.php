<?php
include("includes/config.php");

// Obtener las variables de los datos del usuario desde un formulario (o definirlas directamente)
$username = "usuarioEjemplo"; // Cambia esto por los datos que recibes desde el formulario
$nombre = "NombreEjemplo";    // Cambia esto por los datos que recibes desde el formulario
$apellidos = "ApellidoEjemplo"; // Cambia esto por los datos que recibes desde el formulario
$password = "miPassword123"; // Aquí deberías obtener la contraseña que el usuario ingresa

// Conexión PDO
$host = HOST; // o la IP de tu servidor MySQL
$user = DB_USER;
$passwordDB = DB_PASS; // Renombré esta variable para evitar confusión con la contraseña del usuario
$database = DB_DATABASE;

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $passwordDB);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Encriptar la contraseña antes de guardarla
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL
    $sql = "INSERT INTO users (username, password, nombre, apellidos) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
   
    // Ejecutar la consulta y pasar los valores
    if ($stmt->execute([$username, $hashedPassword, $nombre, $apellidos])) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "Error al registrar el usuario.";
    }
} catch (PDOException $e) {
    // Si hay un error con la conexión a la base de datos
    echo "Error de conexión: " . $e->getMessage();
}
?>
