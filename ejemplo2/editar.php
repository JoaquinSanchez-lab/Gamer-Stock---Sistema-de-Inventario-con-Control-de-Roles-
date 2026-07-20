<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /ejemplo2/login.php");
    exit();
}

require 'conexion.php';

// $_GET es una variable obligatoria del sistema para leer datos que viajan por la URL (?id=3)
if (!isset($_GET['id'])) {
    header("Location: /ejemplo2/index.php");
    exit();
}

$id = $_GET['id'];

// Buscamos el artículo específico por su número único de ID
$stmt = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
$stmt->execute([':id' => $id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    header("Location: /ejemplo2/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="caja">
        <h1>✏️ Modificar Producto de la Tienda</h1>
        
        <form action="/ejemplo2/actualizar.php" method="POST">
            
            <input type="hidden" name="id_original" value="<?php echo $producto['id']; ?>">

            <label>Nombre Actualizado:</label>
            <input type="text" name="nombre_prod" value="<?php echo $producto['nombre']; ?>" required>

            <label>Precio Modificado ($):</label>
            <input type="number" step="0.01" name="precio_prod" value="<?php echo $producto['precio']; ?>" required>

            <label>Stock Corregido:</label>
            <input type="number" name="stock_prod" value="<?php echo $producto['stock']; ?>" required>

            <button type="submit">Aplicar Cambios</button>
        </form>
        <br>
        <a href="/ejemplo2/index.php" style="color: #94a3b8;">← Cancelar modificación</a>
    </div>
</body>
</html>