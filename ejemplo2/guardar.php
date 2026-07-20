<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /ejemplo2/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'conexion.php';

    // Capturamos las variables inventadas usando los names del formulario anterior
    $nombre = $_POST['nombre_prod'];
    $precio = $_POST['precio_prod'];
    $stock  = $_POST['stock_prod'];

    // Sentencia INSERT de SQL para meter filas nuevas
    $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (:nombre, :precio, :stock)";
    $stmt = $conexion->prepare($sql);

    // Vinculamos y ejecutamos de forma segura
    $stmt->execute([
        ':nombre' => $nombre,
        ':precio' => $precio,
        ':stock'  => $stock
    ]);
}

// Redirigimos al index para ver el producto recién listado
header("Location: /ejemplo2/index.php");
exit();
?>