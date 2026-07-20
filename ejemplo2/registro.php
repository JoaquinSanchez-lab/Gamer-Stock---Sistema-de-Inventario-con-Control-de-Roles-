<?php

//
ini_set('display_errors', 1); // muestra todos los errores en pantalla
error_reporting(E_ALL);// muestra todos los errores en pantalla
//


require 'conexion.php'; // Traemos el archivo de conexión obligatoriamente para hablar con la base de datos


// Variables que guardan los mensajes de error o éxito para mostrarlos en el HTML
$error_msg = "";
$success_msg = ""; // hace que el mensaje de exito se muestre abajo esta el codigo  


if ($_SERVER['REQUEST_METHOD'] === 'POST') { // hace que el codigo de abajo solo se ejecute si el usuario apretó el boton de registrarse ademas que combrueba si hizo la accion de apretar en el boton de registrarse
    

    $nuevo_usuario = $_POST['usuario_reg'];//
    $clave_uno      = $_POST['clave_reg'];//
    $clave_dos      = $_POST['clave_reg_confirmar'];// estas 3 variables (inventadas) son las que guardan lo que el usuario escribio en los campos del formulario de registro el $_POST es un array que guarda todo lo que el usuario escribio en los campos del formulario y el nombre de cada campo temporalmente no lo manda a la base de datos hasta que se haga el insert en la base de datos con el prepare y el execute que esta mas abajo en el codigo


    
    if (empty($nuevo_usuario) || empty($clave_uno) || empty($clave_dos)) {//
        $error_msg = "Todos los campos son obligatorios.";//
    } // esta seccion de codigo hace que empty () compruebe si los campos estan vacios y si estan manda la variable creada mas arriba de $ error_msg con el mensaje de error 


    elseif ($clave_uno !== $clave_dos) {
        $error_msg = "Las contraseñas no coinciden. Escribilas igual.";
    } // esta seccion de codigo hace que si las contraseñas no coinciden mande la variable creada mas arriba de $ error_msg con el mensaje de error las contraseñas no coinciden
    // Es la junta de dos palabras: else (si no) y if (si...) Sirve para encadenar un segundo control, pero con una condición: solo se va a revisar si el if de arriba dio falso.


    else {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->execute([':usuario' => $nuevo_usuario]); // esta seccion de codigo lo que hace es verificar si el usuario YA EXISTE en la base de datos  
        
        if ($stmt->fetch()) {
            $error_msg = "El nombre de usuario ya está registrado por otra persona."; // y si existe manda la variable creada mas arriba de $ error_msg con el mensaje de error el nombre de usuario ya esta registrado por otra persona
        } else {
            
            $clave_encriptada = password_hash($clave_uno, PASSWORD_DEFAULT); // esta seccion de codigo lo que hace es encriptar la contraseña del usuario para que no se vea en la base de datos y sea mas seguro para el usuario

           
            $sql = "INSERT INTO usuarios (usuario, clave) VALUES (:usuario, :clave)"; // esta seccion de codigo lo que hace es preparar el insert en la base de datos para guardar el usuario y la contraseña encriptada en la base de datos basicamente es como un protector contra hackers 


            $insertar = $conexion->prepare($sql); // agarra todo lo escrito y lo deja preparado para ser insertado en la base de datos y lo deja listo para ser ejecutado con el execute que esta mas abajo en el codigo

            
            $insertar->execute([ // ejecuta el insert en la base de datos y lo manda a la base de datos para que se guarde el usuario y la contraseña encriptada
                ':usuario' => $nuevo_usuario,
                ':clave'   => $clave_encriptada
            ]);

            $success_msg = "¡Usuario creado con éxito! Ya podés iniciar sesión.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="caja caja-login">
        <h1>📝 Crear Nueva Cuenta</h1>
        
        <?php if (!empty($error_msg)): ?>
            <div class="error-msg"><?php echo $error_msg; ?></div>
        <?php endif; ?> 

        <?php if (!empty($success_msg)): ?>
            <div class="error-msg" style="background-color: #065f46; color: #a7f3d0;"><?php echo $success_msg; ?></div>
        <?php endif; ?>

        <form action="/ejemplo2/registro.php" method="POST">
            <label>Elegí un Nombre de Usuario:</label>
            <input type="text" name="usuario_reg" required>

            <label>Contraseña Segura:</label>
            <input type="password" name="clave_reg" required>

            <label>Repetir Contraseña:</label>
            <input type="password" name="clave_reg_confirmar" required>

            <button type="submit">Registrarme</button>
        </form>
        <br>
        <a href="/ejemplo2/login.php" style="color: #38bdf8; text-decoration: none; font-size: 14px;">← Volver al Login</a>
    </div>
</body>
</html>