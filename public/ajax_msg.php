<?php
require '../auth/conn.php';
session_start();

// recibir datos de js y guardarlos en la bd
$id_user = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD']==='POST' && $_POST['message']) {
    $mensaje = $_POST['message'];
    $id_destinatario = $_POST['id_destinatario'];

    $sql = "INSERT INTO mensajes (id_remitente, id_destinatario, mensaje) VALUES($id_user, $id_destinatario, '$mensaje')";
    $connection->query($sql);
}





?>