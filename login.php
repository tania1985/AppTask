<?php
// Iniciar sesión al principio del archivo
session_start();

// Incluir archivo de configuración y conexión a la base de datos
include('includes/conexiondb.php');  // Asegúrate de que el archivo config.php está en la carpeta 'includes'

// Comprobar si el formulario de login ha sido enviado
if (isset($_POST['username'])) {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar las credenciales en la base de datos
    try {
        // Consulta para buscar al usuario por su nombre de usuario
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && password_verify($password, $user['password'])) {
            // La contraseña es correcta, iniciamos la sesión
            $_SESSION['user_id'] = $user['id'];      // Guardamos el ID del usuario en la sesión
            $_SESSION['username'] = $user['username']; // Guardamos el nombre de usuario en la sesión

            // Redirigir al dashboard o página principal
            header("Location: dashboard.php");
            exit(); // Asegúrate de hacer un exit después de la redirección
        } else {
            $error = "Credenciales incorrectas. Intenta de nuevo.";
        }
    } catch (PDOException $e) {
        // Manejar cualquier error con la conexión o la consulta
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>

    <!-- Formulario de login -->
    <form method="POST" action="">
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" name="login" value="Iniciar sesión">
    </form>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
