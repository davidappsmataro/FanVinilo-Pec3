<?php
session_start();
include('./data/db_config.php');

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
  if (isset($_SESSION['username'])) {
    echo '<p class="text-center mt-10 text-lg text-blue-900 font-light">Hola! Nos alegramos de volverte a ver, <span class="uppercase font-bold"> ' . $_SESSION['username'] . '</span></p>';
  }
  ?>
  <h1 class="text-center mt-10 text-4xl text-blue-500 font-light">
    La colección de FanVinilo
  </h1>
  <main class="max-w-5xl w-full mx-auto flex flex-col flex-grow">
    <?php
    try {
      /*   include_once('./components/search.php');
      echo "<div class='flex flex-wrap gap-6 justify-center mt-10'>"; */
      //echo "<div class='grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-center mt-10'>";

      $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
      if ($mysqli->connect_errno) {
        //die("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
      }
      //-------CARGAS FILTROS DINAMICAMENTE--------
      $consulta = "SHOW COLUMNS FROM discos_pec3 LIKE 'genero'";
      $resultado = $mysqli->query($consulta);
      if (!$resultado) {
        throw new Exception("Error en la consulta: " . $mysqli->error);
      }
      //obtenemos los generos de la BD
      $fila = $resultado->fetch_assoc();
      $set_values = $fila['Type'];
      $set_values = str_replace("set(", "", $set_values);
      $set_values = str_replace(")", "", $set_values);
      $set_values = str_replace("'", "", $set_values);
      $genero = explode(",", $set_values);
      //obtenemos los estados de la BD
      $consulta = "SHOW COLUMNS FROM discos_pec3 LIKE 'estado'";
      $resultado = $mysqli->query($consulta);
      if (!$resultado) {
        throw new Exception("Error en la consulta: " . $mysqli->error);
      }

      $fila = $resultado->fetch_assoc();
      $enum_values = $fila['Type'];
      $enum_values = str_replace("enum(", "", $enum_values);
      $enum_values = str_replace(")", "", $enum_values);
      $enum_values = str_replace("'", "", $enum_values);
      $estado = explode(",", $enum_values);


      //---- Obtener los valores de los filtros del formulario-----
      $query_precio = isset($_GET['precio']) ?  $_GET['precio'] : '0';
      $query_fecha = isset($_GET['fecha']) ?  $_GET['fecha'] : '0';
      $query_artista = isset($_GET['artista']) ? $_GET['artista'] : '';
      $query_genero = isset($_GET['genero']) ?  $_GET['genero'] : '0';
      $query_estado = isset($_GET['estado']) ? $_GET['estado'] : '0';

      // Verificar si hay filtros aplicados para mostar botón de reset
      $filtros_aplicados = $query_precio || $query_fecha || $query_artista || $query_genero || $query_estado;

      include_once('./components/search.php');
      echo "<div class='flex flex-wrap gap-6 justify-center mt-10'>";
      //--------fin filtros-----------

      $registros_mostrados = 5;
      //Primero buscamos el número total de registros para saber cuantas páginas necesitamos
      $consulta = "SELECT COUNT(*) as total FROM discos_pec3 WHERE 1=1";


      // Construir la consulta SQL dinámicamente
      //$consulta = "SELECT * FROM discos_pec3 WHERE 1=1";

      if ($query_artista && $query_artista != '') {
        $consulta .= " AND artista LIKE '%" . $mysqli->real_escape_string($query_artista) . "%'";
      }

      if ($query_genero && $query_genero != '0') {
        $consulta .= " AND FIND_IN_SET('" . $mysqli->real_escape_string($query_genero) . "', genero)";
      }

      if ($query_estado && $query_estado != '0') {
        $consulta .= " AND estado = '" . $mysqli->real_escape_string($query_estado) . "'";
      }

      // Añadir ORDER BY para precio y fecha
      $order_by = [];
      if ($query_precio && $query_precio != '0') {
        $order_by[] = "precio $query_precio";
      }
      if ($query_fecha && $query_fecha != '0') {
        $order_by[] = "f_lanzamiento $query_fecha";
      }
      if (!empty($order_by)) {
        $consulta .= " ORDER BY " . implode(", ", $order_by);
      }
      $resultado = $mysqli->query($consulta);
      if (!$resultado) {
        throw new Exception("Error en la consulta: " . $mysqli->error);
      }
      $total_registros = $resultado->fetch_assoc()['total'];
      $total_paginas = ceil($total_registros / $registros_mostrados);
      //echo "<script>console.log('{$total_paginas}');</script>";

      $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
      $offset = ($pagina - 1) * $registros_mostrados;
      /* $consulta = "
       SELECT * FROM discos_pec3 LIMIT $registros_mostrados OFFSET $offset;
      "; */
      $consulta = "
       SELECT * FROM discos_pec3 WHERE 1=1
      ";
      if ($query_artista) {
        $consulta .= " AND artista LIKE '%" . $mysqli->real_escape_string($query_artista) . "%'";
      }
      if ($query_genero && $query_genero != '0') {
        $consulta .= " AND FIND_IN_SET('" . $mysqli->real_escape_string($query_genero) . "', genero)";
      }

      if ($query_estado && $query_estado != '0') {
        $consulta .= " AND estado = '" . $mysqli->real_escape_string($query_estado) . "'";
      }

      // Añadir ORDER BY para precio y fecha
      $order_by = [];
      if ($query_precio && $query_precio != '0') {
        $order_by[] = "precio $query_precio";
      }
      if ($query_fecha && $query_fecha != '0') {
        $order_by[] = "f_lanzamiento $query_fecha";
      }
      if (!empty($order_by)) {
        $consulta .= " ORDER BY " . implode(", ", $order_by);
      }
      $consulta .= " LIMIT $registros_mostrados OFFSET $offset";
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
        //include_once('./components/not_found.php');
        echo "<div><p class='font-bold'>Ooops! No hemos encontrado discos para la búsqueda seleccionada.</p><p></div>";
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