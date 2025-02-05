<?php
// Conexión a la base de datos
$host = 'localhost';
$usuario = 'chicas'; // Cambia con tu usuario
$contraseña = '1234'; // Cambia con tu contraseña
$base_de_datos = 'AppTask';

try {
    $dsn = "mysql:host=$host;dbname=$base_de_datos";
    $conexion = new PDO($dsn, $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recibir los datos del formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];

        // Insertar la tarea en la base de datos
        $sql = "INSERT INTO tareas (titulo, descripcion) VALUES (:titulo, :descripcion)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);

        if ($stmt->execute()) {
            echo "Tarea creada con éxito.";
        } else {
            echo "Error al crear la tarea.";
        }
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

<br><br>
<a href="index.php">Volver a crear otra tarea</a>
