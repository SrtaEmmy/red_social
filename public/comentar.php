<?php 
require('../auth/conn.php');  
session_start();

$user_id = $_SESSION['user_id'];
// agregar comentario a la bd
if($_SERVER['REQUEST_METHOD']==='POST'){
    $comentario = $_POST['comment'];
    $id_publicacion = $_POST['id_post'];

    $sql = "INSERT INTO comentarios (id_publicacion, id_usuario, comentario) VALUES('$id_publicacion', '$user_id', '$comentario')";
    $connection->query($sql);

    header('Location: index.php');
}

 
?>