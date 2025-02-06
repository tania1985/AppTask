<?php
session_start();

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

// Obtener el user_id desde la sesión
$user_id = $_SESSION['user_id'];

// Variables para manejo de errores
$error = "";
$success = "";

// Obtener los datos actuales del usuario
$query = "SELECT username FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el usuario existe
if (!$user) {
    $error = "El usuario no existe en la base de datos.";
} else {
    // Procesar el formulario de actualización del perfil
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);

        // Validar el campo
        if (empty($username)) {
            $error = "Por favor, ingrese un nuevo nombre de usuario.";
        } else {
            // Actualizar los datos del usuario
            try {
                $query = "UPDATE users SET username = :username WHERE id = :user_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':user_id', $user_id);

                $stmt->execute();
                $success = "Perfil actualizado exitosamente.";
            } catch (PDOException $e) {
                $error = "Error al actualizar el perfil: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="styles.css"> <!-- Ruta al archivo CSS -->
</head>
<body>

<!-- Incluir el Header -->
<?php include('views/header.php'); ?>

<h2>Editar Perfil</h2>

<!-- Mostrar mensajes de éxito o error -->
<?php if ($error): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p class="success"><?php echo $success; ?></p>
<?php endif; ?>

<!-- Formulario para editar perfil -->
<form method="POST">
    <label for="username">Nuevo nombre de usuario:</label><br>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

    <button type="submit">Actualizar Perfil</button>
</form>

<!-- Enlace para volver al Dashboard -->
<a href="dashboard.php">Volver al Dashboard</a>

<!-- Incluir el Footer -->
<?php include('views/footer.php'); ?>

</body>
</html>
