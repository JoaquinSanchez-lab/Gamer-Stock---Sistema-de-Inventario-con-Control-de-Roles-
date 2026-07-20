<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /ejemplo2/login.php");
    exit();
}

// Validamos que venga el ID por la URL
if (isset($_GET['id'])) {
    require 'conexion.php';
    $id = $_GET['id'];
    
    // Sentencia SQL DELETE para remover la fila de la base de datos
    $stmt = $conexion->prepare("DELETE FROM productos WHERE id = :id"); //siempre poner where o se borra todo !!!!!!!!!!!!!!!
    $stmt->execute([':id' => $id]);
}

header("Location: /ejemplo2/index.php");
exit();
?>