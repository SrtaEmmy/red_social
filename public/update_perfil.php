<?php
require '../auth/conn.php';
session_start();

$descripcion = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD']==='POST') {

    $descripcion = $_POST['desc'];

    if (isset($_FILES['img_perfil']) && $_FILES['img_perfil']['error']=== UPLOAD_ERR_OK) {
        
        $ruta_absoluta = $_SERVER['DOCUMENT_ROOT'].'/perfil_img/';

        $nombre_foto = $_FILES['img_perfil']['name'];

        $ruta_abs_completa = $ruta_absoluta.$nombre_foto;


        if(!is_dir("upload_perfil")){
            mkdir("upload_perfil", 0777);
        }

        // mueve el archivo desde su ubicacion temporal a su destino(perfil_img)
        move_uploaded_file($_FILES['img_perfil']['tmp_name'], 'upload_perfil/'.$nombre_foto);

        

        $ruta_relativa = '../perfil_img/';

        // guardar url en la base de datos
        $sql_set_perfil = "UPDATE usuarios SET foto = 'upload_perfil/$nombre_foto', descripcion = '$descripcion' WHERE id=$user_id";
        $connection->query($sql_set_perfil);

    }
     
    $sql = "UPDATE usuarios SET descripcion = '$descripcion' WHERE id = $user_id";
    $connection->query($sql);
    header('Location: index.php');
    
}





?>