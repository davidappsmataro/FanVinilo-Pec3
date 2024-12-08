<header class="flex-none">
    <!-- component -->
    <nav id="header" class="w-full z-30 top-10 py-1 bg-white shadow-lg border-b border-blue-400">
        <div class="w-full flex items-center justify-between mt-0 px-6 py-2">
            <label id="openSidebar" for="menu-toggle" class="cursor-pointer md:hidden block">
                <svg class="fill-current text-blue-500" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <title>menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                </svg>
            </label>
            <!--  <div class="w-20 h-20">
                        <a href="./index.php"><img
                               
                                src="./assets/logo/logo.png"
                                alt="Logotipo de fanvinilo" />
                        </a>
                    </div> -->
            <input class="hidden" type="checkbox" id="menu-toggle">

            <div class="hidden md:flex md:items-center md:w-auto w-full order-3 md:order-1" id="menu">
                <nav class="flex">
                    <div class="w-20 h-20">
                        <a href="./index.php"><img
                                class="w-full"
                                src="./assets/logo/logo.png"
                                alt="Logotipo de fanvinilo" />
                        </a>
                    </div>
                    <ul class=" md:flex items-center justify-between text-base text-blue-500 pt-4 md:pt-0">
                        <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="./index.php">Home</a></li>
                        <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="./random-post.php">Disco</a></li>
                        <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="./records.php">Discos</a></li>
                        <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="./api/records/1" target="_blank">API_discos</a></li>
                        <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="./api/record/1" target="_blank">API_disco</a></li>
                    </ul>
                </nav>
            </div>


            <div class="order-2 md:order-3 flex flex-wrap items-center justify-end mr-0 md:mr-4" id="nav-content">
                <div class="auth flex items-center w-full md:w-full">
                    <a href="./login.php" class="bg-transparent text-gray-800  p-2 rounded border border-gray-300 mr-4 hover:bg-gray-100 hover:text-gray-700">Inicia Sesión</a>
                    <a href="./signup.php" class="bg-blue-500 text-gray-200  p-2 rounded  hover:bg-blue-400 hover:text-gray-100">Registro</a>

                </div>
            </div>
        </div>
    </nav>
</header>
<aside id="sidebar" class="translate-x-full transform transition-all duration-200 z-20 right-0 top-0">
    <div class="md:hidden">

        <!-- background en negro -->
        <div class="fixed top-0 left-0 w-screen h-screen z-10 bg-black opacity-30">

        </div>
        <!-- blur -->
        <div id="fondoCapa" class="animate-fadeIn fixed top-0 left-0 w-screen h-screen z-10 backdrop-filter backdrop-blur-sm ">

        </div>
        <!-- menu -->

        <nav class="fixed p-5 right-0 top-0 w-[300px] h-screen bg-white z-20 shadow-2xl transform transition-all duration-300">
            <div class="">

                <i id="closeSidebar" class="absolute top-5 right-5 cursor-pointer fa-sharp fa-solid fa-xmark fa-3x text-blue-500"></i>
                <ul class="flex flex-col mt-16">
                    <li><a href="./index.php" class="flex items-center p-2 hover:bg-blue-100 rounded transition-all text-2xl ">
                            <i class="fa-solid fa-music text-blue-500"></i>
                            <span class="ml-3">Inicio</span>
                        </a></li>
                    <li><a href="./random-post.php" class="flex items-center p-2 hover:bg-blue-100 rounded transition-all text-2xl ">
                            <i class="fa-solid fa-record-vinyl text-blue-500"></i>
                            <span class="ml-3">Disco</span>
                        </a></li>
                    <li><a href="./records.php" class="relative flex items-center p-2 hover:bg-blue-200 rounded transition-all text-2xl ">
                            <i class="fa-solid fa-record-vinyl text-blue-500 z-10"></i>
                            <i class="fa-solid fa-record-vinyl text-blue-200 absolute left-4 "></i>
                            <span class="ml-3">Discos</span>
                        </a></li>
                    <li class="w-full h-px bg-gray-200 my-10"></li>

                    <li><a href="./api/records/1" target="_blank" class="flex items-center p-2 hover:bg-blue-200 rounded transition-all text-2xl ">API_discos</a></li>
                    <li><a href="./api/record/1" target="_blank" class="flex items-center p-2 hover:bg-blue-200 rounded transition-all text-2xl ">API_disco</a></li>
                    <li class="w-full h-px bg-gray-200 my-10"></li>
                    
                    <li><a href="./login.php" class="flex items-center p-2 hover:bg-blue-200 rounded transition-all text-2xl ">
                            <i class="fa-solid fa-right-to-bracket text-blue-500"></i>
                            <span class="ml-3">Iniciar Sesión</span>
                        </a></li>
                    <li><a href="./signup.php" class="flex items-center p-2 hover:bg-blue-200 rounded transition-all text-2xl ">
                    <i class="fa-solid fa-user-plus text-blue-500"></i>
                            <span class="ml-3">Registro</span>
                        </a></li>
                    

                </ul>
               
            </div>

        </nav>

    </div>
</aside>