<?php


// Variables inventadas por nosotros para guardar los datos de acceso
$host = 'localhost';
$db   = 'mi_tienda';
$user = 'root';
$pass = '';


try {
    
    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // lo que hace es que TRATA de conectar la base de datos y si falla, salta al catch() y muestra el error en pantalla

    
} catch (PDOException $error) {
    die("Error crítico de conexión: " . $error->getMessage());
    // lo que hacen catch y die es que si hay un error de conexión, se detiene el script y muestra el mensaje de error en pantalla


}
?>

