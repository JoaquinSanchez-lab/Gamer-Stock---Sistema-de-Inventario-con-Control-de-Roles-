<?php
session_start();
require 'conexion.php';

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_login = isset($_POST['usuario_partida']) ? trim($_POST['usuario_partida']) : '';
    $clave_login   = isset($_POST['clave_partida']) ? $_POST['clave_partida'] : '';

    if (empty($usuario_login) || empty($clave_login)) {
        $error_msg = "Por favor, completa todos los campos.";
    } else {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->execute([':usuario' => $usuario_login]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($clave_login, $usuario['clave'])) {
            $_SESSION['usuario'] = $usuario['usuario'];
            $_SESSION['rol']     = $usuario['rol']; // Acá se guarda 'admin' o 'cliente'

            // Va directo a tu archivo index.php
            header("Location: index.php");
            exit;
        } else {
            $error_msg = "El usuario o la contraseña son incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Control de Acceso</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="caja caja-login">
        <h1>🎮 Control de Acceso</h1>
        
        <?php if (!empty($error_msg)): ?>
            <div class="error-msg"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <form action="/ejemplo2/login.php" method="POST">
            <label>Nombre de Usuario:</label>
            <input type="text" name="usuario_partida" required>

            <label>Contraseña:</label>
            <input type="password" name="clave_partida" required>

            <button type="submit">Entrar al Sistema</button>
        </form>
        <br>
        <div style="text-align: center; font-size: 14px;">
            <span style="color: #fff;">¿No tenés cuenta? </span>
            <a href="/ejemplo2/registro.php" style="color: #38bdf8; text-decoration: none;">Registrate acá</a>
        </div>
    </div>
</body>
</html>