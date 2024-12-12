<?php
session_start();
//sino está logueado, redirigimos a la página de login
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
    exit;
}
include('./data/db_config.php');
//si se produce un error en el servidor mostraremos el componente internal_error
$server_error = false;
//el valor de usrname es el que se ha guardado en la sesión
$username = $_SESSION['username'];

//cargamos los datos del usuario
try {
    $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
    if ($mysqli->connect_errno) {
        throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("SELECT nombre, apellidos FROM users_pec3 WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($nombre, $apellidos);
    $stmt->fetch();
    //$stmt->close();
} catch (Exception $e) {
    $server_error = true;
} finally {
    //Si tenemos definida la consulta y está activa, la cerramos
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($mysqli) && $mysqli->ping()) {
        $mysqli->close();
    }
}

//si estamos recibiendo datos por POST, es que estamos modificando y los actualizamos en la BD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // si modificamos los datos del usuario
    if (isset($_POST['nombre']) && isset($_POST['apellidos'])) {



        $new_nombre = $_POST['nombre'];
        $new_apellidos = $_POST['apellidos'];
        if (empty($new_nombre) || empty($new_apellidos)) {
            $errorDatos = "Faltan campos por rellenar.";
        } else {
            try {
                // Conectar a la base de datos
                $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
                if ($mysqli->connect_errno) {
                    throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
                }

                // Preparar la consulta para actualizar los datos del usuario
                $stmt = $mysqli->prepare("UPDATE users_pec3 SET nombre = ?, apellidos = ? WHERE username = ?");
                $stmt->bind_param("sss", $new_nombre, $new_apellidos, $username);
                if ($stmt->execute()) {
                    $_SESSION['nombre'] = $nombre = $new_nombre;
                    $_SESSION['apellidos'] = $apellidos =  $new_apellidos;
                    $successDatos = "Datos actualizados correctamente.";
                } else {
                    throw new Exception("Error en la ejecución de la consulta: (" . $stmt->errno . ") " . $stmt->error);
                }
            } catch (Exception $e) {
                $server_error = true;
            } finally {
                // Cerrar la consulta y la conexión a la base de datos
                if (isset($stmt)) {
                    $stmt->close();
                }
                //Si tenemos definida la conexión a la BD y está activa, la cerramos
                if (isset($mysqli) && $mysqli->ping()) {
                    $mysqli->close();
                }
            }
        }
    } else if (isset($_POST['password']) && isset($_POST['password2'])) {
        // si modificamos la contraseña
        $new_password = $_POST['password'];
        $new_password2 = $_POST['password2'];
        if (empty($new_password) || empty($new_password2)) {
            $errorPassword = "Faltan campos por rellenar.";
        } else if ($new_password != $new_password2) {
            $errorPassword = "Las contraseñas no coinciden.";
        } else {
            try {
                // Conectar a la base de datos
                $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB);
                if ($mysqli->connect_errno) {
                    throw new Exception("La conexión a la BD ha fallado: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
                }

                // Preparar la consulta para actualizar la contraseña del usuario
                $stmt = $mysqli->prepare("UPDATE users_pec3 SET password = ? WHERE username = ?");
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $stmt->bind_param("ss", $hashed_password, $username);
                if ($stmt->execute()) {
                    $successPassword = "Contraseña actualizada correctamente.";
                } else {
                    throw new Exception("Error en la ejecución de la consulta: (" . $stmt->errno . ") " . $stmt->error);
                }
            } catch (Exception $e) {
                $server_error = true;
            } finally {
                // Cerrar la consulta y la conexión a la base de datos
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
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="author" content="David Pecharromán" />
    <meta name="description" content="Página que permite modificar el pefil del usuario" />
    <title>Inicio | FanVinilo</title>
    <link
        rel="icon"
        type="image/png"
        sizes="512x512"
        href="./assets/logo/logo.png" />
    <link rel="stylesheet" href="output.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <script
        defer
        src="https://kit.fontawesome.com/fa121e3cca.js"
        crossorigin="anonymous"></script>
    <script src="./js/sidebar.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const nombreInput = document.getElementById('nombre');
            const apellidosInput = document.getElementById('apellidos');
            const passwordInput = document.getElementById('password');
            const password2Input = document.getElementById('password2');
            const guardaDatosForm = document.getElementById('guarda_datos');
            const guardaPasswordForm = document.getElementById('guarda_password');
            //borrar mensaje de error al escribir en los campos
            const errorDivDatos = document.getElementById('errorDivDatos');
            const errorDivPassword = document.getElementById('errorDivPassword');
            const errorDatosMessage = "<?php echo  isset($errorDatos) ? $errorDatos : ''; ?>";
            const succesDatosMessage = "<?php echo isset($successDatos) ? $successDatos : ''; ?>";
            const errorPasswordMessage = "<?php echo  isset($errorPassword) ? $errorPassword : ''; ?>";
            const succesPasswordMessage = "<?php echo isset($successPassword) ? $successPassword : ''; ?>";

            //como no utilizo ajax y recargo la página, guardo la posición del scroll para
            //volver a la misma posición
            if (localStorage.getItem('scrollPosition')) {
                window.scrollTo(0, localStorage.getItem('scrollPosition'));
                localStorage.removeItem('scrollPosition');
            }

            if (errorDatosMessage.length > 0) {
                errorDivDatos.textContent = errorMessage;

            } else if (succesDatosMessage.length > 0) {
                Swal.fire({
                    title: "Datos actualizados",
                    text: succesDatosMessage,
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#60A5FA",
                }).then(()=>{
                 

                });
            }
            if (errorPasswordMessage.length > 0) {
                errorDivPassword.textContent = errorPasswordMessage;

            } else if (succesPasswordMessage.length > 0) {
                Swal.fire({
                    title: "Datos actualizados",
                    text: succesPasswordMessage,
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#60A5FA",
                }).then(() => {
                   passwordInput.value = '';
                   password2Input.value = '';
                   /*  document.getElementById('guarda_password').scrollIntoView({
                        behavior: 'smooth'
                    }); */

                });
            }

            nombreInput.addEventListener('input', function() {
                errorDivDatos.textContent = '';

            });
            apellidosInput.addEventListener('input', function() {
                errorDivDatos.textContent = '';

            });
            passwordInput.addEventListener('input', function() {
                errorDivPassword.textContent = '';

            });
            password2Input.addEventListener('input', function() {
                errorDivPassword.textContent = '';

            });
            guardaDatosForm.addEventListener('submit', function(e) {
                e.preventDefault();
                localStorage.setItem('scrollPosition', window.scrollY);

                Swal.fire({
                    title: "¿Quieres guardar los cambios?",
                    //showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Guardar",
                    confirmButtonColor: "#60A5FA",
                    denyButtonText: `No guardar`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        guardaDatosForm.submit();
                    } else if (result.isDenied) {
                        //Swal.fire("Changes are not saved", "", "info");
                    }
                });


            });

            guardaPasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                //guardamos la posición del scroll para volver a la misma posición al recargar
                localStorage.setItem('scrollPosition', window.scrollY);
                Swal.fire({
                    title: "¿Quieres guardar los cambios?",
                    //showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Guardar",
                    confirmButtonColor: "#60A5FA",
                    denyButtonText: `No guardar`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        guardaPasswordForm.submit();
                    } else if (result.isDenied) {
                        //Swal.fire("Changes are not saved", "", "info");
                    }
                });

            });
        });
    </script>
