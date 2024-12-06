<?php
include('./data/db_config.php')
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="author" content="David Pecharromán" />
  <meta name="description" content="Página inicial de FanVinilo con los destacados de la semana" />
  <title>Discos | FanVinilo</title>
  <link
    rel="icon"
    type="image/png"
    sizes="512x512"
    href="./assets/logo/logo.png" />
  <link rel="stylesheet" href="output.css">

  <script
    defer
    src="https://kit.fontawesome.com/fa121e3cca.js"
    crossorigin="anonymous"></script>
  <script src="./js/sidebar.js" defer></script>
</head>

<body class="min-h-screen flex flex-col bg-slate-100">

  <?php
  include_once('./components/menu.php');
  ?>
  <h1 class="text-center mt-10 text-4xl text-blue-500 font-light">
    La colección de FanVinilo
  </h1>
  <main class="max-w-5xl mx-auto flex flex-col flex-grow">
    <?php
    try {
      echo "<div class='flex flex-wrap gap-6 justify-center mt-10'>";
      //echo "<div class='grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-center mt-10'>";

      $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
      if ($mysqli->connect_errno) {
        //die("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
      }
      $registros_mostrados = 5;
      //Primero buscamos el número total de registros para saber cuantas páginas necesitamos
      $consulta = "SELECT COUNT(*) as total FROM discos_pec3";
      $resultado = $mysqli->query($consulta);
      if (!$resultado) {
        throw new Exception("Error en la consulta: " . $mysqli->error);
      }
      $total_registros = $resultado->fetch_assoc()['total'];
      $total_paginas = ceil($total_registros / $registros_mostrados);
      //echo "<script>console.log('{$total_paginas}');</script>";

      $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
      $offset = ($pagina - 1) * $registros_mostrados;
      $consulta = "
       SELECT * FROM discos_pec3 LIMIT $registros_mostrados OFFSET $offset;
      ";
      $resultado = $mysqli->query($consulta);
      if (!$resultado) {
        throw new Exception("Error en la consulta: " . $mysqli->error);
      }
      if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
          $id = isset($fila['id']) ? $fila['id'] : '0'; //TODO: estudiar el uso de id
          $titulo = isset($fila['titulo']) ? $fila['titulo'] : 'Título no disponible';
          $artista = isset($fila['artista']) ? $fila['artista'] : 'Artista no disponible';
          $genero = isset($fila['genero']) ? $fila['genero'] : 'Género no disponible';
          $precio = isset($fila['precio']) ? $fila['precio'] : '??';
          $imagen = isset($fila['imagen']) ? $fila['imagen'] : './assets/disco_640.jpg';
          echo '<article>';
          include('./components/card_disco.php');
          echo '</article>';
        }
        echo "</div><div>";
        include_once('./components/pagination.php');
        echo "</div>";
      } else {
        include_once('./components/not_found.php');
      };
    } catch (Exception $e) {

      include('./components/internal_error.php');
    } finally {
      //Si tenemos definida la conexión a la BD y está activa, la cerramos
      if (isset($mysqli) && $mysqli->ping()) {
        $mysqli->close();
      }
    }
    ?>

  </main>

  <?php
  include_once('./components/footer.php');
  ?>


</body>

</html>