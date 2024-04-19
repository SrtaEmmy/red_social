<?php 
require('../auth/conn.php');
session_start();

$id_img = $_GET['id'];
$id_user = $_GET['usuario'];




// verificar si la imagen ya esta guardada
$sql_verify = "SELECT * FROM guardadas WHERE id_publicacion = '$id_img'";
$result_verify = $connection->query($sql_verify);

if($result_verify->num_rows > 0){
    // la imagen ya esta guardada, por lo que cambiamos su estado
    $row = $result_verify->fetch_assoc();
    $new_status = $row['guardada'] == 'true' ? 'false' : 'true'; // Cambia el estado actual
    $sql_update = "UPDATE guardadas SET guardada = '$new_status' WHERE id_publicacion = '$id_img'";
    $connection->query($sql_update);
}else{
    // no esta guardada, por lo que insertamos el valor true al campo "guardada"
    $sql = "INSERT INTO guardadas VALUES('$id_img', 'true', '$id_user')";
    $connection->query($sql);
}


// respuesta ajax
$sql_show = "SELECT * FROM guardadas WHERE id_publicacion = '$id_img'";
$result = $connection->query($sql_show);

if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['post_saved'] = $row; 
}

echo json_encode($_SESSION['post_saved']);
 
 
?>







