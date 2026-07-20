<?php

session_start();
// si la persona que entra no esta logeado se lo manda directo al login.php
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

require 'conexion.php';

// Hacemos una consulta limpia para traer todos los productos
$stmt = $conexion->query("SELECT * FROM productos");
// fetchAll() es obligatorio para traer TODOS los renglones juntos de la base de datos
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="contenedor">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>📋 Inventario de Productos</h1>
            <p>Usuario: <strong><?php echo $_SESSION['usuario']; ?></strong> (<?php echo $_SESSION['rol']; ?>) | <a href="/ejemplo2/logout.php" style="color:#ef4444;">Salir</a></p>
        </div>
        
        <!-- El botón de registrar nuevo producto SOLO lo ve el admin -->
        <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="/ejemplo2/formulario.php" class="btn">➕ Registrar Nuevo Producto</a>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Artículo</th>
                    <th>Precio Unitario</th>
                    <th>Stock Real</th>
                    <!-- El encabezado de acciones SOLO aparece para el admin -->
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <th>Acciones de Control</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo $p['nombre']; ?></td>
                    <td>$<?php echo number_format($p['precio'], 2); ?></td>
                    <td><?php echo $p['stock']; ?> u.</td>
                    
                    <!-- Los botones de Editar y Borrar SOLO se dibujan si es admin -->
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <td>
                            <a href="/ejemplo2/editar.php?id=<?php echo $p['id']; ?>" class="btn" style="background-color: #10b981;">Editar</a>
                            <a href="/ejemplo2/borrar.php?id=<?php echo $p['id']; ?>" onclick="return confirm('¿Eliminar este producto de forma permanente?')" class="btn btn-rojo">Borrar</a>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>