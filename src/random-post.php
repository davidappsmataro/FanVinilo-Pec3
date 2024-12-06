<?php
include('./data/db_config.php')
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="author" content="David Pecharromán" />
  <meta name="description" content="Todas las giras de los Rolling Stones." />
  <title>Disco | FanVinilo</title>
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

  <?php

  try {
    
    setlocale(LC_TIME, 'es_ES.UTF-8');
    //https://es.stackoverflow.com/questions/395459/fecha-en-espa%C3%B1ol 
    $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'Europe/Madrid', IntlDateFormatter::GREGORIAN, 'MMMM yyyy');
    $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
    if ($mysqli->connect_errno) {
      throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }
    $consulta = "SELECT * FROM discos_pec3 ORDER BY rand() LIMIT 1";
    $resultado = $mysqli->query($consulta);
    if (!$resultado) {
      throw new Exception("Error en la consulta: " . $mysqli->error);
    }
    if ($resultado->num_rows > 0) {
      while ($fila = $resultado->fetch_assoc()) {
        $titulo = isset($fila['titulo']) ? $fila['titulo'] : 'Título no disponible';
        $artista = isset($fila['artista']) ? $fila['artista'] : 'Artista no disponible';
        $genero = isset($fila['genero']) ? $fila['genero'] : 'Género no disponible';
        $precio = isset($fila['precio']) ? $fila['precio'] : '??';
        $imagen = isset($fila['imagen']) ? $fila['imagen'] : './assets/disco_640.jpg';
        $f_lanzamiento = isset($fila['f_lanzamiento']) ?  $formatter->format(new DateTime($fila['f_lanzamiento'])) : 'Fecha no disponible';
        $estado = isset($fila['estado']) ? $fila['estado'] : 'Estado no disponible';
        include('./components/disco.php');
      }
    } else {
      echo '<p class="text-3xl font-bold">Ooops ¡ No hay discos disponibles !</p>';
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

  <?php
  include_once('./components/footer.php');
  ?>

</body>

</html>