<?php
include 'includes/auth.php';
include 'includes/conexiondb.php';

// Crear tarea
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO tareas (titulo, descripcion, user_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $descripcion, $user_id]);
}

// Obtener tareas
$sql = "SELECT * FROM tareas WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$tareas = $stmt->fetchAll();
?>

<?php include 'views/header.php'; ?>

<h2>Mis Tareas</h2>

<form method="POST">
    <input type="text" name="titulo" placeholder="Título" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <button type="submit" class="btn">Agregar</button>
</form>

<ul>
    <?php foreach ($tareas as $tarea): ?>
        <li>
            <strong><?php echo $tarea['titulo']; ?></strong> - <?php echo $tarea['descripcion']; ?>
            <a href="delete_task.php?id=<?php echo $tarea['id']; ?>">Eliminar</a>
        </li>
    <?php endforeach; ?>
</ul>

<a href="includes/logout.php" class="btn">Cerrar sesión</a>

<?php include 'views/footer.php'; ?>
