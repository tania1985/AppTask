<?php
session_start(); // Iniciar sesión para verificar que el usuario está autenticado

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

// Variables para manejo de errores
$error = "";
$success = "";

// Obtener el user_id desde la sesión
$user_id = $_SESSION['user_id'];

// Verificar si el user_id existe en la tabla users
$query = "SELECT COUNT(*) FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$userExists = $stmt->fetchColumn();

if ($userExists == 0) {
    $error = "El usuario no existe en la base de datos.";
} else {
    // Procesar el formulario de creación de tarea
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = trim($_POST['titulo']);
        $descripcion = trim($_POST['descripcion']);
        $estado_id = $_POST['estado_id']; // Obtener el estado_id del formulario
        $fecha_creacion = date('Y-m-d H:i:s'); // Fecha y hora actual

        // Validar los campos
        if (empty($titulo) || empty($descripcion) || empty($estado_id)) {
            $error = "Por favor, complete todos los campos.";
        } else {
            // Insertar la tarea en la base de datos
            try {
                $query = "INSERT INTO tareas (titulo, descripcion, fecha_creacion, estado_id, user_id) 
                          VALUES (:titulo, :descripcion, :fecha_creacion, :estado_id, :user_id)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':fecha_creacion', $fecha_creacion);
                $stmt->bindParam(':estado_id', $estado_id);
                $stmt->bindParam(':user_id', $user_id);

                $stmt->execute();
                $success = "Tarea creada exitosamente.";
            } catch (PDOException $e) {
                $error = "Error al crear la tarea: " . $e->getMessage();
            }
        }
    }
}
?>

<!-- HTML y formulario permanecen igual -->


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tarea</title>
</head>
<body>

<!-- Incluir el Header -->
<?php include('views/header.php'); ?>

<h2>Crear una nueva tarea</h2>

<!-- Mostrar mensajes de éxito o error -->
<?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>

<!-- Formulario para crear tarea -->
<form method="POST">
    <label for="titulo">Título de la tarea:</label><br>
    <input type="text" id="titulo" name="titulo" required><br><br>
    
    <label for="descripcion">Descripción:</label><br>
    <textarea id="descripcion" name="descripcion" required></textarea><br><br>

    <label for="estado">Estado:</label><br>
    <select id="estado" name="estado_id" required>
        <option value="">Seleccione un estado</option>
        <option value="1">En proceso</option>
        <option value="2">Terminado</option>
    </select><br><br>

    <button type="submit">Crear tarea</button>
</form>


<!-- Enlace para volver al dashboard -->
<a href="dashboard.php">Volver al Dashboard</a>

<!-- Incluir el Footer -->
<?php include('views/footer.php'); ?>

</body>
</html>
