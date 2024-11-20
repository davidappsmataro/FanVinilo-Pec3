<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="output.css">

</head>

<body class="bg-white">

    <?php
    include_once('./components/menu.php');
    ?>
    <div class="container flex flex-col mx-auto rounded-lg pt-12 my-5">
        <div class="flex justify-center w-full h-full my-auto xl:gap-14 lg:justify-normal md:gap-5">
            <div class="flex items-center justify-center w-full lg:p-12">
                <div class="flex items-center xl:p-10">
                    <form class="flex flex-col w-full h-full pb-6 text-center bg-white rounded-3xl">
                        <h1 class="mb-3 text-4xl font-extrabold text-dark-grey-900">Registro</h1>
                        <p class="mb-4 text-grey-700">Regístrate en nuestra web</p>

                        <label for="username" class="mb-2 text-sm text-start text-gray-900 font-bold">Nombre de usuario<span class="text-red-500">*</span></label>
                        <input id="username" type="text" placeholder="Introduce Nombre de usuario" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl" />
                        <label for="name" class="mb-2 text-sm text-start text-gray-900 font-bold">Nombre<span class="text-red-500">*</span></label>
                        <input id="name" type="text" placeholder="Introduce tu nombre" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl" />
                        <label for="surname" class="mb-2 text-sm text-start text-gray-900 font-bold">Apellidos<span class="text-red-500">*</span></label>
                        <input id="surname" type="text" placeholder="Introduce tus apellidos" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl" />
                        <label for="password" class="mb-2 text-sm text-start text-gray-900 font-bold">Contraseña<span class="text-red-500">*</span></label>
                        <input id="password" type="password" placeholder="Introduce contraseña" class="flex items-center w-full px-5 py-4 mb-5 mr-2 text-sm font-medium outline-none focus:bg-grey-400 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl" />
                        <label for="password2" class="mb-2 text-sm text-start text-gray-900 font-bold">Repite Contraseña<span class="text-red-500">*</span></label>
                        <input id="password2" type="password" placeholder="Repite contraseña" class="flex items-center w-full px-5 py-4 mb-5 mr-2 text-sm font-medium outline-none focus:bg-grey-400 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl" />

                        <button class="w-full px-6 py-5 mt-5 mb-5 text-sm font-bold leading-none text-white transition duration-300 md:w-96 rounded-2xl hover:bg-blue-400 focus:ring-4 focus:ring-purple-blue-100 bg-blue-500">Crear Cuenta</button>
                        <p class="text-sm leading-relaxed text-grey-900">¿Ya tienes una cuenta? <a href="./login.php" class="font-bold text-grey-700">Iniciar Sesión</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once('./components/footer.php');
    ?>


</body>

</html>