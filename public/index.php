<?php
require 'funciones.php';
require '../auth/conn.php';
session_start();

$user_id = $_SESSION['user_id'];

// Inicializar $_SESSION['post_saved'] si no está definida
if (!isset($_SESSION['post_saved'])) {
  $_SESSION['post_saved'] = array();
}


// recuperar ruta en la bd para mostrar imagen de publicaciones del propio usuario
$sql_show_img = "SELECT * FROM publicaciones WHERE id_usuario = $user_id ORDER BY id_usuario ASC ";
$result = $connection->query($sql_show_img);

// mostrar imagen de publicaciones de otros usuarios
$sql_show_img_o = "SELECT 
publicaciones.id,
publicaciones.contenido_url,
publicaciones.fecha,
publicaciones.text_img,
publicaciones.likes,
usuarios.nombre AS usuario_nombre,
usuarios.foto AS usuario_foto
FROM 
publicaciones
INNER JOIN usuarios ON publicaciones.id_usuario = usuarios.id
WHERE 
publicaciones.id_usuario != $user_id
ORDER BY 
publicaciones.fecha ASC";
$result_other = $connection->query($sql_show_img_o);

// mostrar datos de perfil de otros usuarios
$sql_perfil_other = "SELECT foto, descripcion, nombre FROM usuarios WHERE id != $user_id";
$result_perfil_other = $connection->query($sql_perfil_other);
// $row_perfil = $result_perfil->fetch_assoc();

if ($result_perfil_other->num_rows > 0) {
  $row_perfil_other = $result_perfil_other->fetch_assoc();
}

// mostrar datos de propio perfil
$sql_perfil = "SELECT foto, descripcion, nombre FROM usuarios WHERE id = $user_id";
$result_perfil = $connection->query($sql_perfil);

if ($result_perfil->num_rows > 0) {
  $row_perfil = $result_perfil->fetch_assoc();
}

$usuarios = obtener_user_id($user_id);
$publicaciones = obtener_num_publicaciones($user_id);

