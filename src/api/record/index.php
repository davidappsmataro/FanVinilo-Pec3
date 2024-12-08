
<?php

require_once('../../data/db_config.php');
try {

    $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
    if ($mysqli->connect_errno) {
        // die("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json; charset=UTF-8');
    header("Access-Control-Allow-Methods: GET");


    $metodo = $_SERVER['REQUEST_METHOD'];

    switch ($metodo) {
        case 'GET':
            $uri = $_SERVER['REQUEST_URI'];
            $uriTroceada = explode('/', trim($uri, '/'));
            $id = end($uriTroceada);
            
            // Valido que el id sea un número
            if (!is_numeric($id)) {
                header("HTTP/1.1 400 Bad Request");
                echo json_encode([
                    "success" => false,
                    "message" => "Estructura de la petición incorrecta. Debe ser del tipo /api/record/{id}"
                ]);
                exit;
            }
            $registros_mostrados = 10;
            $consulta = "SELECT * FROM discos_pec3 WHERE id=$id";
            $resultado = $mysqli->query($consulta);
            if (!$resultado) {
                throw new Exception("Error en la consulta: " . $mysqli->error);
            }
            //obtenemos los registros en un array asociativo. El parámetro MYSQLI_ASSOC se encarga de esto. 
            //las claves del array serán los nombres de las columnas: id, titulo, artista, genero,...
            $records = $resultado->fetch_all(MYSQLI_ASSOC);
            if (count($records)== 0) {
                header("HTTP/1.1 404 Not Found");
                echo json_encode([
                    "success" => false,
                    "message" => "No se encontraron registros para el id: $id"
                ]);
                exit;
            }
            $record = $records[0];
            echo json_encode($record);
            
            break;

        default:
            throw new Exception("Método no permitido");
            break;
    }
} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    $result = array(
        "success" => "False",
        "message" => $e->getMessage()

    );
    echo json_encode($result);
} finally {
    if (isset($mysqli) && $mysqli->ping()) {
        $mysqli->close();
    }
}

?>