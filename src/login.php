<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="output.css">
    <script
        defer
        src="https://kit.fontawesome.com/fa121e3cca.js"
        crossorigin="anonymous"></script>
    <script src="./js/sidebar.js" defer></script>

</head>

<body class="min-h-screen">

    <?php
    include_once('./components/menu.php');
    ?>
    <div class="container flex flex-col mx-auto rounded-lg pt-12 my-5">
        <div class="flex justify-center w-full h-full my-auto xl:gap-14 lg:justify-normal md:gap-5">
            <div class="flex items-center justify-center w-full lg:p-12">
                <div class="flex items-center xl:p-10">
                    <form class="flex flex-col w-full h-full pb-6 text-center bg-white rounded-3xl">
                        <h1 class="mb-3 text-4xl font-extrabold text-dark-grey-900">Inicia Sesión</h1>
                        <p class="mb-4 text-grey-700">Introduce Email y contraseña</p>

                        <label for="email" class="mb-2 text-sm text-start text-gray-900 font-bold">Email<span class="text-red-500">*</span></label>
                        <input id="email" type="email" placeholder="mail@uoc.edu" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl" />
                        <label for="password" class="mb-2 text-sm text-start text-gray-900 font-bold">Contraseña<span class="text-red-500">*</span></label>
                        <input id="password" type="password" placeholder="Introduce contraseña" class="flex items-center w-full px-5 py-4 mb-5 mr-2 text-sm font-medium outline-none focus:bg-grey-400 placeholder:text-grey-700 bg-gray-100 text-dark-grey-900 rounded-2xl" />

                        <button class="w-full px-6 py-5 mt-5 mb-5 text-sm font-bold leading-none text-white transition duration-300 md:w-96 rounded-2xl hover:bg-blue-400 focus:ring-4 focus:ring-purple-blue-100 bg-blue-500">Sign In</button>
                        <p class="text-sm leading-relaxed text-grey-900">¿No te has registrado todavía? <a href="./signup.php" class="font-bold text-grey-700">Crear Cuenta</a></p>
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