$post_saved = $_SESSION['post_saved'];
$amigos = obtener_cantidad_amigos($user_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Red Social</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include 'nav.php'; ?>




  <div class="container-fluid">
    <div class="row">

      <!-- div izquierdo -->
      <div class="col-4  lateral">
        <!-- foto de perfil-->
        <img class="container-fluid foto_lateral" src="<?php echo $row_perfil['foto'] ?>" alt="">

        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal_update_perfil"> <i class="bi bi-pencil-square"></i>Editar perfil</button>
        <!-- modal actualizar perfil -->
        <div class="modal fade" id="modal_update_perfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar perfil</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                <form action="update_perfil.php" method="post" enctype="multipart/form-data">
                  <label for="img_perfil">
                    <img src="<?php echo $row_perfil['foto'] ?>" style="width: 100px; border-radius:100%;" alt="">
                  </label>
                  <input class="form-control mb-4" type="file" name="img_perfil" id="img" accept="image/*">

                  <label for="desc">Editar descripción</label>
                  <textarea class="form-control " type="text" name="desc" rows="3" placeholder="Programing is nice!...">
                      <?php echo $row_perfil['descripcion'] ?>
                      </textarea>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Editar</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- nombre -->
        <h3> <?php echo $_SESSION['user_name'] ?> </h3>

        <div class="card">
          <div class=" justify-content-between p-1 ">
            <span style="margin-right:50px ;">Publicado: <b><?php echo $publicaciones ?></b></span>
            <span>Amigos: <b><?php echo $amigos ?></b></span>
          </div>
        </div>

        <!-- descripcion -->
        <div class="container mt-1 py-4" style="background-color: white;">
          <p class="descripcion"> <?php echo $row_perfil['descripcion'] ?> </p>
        </div>

      </div>



      <!-- div central -->
      <!-- que estas pensando.. -->
      <div class="col-4 mx-auto centro bg-light px-1 d-flex flex-column flex-grow-1">
        <form action="upload.php" method="post">
          <textarea name="text_post" id="textarea" class="form-control mt-4" placeholder="¿Qué estás pensando...?" rows="5" required></textarea>
          <button class="btn btn-outline-success btn-sm hide" id="btn_publicar" type="submit">Publicar</button>
        </form>

        <div class="card m-1">
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modal_img"><i class="bi bi-camera-fill" style="color: blue;"></i></button>

            <!--formulario subir publicacion con imagen con su modal-->
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal_img"> <i class="bi bi-image-fill" style="color: green;"></i> </button>
            <?php include_once 'modals.php'; ?>
            <button id="envelope" class="btn btn-sm"><i class="bi bi-envelope-open-fill" style="color: orange;"></i></button>
          </div>
        </div>


            <!-- mostrar publicaciones propias -->
            <?php foreach ($result as $row) : ?>
          <div class="container_publicacion fondo mb-4 py-1">
            <!-- foto y nombre usuario en publicacion -->
            <div class="container-fluid m-1 d-flex justify-content-between">
              <div >
                <img src="<?php echo $row_perfil['foto'] ?>" style="width: 30px; border-radius: 100%;" alt="">
                <span><b><?php echo $row_perfil['nombre'] ?></b></span>
              </div>

              <!-- opcion de eliminar -->
              <ul class="nav-item dropdown">
                <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots-vertical"></i>

                </a>
                <ul class="dropdown-menu">
                  <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal_delete_post<?php echo $row['id'] ?>"> Eliminar  </button>
                </ul>
              </ul>


              <div class="modal fade" id="modal_delete_post<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva publicación</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <form action="deletePost.php" method="post">
                        <p>¿Seguro que queires eliminar esta publicación?</p>
                        <input type="hidden" name="delete_post" value="<?php echo $row['id'] ?>">

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- texto publicacion -->
            <div class="container-fluid">
              <p> <?php echo $row['text_img'] ?> </p>
              <p class="fecha"> <?php echo $row['fecha'] ?> </p>
            </div>


            <img class="img-fluid imagen" src="<?php echo $row['contenido_url'] ?>" alt="<?php echo $row['contenido_url'] ?>">
            <!-- like, comentarios -->
            <div class="card">
              <div class="d-flex justify-content-between">
                <div class="container_likes d-flex">
                  <button onclick="dar_like(<?php echo $row['id'] ?>, <?php echo $_SESSION['user_id'] ?>)" class="btn"><i class="bi bi-hand-thumbs-up"></i></button>
                  <div class="pt-1" id="likes_<?php echo $row['id'] ?>"> <?php mostrar_likes($row['id']) ?> </div>
                </div>
                <button class="btn" onclick="show_coments(<?php echo $row['id'] ?>)">Comentar</button>
                <button id="save<?php echo $row['id'] ?>"
                  onclick="guardar(<?php echo $row['id'] ?>, <?php echo $user_id ?>); modificar_btn(<?php echo $row['id'] ?>, <?php echo $user_id ?>)" class="btn">
                  <?php echo (@$row['guardada'] !== 'true') ? '<i class="bi bi-save"></i>' : '<i class="bi bi-save-fill"></i>'; ?>
                </button>

              </div>
            </div>
            <!-- caja de comentarios -->
        <?php
        $publicacion = $row['id'];
        $comentarios = obtener_comentarios($publicacion);
        ?>
        <div id="caja<?php echo $row['id'] ?>" class="comentarios hide_comentarios">
        <?php foreach($comentarios as $comentario):
          $nombre = obtener_nombre($comentario['id_usuario']); 
          $foto = obtener_foto($comentario['id_usuario']);
          ?>
            <div  class="">
               <div class="py-3 px-2" >
                
                <img src="<?php echo $foto ?>" style="width: 30px; border-radius: 100%;" alt="">
                <span><b> <?php echo $nombre ?> </b></span> <p><?php echo $comentario['comentario'] ?></p>
                
              </div>
  
            </div>
            <?php endforeach ?>

            <form action="comentar.php" method="post">
                <input type="hidden" name="id_post" value="<?php echo $row['id']?>">
                <input style="border-radius: 5px; border: none;" class=" m-1" type="text" name="comment" required>
                <input class="btn btn-sm btn-bg m-1 btn-outline-dark" type="submit" value="publicar">
              </form>
        </div>
          </div>
        <?php endforeach ?>



<!-- Mostrar publicaciones de otros usuarios -->
<?php foreach ($result_other as $row) : ?>
    <div class="container_publicacion fondo mb-4 py-1">
        <!-- Foto y nombre del usuario en la publicación -->
        <div class="container-fluid m-1 d-flex justify-content-between">
            <div class="">
                <!-- Utiliza la información de la publicación actual -->
                <img src="<?php echo $row['usuario_foto'] ?>" style="width: 30px; border-radius: 100%;" alt="">
                <span><b><?php echo $row['usuario_nombre'] ?></b></span>
            </div>

            <!-- Opción de eliminar (si es necesario) -->
            <div class="modal fade" id="modal_delete_post<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Publicación</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="deletePost.php" method="post">
                                <p>¿Seguro que quieres eliminar esta publicación?</p>
                                <input type="hidden" name="delete_post" value="<?php echo $row['id'] ?>">
                                <!-- Agregar cualquier otro campo necesario para la eliminación -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Texto de la publicación -->
        <div class="container-fluid">
            <p><?php echo $row['text_img'] ?></p>
            <p class="fecha"><?php echo $row['fecha'] ?></p>
        </div>

        <!-- Imagen de la publicación -->
        <img class="img-fluid imagen" src="<?php echo $row['contenido_url'] ?>" alt="<?php echo $row['contenido_url'] ?>">

        <!-- Botones de like, comentarios y guardar -->
        <div class="card">
            <div class="d-flex justify-content-between">
                <div class="container_likes d-flex">
                    <button onclick="dar_like(<?php echo $row['id'] ?>, <?php echo $_SESSION['user_id'] ?>)" class="btn"><i class="bi bi-hand-thumbs-up"></i></button>
                    <div class="pt-1" id="likes_<?php echo $row['id'] ?>"><?php mostrar_likes($row['id']) ?></div>
                </div>
                <button class="btn" onclick="show_coments(<?php echo $row['id'] ?>)">Comentar</button>
                <button id="save<?php echo $row['id'] ?>" onclick="guardar(<?php echo $row['id'] ?>, <?php echo $user_id ?>); modificar_btn(<?php echo $row['id'] ?>, <?php echo $user_id ?>)" class="btn">
                    <?php echo (@$row['guardada'] !== 'true') ? '<i class="bi bi-save"></i>' : '<i class="bi bi-save-fill"></i>'; ?>
                </button>
            </div>
        </div>

        <!-- Caja de comentarios -->
        <div id="caja<?php echo $row['id'] ?>" class="comentarios hide_comentarios">
            <?php
            $publicacion = $row['id'];
            $comentarios = obtener_comentarios($publicacion);
            foreach ($comentarios as $comentario) :
                $nombre = obtener_nombre($comentario['id_usuario']);
                $foto = obtener_foto($comentario['id_usuario']);
            ?>
                <div class="">
                    <div class="py-3 px-2">
                        <img src="<?php echo $foto ?>" style="width: 30px; border-radius: 100%;" alt="">
                        <span><b><?php echo $nombre ?></b></span>
                        <p><?php echo $comentario['comentario'] ?></p>
                    </div>
                </div>
            <?php endforeach ?>
            <form action="comentar.php" method="post">
                <input type="hidden" name="id_post" value="<?php echo $row['id'] ?>">
                <input style="border-radius: 5px; border: none;" class=" m-1" type="text" name="comment" required>
                <input class="btn btn-sm btn-bg m-1 btn-outline-dark" type="submit" value="Publicar">
            </form>
        </div>
    </div>
<?php endforeach ?>

    

      </div>




      <!-- div derecho -->
      <div class="col-4  lateral">
        <h3>Chat</h3>


        <?php foreach ($usuarios as $user) : ?>

          <?php $id_destinatario = $user['id'] ?>

<div class="contenedor_botones">
<button class=" chat_contactos" data-bs-toggle="modal" data-bs-target="#modal_chat<?php echo $user['id'] ?>">
            <img src="<?php echo $user['foto'] ?>" class="" style="width: 60px;" alt="">
            <a class="nombre_amigos"> <?php echo $user['nombre'] ?> </a>
          </button>
</div>

          <!-- modal chat -->
          <div class="modal fade" id="modal_chat<?php echo $user['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog position-absolute bottom-0 end-0 m-4" style="height: 80vh;">
              <div class="modal-content" style="height: 100%;">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Chat con <?php echo $user['nombre']?></h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="content_all_messages modal-body overflow-auto" style="height: 80%;"> <!-- Agregado de la clase overflow-auto -->
                  <div>
                    <!-- muestra mensajes -->
                    <?php
                    $mensajes = array();
                    $sql_msg = "SELECT * FROM mensajes WHERE id_destinatario = $user_id AND id_remitente = $id_destinatario OR id_destinatario = $id_destinatario AND id_remitente = $user_id ORDER BY id ASC";
                    $result_msg = $connection->query($sql_msg);

                    if ($result_msg->num_rows > 0) {
                      while ($row = $result_msg->fetch_assoc()) {
                        $mensajes[] = $row; //agregamos la fila del mensaje al array
                      }
                    }
                    ?>


                    <?php foreach ($mensajes as $mensaje) : ?>
                      <?php if ($mensaje['id_remitente'] == $user_id) : ?>
                        <p class="msg-right m-4 " style="overflow-wrap: break-word;"> <span class="bg_right"> <?php echo $mensaje['mensaje'] ?> </span> </p>
                      <?php else : ?>
                        <p class="m-4 " style="overflow-wrap: break-word;"> <span class="bg_left"> <?php echo $mensaje['mensaje'] ?> </span> </p>
                      <?php endif ?>
                    <?php endforeach ?>

                    <div id="container_messages<?php echo $user['id'] ?>"></div>
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <form method="post" class="d-flex flex-column justify-content-between w-100 form" autocomplete="off" autofocus>
                    <div class="d-flex">
                      <input type="hidden" name="id_destinatario" value="<?php echo $id_destinatario ?>">
                      <input class="form-control mb-4 mx-4" type="text" name="message" placeholder="escribe aquí...">
                      <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        <?php endforeach ?>

      </div>

    </div>
  </div>

  


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="ajax.js"></script>
  <script src="ajax_msg.js"></script>
  <script src="ajax_guardar.js"></script>
  <script src="ui.js"></script>
</body>

</html>



