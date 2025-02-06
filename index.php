<?php 
session_start();
include 'views/header.php'; ?>

<h1>Bienvenido a la Web de Tareas</h1>
<p>Gestiona tus tareas fácilmente.</p>

<?php if (!isset($_SESSION['user_id'])): ?>
    <a href="registrer.php" class="btn">Registrarse</a>
    <a href="login.php" class="btn">Iniciar sesión</a>
<?php endif; ?>

<?php include 'views/footer.php'; ?>
