<?php
require '../auth/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD']==='POST' && $_POST['delete_post']) {
    $post_deleting = $_POST['delete_post'];

    // eliminar primero el like para que la fk no impida borrar la publicacion
    $sql_delete_like = "DELETE FROM likes WHERE id_foto = '$post_deleting'";
    $connection->query($sql_delete_like);

    // eliminar si esta guardada
    $sql_delete_saved = "DELETE FROM guardadas WHERE id_publicacion = '$post_deleting'";
    $connection->query($sql_delete_saved);
    
    // eliminar primero el comentario
    $sql_delete_comments = "DELETE FROM comentarios WHERE id_publicacion = '$post_deleting'";
    $connection->query($sql_delete_comments);

    
    
    // borrar la publicacion
    $sql = "DELETE FROM publicaciones WHERE id=$post_deleting";
    $connection->query($sql);
    header('Location: index.php');
}



?>