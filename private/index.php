

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Red Social</title>
</head>
<body>


<!-- mostrar publicaciones -->
<div class="container_img">
    <?php foreach($result as $row):?>
       <img src="<?php echo $row['contenido_url']?>" alt="<?php echo $row['contenido_url']?>">

    <?php endforeach?>
</div>

<!-- subir img -->
<form action="upload.php" method="post" enctype="multipart/form-data">
   <input type="file" name="img" id="img" accept="image/*" required>
   <button type="submit">Subir imagen</button>

</form>




</body>
</html>