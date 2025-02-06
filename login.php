<?php
// Iniciar sesión al principio del archivo
session_start();

// Incluir conexión a la base de datos
include('includes/conexiondb.php');

// Verificar si el formulario de login ha sido enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Validar contraseña
        if ($user && password_verify($password, $user['password'])) {
            // Almacenar datos en sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirigir al dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "❌ Credenciales incorrectas. Intenta de nuevo.";
        }
    } catch (PDOException $e) {
        $error = "⚠️ Error en la conexión: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Web de Tareas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- Incluir Header -->
<?php include("views/header.php"); ?>

<main class="landing-container">
    <section class="hero">
        <h2>Organiza y gestiona tus tareas de mantenimiento de forma eficiente</h2>
        <p>Con nuestra plataforma, puedes administrar tus tareas, asignarlas y darles seguimiento fácilmente.</p>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <!-- Enlaces eliminados -->
        <?php else: ?>
            <a href="dashboard.php" class="btn btn-primary">Ir al Dashboard</a>
        <?php endif; ?>
          <!-- Formulario de Login -->
    <section class="login-form">
        <h1>Iniciar Sesión</h1>

        <form method="POST" action="">
            <label for="username">Nombre de usuario:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="login" class="btn btn-primary">Iniciar sesión</button>
        </form>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </section>
</main>

<!-- Incluir Footer -->
<?php include("views/footer.php"); ?>

</body>
</html>
