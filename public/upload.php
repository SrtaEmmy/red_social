<?php
require '../auth/conn.php';
session_start();



$fecha = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];
$text_img = '';

// subir imagen
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_FILES['img'])) {

    // subir imagen a carpeta del servidor
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        // ruta de almacenamiento absoluta 
        $ruta_absoluta = $_SERVER['DOCUMENT_ROOT']."/img/";

        // nombre de la imagen
        $nombre_img = $_FILES['img']['name'];
        
        // ruta completa de almacenamiento de archivo con su nombre
        $ruta_completa_img = $ruta_absoluta.$nombre_img;

        if(!is_dir("uploads")){
            mkdir("uploads", 0777);
        }
        
        move_uploaded_file($_FILES['img']['tmp_name'], 'uploads/'.$nombre_img);
        
        // ruta de almacenamiento relativa(usada para insertar en la bd)
        $ruta_relativa = "../img/";

        $text_img = $_POST['text'];


        // guardar ruta en bd
        $sql = "INSERT INTO publicaciones (id_usuario, contenido_url, fecha, text_img) VALUES('$user_id', 'uploads/$nombre_img', '$fecha', '$text_img')";
        $connection->query($sql);

        header('Location: index.php');

    }
}elseif ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['text_post'])) {
    $text_post = $_POST['text_post'];

    $sql_text = "INSERT INTO publicaciones (id_usuario, fecha, text_img) VALUES ('$user_id', '$fecha', '$text_post')";
    $connection->query($sql_text);
    header('Location: index.php');
    
}


?>