<?php
// Incluir la configuración de la base de datos
include("includes/config.php");

// Incluir el header
include("views/header.php");

// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener las variables de los datos del usuario desde el formulario
    $username = $_POST['username'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $password = $_POST['password'];

    // Conexión PDO
    $host = HOST; // o la IP de tu servidor MySQL
    $user = DB_USER;
    $passwordDB = DB_PASS; // Renombré esta variable para evitar confusión con la contraseña del usuario
    $database = DB_DATABASE;

    try {
        // Conexión a la base de datos
        $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $passwordDB);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si el nombre de usuario ya existe
        $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $userCount = $stmt->fetchColumn();

        if ($userCount > 0) {
            echo "El nombre de usuario ya está registrado. Por favor, elige otro.";
        } else {
            // Encriptar la contraseña antes de guardarla
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Preparar la consulta SQL
            $sql = "INSERT INTO users (username, password, nombre, apellidos) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // Ejecutar la consulta y pasar los valores
            if ($stmt->execute([$username, $hashedPassword, $nombre, $apellidos])) {
                echo "Usuario registrado con éxito.";
            } else {
                echo "Error al registrar el usuario.";
            }
        }
    } catch (PDOException $e) {
        // Si hay un error con la conexión a la base de datos
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>

<!-- Formulario de Registro -->
<h2>Registro de Usuario</h2>
<form action="registrer.php" method="POST">
    <label for="username">Nombre de usuario:</label>
    <input type="text" id="username" name="username" required>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" required>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Registrar</button>
</form>

<?php
// Incluir el footer
include("views/footer.php");
?>
