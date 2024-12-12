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
    if ((!isset($_POST['username']) || empty($_POST['username'])) || (!isset($_POST['password']) || empty($_POST['password']))) {
        $error = "Faltan campos por rellenar.";
    } else {
        try {
            $server_error = false;
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Conectar a la base de datos
            $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
            if ($mysqli->connect_errno) {
                throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
            }

            // Preparar la consulta para prevenir inyección SQL
            //https://www.php.net/manual/es/mysqli.prepare.php
            $stmt = $mysqli->prepare("SELECT username, nombre, apellidos, password FROM users_pec3 WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            // Verificar si el usuario existe
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_name, $user_nombre, $user_apellidos, $hashed_password);
                $stmt->fetch();
                // Verificar la contraseña
                if (password_verify($password, $hashed_password)) {
                    // Iniciar sesión
                    $_SESSION['username'] = $username;
                    $_SESSION['nombre'] = $user_nombre;
                    $_SESSION['apellidos'] = $user_apellidos;
                    header("Location: perfil.php");
                    echo "Login correcto";
                    exit;
                } else {
                    //Mensaje genérico sin especificar si es el usuario o la contraseña
                    $error = "Nombre de usuario o contraseña incorrectos.";
                }
            } else {
                //Mensaje genérico sin especificar si es el usuario o la contraseña
                $error = "Nombre de usuario o contraseña incorrectos.";
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
    <title>Login | FanVinilo</title>
    <meta name="author" content="David Pecharromán" />
    <meta name="description" content="Inicia sesión en FanVinilo. La página de tus discos favoritos" />
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
            const passwordInput = document.getElementById('password');
            //borrar mensaje de error al escribir en los campos
            const errorDiv = document.getElementById('errorDiv');
            const errorMessage = "<?php echo $error; ?>";
            if (errorMessage) {
                errorDiv.textContent = errorMessage;

            }
            usernameInput.addEventListener('input', function() {
                errorDiv.textContent = '';

            });
            passwordInput.addEventListener('input', function() {
                errorDiv.textContent = '';

            });
        });
    </script>
</head>

<body class="min-h-screen flex flex-col">


    <?php
    //si hay un error en el servidor, mostramos la página de error
    include_once('./components/menu.php');
    if (isset($server_error) && $server_error) {
        include('./components/internal_error.php');
        include_once('./components/footer.php');
        exit();
    }
    ?>
    <main class="container flex flex-col mx-auto rounded-lg pt-12 my-5 flex-grow">

        <div class="flex justify-center w-full h-full my-auto xl:gap-14 lg:justify-normal md:gap-5">

            <div class="flex items-center justify-center w-full lg:p-12">
                <div class="flex items-center xl:p-10">
                    <form class="flex flex-col w-full h-full pb-6 text-center bg-white rounded-3xl" method="POST">
                        <h1 class="mb-3 text-4xl font-extrabold text-dark-grey-900">Inicia Sesión</h1>
                        <p class="mb-4 text-grey-700">Introduce nombre de usuario y contraseña</p>

                        <label for="username" class="mb-2 text-sm text-start text-gray-900 font-bold">Nombre de Usuario<span class="text-red-500">*</span></label>
                        <input id="username" name="username" type="text" placeholder="Nombre de usuario" maxlength="50" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border required:invalid:border-red-500" />
                        <label for="password" class="mb-2 text-sm text-start text-gray-900 font-bold">Contraseña<span class="text-red-500">*</span></label>
                        <input id="password" name="password" type="password" placeholder="Introduce contraseña" maxlength="15" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" required class="flex items-center w-full px-5 py-4 mb-5 mr-2 text-sm font-medium outline-none focus:bg-grey-400 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border required:invalid:border-red-500" />

                        <button class="w-full px-6 py-5 mt-5 mb-5 text-sm font-bold leading-none text-white transition duration-300 md:w-96 rounded-2xl hover:bg-blue-400 focus:ring-4 focus:ring-purple-blue-100 bg-blue-500">Sign In</button>
                        <div id="errorDiv" class="mb-4 text-red-500"></div>
                        <!--  <?php if (isset($error)): ?>
                            <div class="mb-4 text-red-500"><?php echo $error; ?></div>
                        <?php endif; ?> -->
                        <p class="text-sm leading-relaxed text-grey-900">¿No te has registrado todavía? <a href="./signup.php" class="font-bold text-grey-700">Crear Cuenta</a></p>
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