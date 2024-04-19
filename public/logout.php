<?php
session_start(); // Inicia la sesión

$_SESSION = array(); // Borra todas las variables de sesión

session_destroy(); // Destruye la sesión

header('Location: ../auth/login.php'); // Redirige al usuario
exit; // Asegura que el script termine aquí y no haya ninguna salida adicional
?>