</head>

<body class="min-h-screen flex flex-col bg-slate-100">

    <?php
    include_once('./components/menu.php');
    if (isset($_SESSION['username'])) {
        echo '<p class="text-center mt-10 text-lg text-blue-900 font-light">Hola! Nos alegramos de volverte a ver, <span class="uppercase font-bold"> ' . $_SESSION['username'] . '</span></p>';
    }
    if (isset($server_error) && $server_error) {
        include('./components/internal_error.php');
        include_once('./components/footer.php');
        exit();
    }


    ?>

    <h1 class="text-center mt-10 text-4xl text-blue-500 font-light">
        Perfil de Usuario
    </h1>

    <?php
    include_once('./components/menu.php');
    ?>
    <main class="container flex flex-col mx-auto rounded-sm pt-12 flex-grow">
        <div class="flex flex-col justify-center items-center w-full h-full mx-auto">

            <form id="guarda_datos" class=" flex flex-col  w-3/4 md:4/5 h-full px-5 sm:px-10 py-10 text-center bg-white rounded-3xl border border-gray-200" method="POST">
                <h2 class="text-start text-2xl text-blue-500 font-light mb-3">Modifica tus datos</h2>
                <label for="nombre" class="mb-2 text-sm text-start text-gray-900 font-bold">Nombre<span class="text-red-500">*</span></label>
                <input id="nombre" name="nombre" type="text" placeholder="Introduce tu nombre" maxlength="100" value="<?php echo $nombre; ?>" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border required:invalid:border-red-500" required />
                <label for="apellidos" class="mb-2 text-sm text-start text-gray-900 font-bold">Apellidos<span class="text-red-500">*</span></label>
                <input id="apellidos" name="apellidos" type="text" placeholder="Introduce tus apellidos" maxlength="100" value="<?php echo $apellidos; ?>" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border required:invalid:border-red-500" required />

                <div class="flex justify-end w-full ">
                    <button class="w-full  px-6 py-5 mt-5 mb-5 text-sm font-bold leading-none text-white transition duration-300 md:w-40 rounded-2xl hover:bg-blue-400 focus:ring-4 focus:ring-purple-blue-100 bg-blue-500">Guardar</button>
                </div>
                <div id="errorDivDatos" class="mb-4 text-red-500"></div>

            </form>
            <form id="guarda_password" class="mt-10 mb-10 flex flex-col  w-3/4 md:4/5 h-full px-5 sm:px-10 py-10 text-center bg-white rounded-3xl border border-gray-200" method="POST">
                <h2 class="text-start text-2xl text-blue-500 font-light mb-3">Modifica tu Contraseña</h2>

                <label for="password" class="mb-2 text-sm text-start text-gray-900 font-bold">Contraseña nueva<span class="text-red-500">*</span></label>
                <input id="password" name="password" type="password" placeholder="Introduce contraseña" maxlength="15" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" class="flex items-center w-full px-5 py-4 mb-5 mr-2 text-sm font-medium outline-none focus:bg-grey-400 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border" required />
                <label for="password2" class="mb-2 text-sm text-start text-gray-900 font-bold">Repite Contraseña<span class="text-red-500">*</span></label>
                <input id="password2" name="password2" type="password" placeholder="Repite contraseña" maxlength="15" value="<?php echo isset($_POST['password2']) ? $_POST['password2'] : ''; ?>" class="flex items-center w-full px-5 py-4 mb-5 mr-2 text-sm font-medium outline-none focus:bg-grey-400 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl border" required />

                <div class="flex justify-end w-full ">
                    <button id="guarda_password" class="w-full  px-6 py-5 mt-5 mb-5 text-sm font-bold leading-none text-white transition duration-300 md:w-40 rounded-2xl hover:bg-blue-400 focus:ring-4 focus:ring-purple-blue-100 bg-blue-500">Guardar</button>
                </div>
                <div id="errorDivPassword" class="mb-4 text-red-500"></div>

            </form>
        </div>

    </main>

    <?php
    include_once('./components/footer.php');
    ?>


</body>

</html>