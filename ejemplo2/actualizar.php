<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /ejemplo2/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'conexion.php';

    $id     = $_POST['id_original'];
    $nombre = $_POST['nombre_prod'];
    $precio = $_POST['precio_prod'];
    $stock  = $_POST['stock_prod'];

    // Sentencia SQL UPDATE para modificar renglones existentes usando un filtro WHERE exacto
    $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, stock = :stock WHERE id = :id";
    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':nombre' => $nombre,
        ':precio' => $precio,
        ':stock'  => $stock,
        ':id'     => $id
    ]);
}

header("Location: /ejemplo2/index.php");
exit();
?>