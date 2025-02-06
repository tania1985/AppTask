<?php
session_start(); // Iniciar sesión para verificar si el usuario está autenticado

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}

$host = 'localhost';
$dbname = 'AppTask';
$username = 'chicas';
$password = '1234';

try {
    // Crear conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Obtener las tareas desde la base de datos
$query = "SELECT t.id, t.titulo, t.descripcion, t.fecha_creacion, e.nombre AS estado, u.username 
          FROM tareas t 
          JOIN estados e ON t.estado_id = e.id
          JOIN users u ON t.user_id = u.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Tareas</title>
    <link rel="stylesheet" href="ruta/a/tu/archivo.css">  <!-- Ruta al archivo CSS -->
</head>
<body>

<!-- Incluir el Header -->
<?php include('views/header.php'); ?>

<h2>Lista de Tareas</h2>

<!-- Mostrar las tareas en una tabla -->
<table border="1" cellspacing="0" cellpadding="10" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha de Creación</th>
            <th>Estado</th>
            <th>Usuario</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tareas as $tarea): ?>
            <tr>
                <td><?php echo htmlspecialchars($tarea['id']); ?></td>
                <td><?php echo htmlspecialchars($tarea['titulo']); ?></td>
                <td><?php echo htmlspecialchars($tarea['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($tarea['fecha_creacion']); ?></td>
                <td><?php echo htmlspecialchars($tarea['estado']); ?></td>
                <td><?php echo htmlspecialchars($tarea['username']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Enlace para volver al Dashboard -->
<a href="dashboard.php">Volver al Dashboard</a>

<!-- Incluir el Footer -->
<?php include('views/footer.php'); ?>

</body>
</html>
