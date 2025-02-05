<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirigir a la página de login
    header("Location: login.php");
    exit();
}

// Verificar si la variable 'username' está disponible en la sesión
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuario desconocido';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlazar a tu archivo de estilos -->
</head>
<body>
    <!-- Header -->
    <?php include("views/header.php"); ?>

    <!-- Contenido del Dashboard -->
    <div class="dashboard-container">
        <h1>Bienvenido, <?php echo htmlspecialchars($username); ?>!</h1>

        <p>Esta es tu página de dashboard. Desde aquí podrás gestionar tus tareas de mantenimiento o soporte.</p>

        <div class="dashboard-actions">
            <a href="crear_tarea.php">Crear una nueva tarea</a>
            <a href="ver_tareas.php">Ver tus tareas</a>
            <a href="editar_perfil.php">Editar perfil</a>
        </div>

        <!-- Enlace para cerrar sesión -->
        <a href="logout.php" class="logout">Cerrar sesión</a>
    </div>

    <!-- Footer -->
    <?php include("views/footer.php"); ?>
</body>
</html>
