<?php
function mostrar_likes($id_foto){
    require '../auth/conn.php';
    $sql = "SELECT likes FROM publicaciones WHERE id = $id_foto";
    $result = $connection->query($sql);
    $likes = $result->fetch_assoc();
    echo $likes['likes'];
  }


  // obtener el nombre y el id del usuario
  function obtener_user_id($user_actual){
    require '../auth/conn.php';
    $sql = "SELECT * FROM usuarios WHERE id !=$user_actual";
    $result = $connection->query($sql);

    $rows = array();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $rows[] = $row; //agregar la fila al array
      }
    }
    
    return $rows;
  }

  function obtener_num_publicaciones($user_actual){
    require('../auth/conn.php');
    $sql = "SELECT id_usuario, COUNT(*) AS cantidad_publicaciones
            FROM publicaciones WHERE id_usuario = $user_actual";
    $result = $connection->query($sql);
    
    $publi = $result->fetch_assoc();
    return $publi['cantidad_publicaciones'];
    

}


function obtener_comentarios($id_publicacion){
    require('../auth/conn.php');
    $sql_show_comments = "SELECT * FROM comentarios WHERE id_publicacion = '$id_publicacion' ";
    $result = $connection->query($sql_show_comments);

    $rows = array();
    if($result->num_rows > 0){
       while($row = $result->fetch_assoc()){
        $rows[] = $row;
       }
    }

  return $rows;
}

function obtener_nombre($id){
    require('../auth/conn.php');
    $sql = "SELECT nombre FROM usuarios WHERE id = '$id'";
    $result= $connection->query($sql);

    $nombre = $result->fetch_assoc();

    return $nombre['nombre'];
}
function obtener_foto($id){
    require('../auth/conn.php');
    $sql = "SELECT foto FROM usuarios WHERE id = '$id'";
    $result= $connection->query($sql);

    $foto = $result->fetch_assoc();

    return $foto['foto'];
}

function obtener_cantidad_amigos($user_actual){
    require('../auth/conn.php');
    $sql = "SELECT COUNT(*) FROM usuarios WHERE id !='$user_actual'";
    $result= $connection->query($sql);

    $cantidad = $result->fetch_assoc();
    return $cantidad['COUNT(*)'];

}



?>