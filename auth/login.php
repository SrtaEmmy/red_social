<?php
require 'conn.php';

$mensaje = '';


if ($_SERVER['REQUEST_METHOD']==='POST' && $_POST['email'] && $_POST['password']) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo = '$email'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // contrasena correcta
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nombre'];

            header('Location: /red_social/public/index.php');
            exit();
            
        }else{
            $mensaje = "contraseña incorrecta";
        }

        
    }else{
         $mensaje =  "email no encontrado";
    }

    
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


</head>
<body>
<!-- d-flex justify-content-center align-items-center vh-100 -->
<div class='contenedorPadre' >
    <div class="contenedorHijo">
    <h2>Iniciar sesión</h2> 
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post"> 
        <input class="input" type="email" name="email" placeholder="@email" required> <br>
        <input class="input" type="password" name="password" placeholder="contraseña" required><br>
        <button type="submit">Entrar</button>

        <p><?php echo $mensaje;?></p>
    </form>

    <div class="credenciales">
        <SPAN>Usa estas credenciales para iniciar sesión 👇</SPAN>
        <p><b>Email:</b> eva@gmail.com</p>
        <p><b>Contraseña:</b> 123</p>
    </div>

    <a href="signup.php">Regístrate</a>
    </div>
</div>

</body>
</html>