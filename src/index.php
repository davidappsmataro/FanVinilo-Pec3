<?php
include('./data/db_config.php')
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de inicio</title>
  <link rel="stylesheet" href="output.css">
</head>

<body class="min-h-screen flex flex-col">

  <?php
  include_once('./components/menu.php');
  ?>
  <h1 class="text-center mt-10 text-4xl uppercase">
    Destacados de la Semana
  </h1>
  <main class="container flex flex-grow flex-wrap  gap-6 mx-auto   justify-center mt-10 ">
    <?php
   /*  include('./components/disco.php');
    include('./components/disco.php');
    include('./components/disco.php');
    include('./components/disco.php');
    include('./components/disco.php'); */
    /* $conexion=mysqli_connect('localhost','root','root','PEC3');
    if (mysqli_connect('localhost','root','root','PEC3')) {
      echo 'connected';
      $result=mysqli_query($conexion, 'SELECT * FROM discos_pec3');
      $fila=mysqli_fetch_all($result);
      print_r($fila[0]);
    } else {
      echo 'failed';
    } */

    $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
    if ($mysqli->connect_errno) {
      die("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }
    $consulta="SELECT * FROM discos_pec3";
    $resultado=$mysqli->query($consulta);
    if ($resultado->num_rows>0) {
      while ($fila=$resultado->fetch_assoc()) {
        $titulo=isset($fila['titulo']) ? $fila['titulo'] : 'Título no disponible';
        $artista=isset($fila['artista']) ? $fila['artista'] : 'Artista no disponible';
        $genero=isset($fila['genero']) ? $fila['genero'] : 'Género no disponible';
        $precio=isset($fila['precio']) ? $fila['precio'] : '??';
        $imagen= isset($fila['imagen']) ? $fila['imagen'] : './assets/disco_640.jpg';
        include('./components/disco.php');
       
      }
    } else {
      echo '<p class="text-3xl font-bold">Ooops ¡ No hay discos disponibles !</p>';
    };


    $mysqli->close();
    ?>

  </main>

  <?php
  include_once('./components/footer.php');
  ?>

</body>

</html>