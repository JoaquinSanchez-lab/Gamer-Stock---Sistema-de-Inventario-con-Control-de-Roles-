<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /ejemplo2/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cargar Producto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="caja">
        <h1>📦 Registrar Alta de Producto</h1>
        
        <form action="/ejemplo2/guardar.php" method="POST">
            <label>Nombre Comercial:</label>
            <input type="text" name="nombre_prod" required>

            <label>Precio de Venta ($):</label>
            <input type="number" step="0.01" name="precio_prod" required>

            <label>Unidades en Stock:</label>
            <input type="number" name="stock_prod" required>

            <button type="submit">Guardar Registro</button>
        </form>
        <br>
        <a href="/ejemplo2/index.php" style="color: #94a3b8;">← Volver al listado</a>
    </div>
</body>
</html>