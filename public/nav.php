  <!-- nav -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item dropdown">
            <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-gear-fill"></i>
            </a>
            <ul class="dropdown-menu">

              <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
            </ul>
          </li>

         

<?php
$user_id = $_SESSION['user_id'];
$usuarios = obtener_user_id($user_id); ?>


          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Amigos
            </a>

            <ul class="dropdown-menu">
         <?php foreach ($usuarios as $user): ?>
          
              <?php $id_destinatario = $user['id'] ?>
                <a for="">
                  <?php echo $user['nombre'] ?>
                </a>
                <li>
                <hr class="dropdown-divider">
              </li>
                
                <?php endforeach; ?>
              </ul>
          </li>


          <li class="nav-item dropdown">
            <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-bell-fill"></i>
            </a>

            <ul class="dropdown-menu">
         <p>No tienes notificaciones</p>
              </ul>
          </li>



        </ul>
      </div>

    </div>
  </nav>