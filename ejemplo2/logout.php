<?php
session_start();
session_destroy(); // Destruye obligatoriamente todos los datos permitiendo que se cierre sesion y tenga que volver a iniciar sesion 
header("Location: /ejemplo2/login.php");
exit();
?>