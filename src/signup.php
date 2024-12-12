<?php
session_start();
// Validar si el usuario ya está logueado
if (isset($_SESSION['username'])) {
    header('Location: ./perfil.php');
    exit;
}
include('./data/db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validar que los campos no estén vacíos
    if ((!isset($_POST['username']) || empty($_POST['username'])) ||
        (!isset($_POST['nombre']) || empty($_POST['nombre'])) ||
        (!isset($_POST['apellidos']) || empty($_POST['apellidos'])) ||
        (!isset($_POST['password']) || empty($_POST['password'])) ||
        (!isset($_POST['password2']) || empty($_POST['password2'])) ||
        ($_POST['password'] != $_POST['password2'])
    ) {
        if ($_POST['password'] != $_POST['password2']) {
            $error = "Las contraseñas no coinciden.";
        } else {
            $error = "Faltan campos por rellenar.";
        }
    } else {
        try {
            $server_error = false;
            $username = $_POST['username'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $password = $_POST['password'];
            // Conectar a la base de datos
            $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
            if ($mysqli->connect_errno) {
                throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
            }

            // Preparar la consulta para prevenir inyección SQL
            $stmt = $mysqli->prepare("SELECT username password FROM users_pec3 WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            // Verificar si el usuario existe
            if ($stmt->num_rows > 0) {
                $error = "El nombre de usuario ya existe.";
            } else {
                // El usuario no existe, crear el nuevo usuario
                $stmt->close();
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $mysqli->prepare("INSERT INTO users_pec3 (username, nombre, apellidos, password) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $username, $nombre, $apellidos, $hashed_password);
                if ($stmt->execute()) {
                    // Iniciar sesión
                    $_SESSION['username'] = $username;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['apellidos'] = $apellidos;
                    header("Location: perfil.php");
                    exit;
                } else {
                    $error = "Error al crear el usuario.";
                }
            }
        } catch (Exception $e) {
            $server_error = true;
        } finally {
            //Si tenemos definida la consulta y está activa, la cerramos
            if (isset($stmt)) {
                $stmt->close();
            }
            //Si tenemos definida la conexión a la BD y está activa, la cerramos
            if (isset($mysqli) && $mysqli->ping()) {
                $mysqli->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="David Pecharromán" />
    <meta name="description" content="Regístrate en FanVinilo. La página de tus discos favoritos" />
    <title>Registro | FanVinilo</title>
    <link rel="stylesheet" href="output.css">
    <link
        rel="icon"
        type="image/png"
        sizes="512x512"
        href="./assets/logo/logo.png" />
    <script
        defer
        src="https://kit.fontawesome.com/fa121e3cca.js"
        crossorigin="anonymous"></script>
    <script src="./js/sidebar.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.getElementById('username');
            const nombreInput = document.getElementById('nombre');
            const apellidosInput = document.getElementById('apellidos');
            const passwordInput = document.getElementById('password');
            const password2Input = document.getElementById('password2');
            //borrar mensaje de error al escribir en los campos
            const errorDiv = document.getElementById('errorDiv');
            const errorMessage = "<?php echo $error; ?>";
            if (errorMessage) {
                errorDiv.textContent = errorMessage;

            }
            usernameInput.addEventListener('input', function() {
                errorDiv.textContent = '';

            });
            nombreInput.addEventListener('input', function() {
                errorDiv.textContent = '';

            });
            apellidosInput.addEventListener('input', function() {
                errorDiv.textContent = '';

            });
            passwordInput.addEventListener('input', function() {
                errorDiv.textContent = '';

            });
            password2Input.addEventListener('input', function() {
                errorDiv.textContent = '';

            });
        });
    </script>

</head>

<body class="min-h-screen flex flex-col">

    <?php
    include_once('./components/menu.php');
    if (isset($server_error) && $server_error) {
        include('./components/internal_error.php');
        include_once('./components/footer.php');
        exit();
    }
    ?>
    <main class="container flex flex-col mx-auto rounded-lg pt-12 my-5 flex-grow">
        <div class="flex justify-center w-full h-full my-auto xl:gap-14 lg:justify-normal md:gap-5">
            <div class="flex items-center justify-center w-full lg:p-12 ">
                <div class="flex items-center xl:p-10">
                    <form class="flex flex-col w-full h-full pb-6 text-center bg-white rounded-3xl" method="POST">
                        <h1 class="mb-3 text-4xl font-extrabold text-dark-grey-900">Registro</h1>
                        <p class="mb-4 text-grey-700">Regístrate en nuestra web</p>

                        <label for="username" class="mb-2 text-sm text-start text-gray-900 font-bold">Nombre de usuario<span class="text-red-500">*</span></label>
                        <input id="username" name="username" type="text" placeholder="Introduce Nombre de usuario" maxlength="50" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border required:invalid:border-red-500" required />
                        <label for="nombre" class="mb-2 text-sm text-start text-gray-900 font-bold">Nombre<span class="text-red-500">*</span></label>
                        <input id="nombre" name="nombre" type="text" placeholder="Introduce tu nombre" maxlength="100" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border required:invalid:border-red-500" required />
                        <label for="apellidos" class="mb-2 text-sm text-start text-gray-900 font-bold">Apellidos<span class="text-red-500">*</span></label>
                        <input id="apellidos" name="apellidos" type="text" placeholder="Introduce tus apellidos" maxlength="100" value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : ''; ?>" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border required:invalid:border-red-500" required />
                        <label for="password" class="mb-2 text-sm text-start text-gray-900 font-bold">Contraseña<span class="text-red-500">*</span></label>
                        <input id="password" name="password" type="password" placeholder="Introduce contraseña" maxlength="15" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" class="flex items-center w-full px-5 py-4 mb-5 mr-2 text-sm font-medium outline-none focus:bg-grey-400 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border required:invalid:border-red-500" required />
                        <label for="password2" class="mb-2 text-sm text-start text-gray-900 font-bold">Repite Contraseña<span class="text-red-500">*</span></label>
                        <input id="password2" name="password2" type="password" placeholder="Repite contraseña" maxlength="15" value="<?php echo isset($_POST['password2']) ? $_POST['password2'] : ''; ?>" class="flex items-center w-full px-5 py-4 mb-5 mr-2 text-sm font-medium outline-none focus:bg-grey-400 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border required:invalid:border-red-500" required />

                        <button class="w-full px-6 py-5 mt-5 mb-5 text-sm font-bold leading-none text-white transition duration-300 md:w-96 rounded-2xl hover:bg-blue-400 focus:ring-4 focus:ring-purple-blue-100 bg-blue-500">Crear Cuenta</button>
                        <div id="errorDiv" class="mb-4 text-red-500"></div>
                        <p class="text-sm leading-relaxed text-grey-900">¿Ya tienes una cuenta? <a href="./login.php" class="font-bold text-grey-700">Iniciar Sesión</a></p>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php
    include_once('./components/footer.php');
    ?>


</body>

</html>