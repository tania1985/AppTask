<?php
session_start();
include 'includes/conexiondb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p class='error'>Usuario o contraseña incorrectos.</p>";
    }
}
?>

<?php include 'views/header.php'; ?>

<h2>Iniciar Sesión</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit" class="btn">Ingresar</button>
</form>

<?php include 'views/footer.php'; ?>
