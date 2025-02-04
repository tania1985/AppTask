<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Crear Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2>Iniciar Sesión</h2>
            <form>
                <input type="text" placeholder="Usuario" required>
                <input type="password" placeholder="Contraseña" required>
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
        <div class="signup-container">
            <h2>Crear Usuario</h2>
            <form>
                <input type="text" placeholder="Nuevo Usuario" required>
                <input type="password" placeholder="Nueva Contraseña" required>
                <button type="submit">Crear Cuenta</button>
            </form>
        </div>
    </div>
</body>
</html>
