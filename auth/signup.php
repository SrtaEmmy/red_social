<?php
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['name'] && $_POST['email'] && $_POST['password']) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, correo, password) VALUES('$name', '$email', '$password')";
    $result = $connection->query($sql);

    if ($result) {
        header('Location: login.php');
    }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <div class="contenedorPadre">
        <div class="contenedorHijo">
            <h2>Registro</h2>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <input class="input" type="text" name="name" placeholder="Tu nombre" required><br>
                <input class="input" type="email" name="email" placeholder="@email" required><br>
                <input class="input" type="password" name="password" placeholder="contraseña" required><br>
                <button type="submit">Registrar</button>
                <p></p>
            </form>

            <a href="login.php">Inicia sesión</a>
        </div>
    </div>

</body>

</html>