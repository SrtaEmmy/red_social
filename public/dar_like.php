<?php
require '../auth/conn.php';
session_start();

$id_imagen = $_GET['id'];
$id_usuario = $_GET['usuario'];

$connection->autocommit(false); // Iniciar transacción

try {
    // Verificar si ya tiene like
    $sql_verify = "SELECT * FROM likes WHERE id_foto = $id_imagen AND id_usuario = $id_usuario";
    $result_verify = $connection->query($sql_verify);

    if ($result_verify->num_rows > 0) {
        // Si ya hay like de ese usuario, quitarlo
        $sql_delete = "DELETE FROM likes WHERE id_foto = $id_imagen AND id_usuario = $id_usuario";
        $connection->query($sql_delete);

        // Actualizar campo "likes" en tabla "publicaciones" solo para la fila específica
        $sql_update_publicaciones = "UPDATE publicaciones SET likes = likes - 1 WHERE id = $id_imagen";
        $connection->query($sql_update_publicaciones);
    } else {
        // Si no hay like de ese usuario, insertar
        $sql_insert = "INSERT INTO likes (id_foto, liked, id_usuario) VALUES ($id_imagen, 1, $id_usuario)";
        $connection->query($sql_insert);

        // Actualizar campo "likes" en tabla "publicaciones" solo para la fila específica
        $sql_update_publicaciones = "UPDATE publicaciones SET likes = likes + 1 WHERE id = $id_imagen";
        $connection->query($sql_update_publicaciones);
    }

    // obtener cantidad de likes actualizada
    $sql_get_likes = "SELECT likes FROM publicaciones WHERE id = $id_imagen";
    $result_likes = $connection->query($sql_get_likes);
    $row_likes = $result_likes->fetch_assoc();
    $likes = $row_likes['likes'];

    $connection->commit(); // Confirmar la transacción

    // devolver likes a ajax.js
    echo $likes;

} catch (Exception $e) {
    $connection->rollback(); // Revertir transacción en caso de error
    echo "Error: " . $e->getMessage();
} finally {
    $connection->autocommit(true);
}
?>



