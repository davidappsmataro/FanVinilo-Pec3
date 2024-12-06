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
  <title>Inicio | FanVinilo</title>
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
    Destacados de la Semana
  </h1>
  <main class="max-w-5xl mx-auto flex flex-col flex-grow">
    <div class='flex flex-wrap gap-6 justify-center mt-10'>
      <?php
      try {

        $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
        if ($mysqli->connect_errno) {
          throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }

        $consulta = "
        (SELECT * FROM discos_pec3 WHERE id IN (1, 2))
        UNION
        (SELECT * FROM discos_pec3 WHERE id NOT IN (1, 2) ORDER BY RAND() LIMIT 3)
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
    </div>
  </main>

  <?php
  include_once('./components/footer.php');
  ?>


</body>

</html>