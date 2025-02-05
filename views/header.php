<?php 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web de Tareas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header>
    <h1>Web de Tareas de Mantenimiento</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Mis Tareas</a></li>
                <li><a href="includes/logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="register.php">Registrarse</a></li>
                <li><a href="login.php">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
