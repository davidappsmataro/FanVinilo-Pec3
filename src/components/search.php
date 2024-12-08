<form action="./records.php" method="GET" class="flex flex-col">
    <div class="flex flex-wrap w-full h-full  mt-10 justify-center">

        <div class="flex flex-col">

            <h2 class="mb-3 text-md font-extrabold text-blue-400 text-center sm:text-start">Ordenar por</h2>
            <div class="flex sm:flex-row items-center justify-end flex-wrap">
                <div class="flex flex-col">

                    <label for="precio" class="mb-2 text-sm text-start text-gray-900 font-bold">Precio</label>
                    <!-- <input id="product" type="text" placeholder="Introduce el nombre del producto" class="flex items-center w-full px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-white text-dark-grey-900 rounded-2xl" /> -->
                    <select name="precio" id="precio" class="flex items-center w-28  px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-white text-dark-grey-900 rounded-xl">
                        <option value="0" <?php echo $query_precio == '0' ? 'selected' : ''; ?>>No</option>
                        <option value="ASC" <?php echo $query_precio == 'ASC' ? 'selected' : ''; ?>>Asc</option>
                        <option value="DESC" <?php echo $query_precio == 'DESC' ? 'selected' : ''; ?>>Desc</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="fecha" class="mb-2 text-sm text-start text-gray-900 font-bold">Fecha de Lanzamiento</label>
                    <select name="fecha" id="fecha" class="flex items-center w-48  px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-white text-dark-grey-900 rounded-xl">
                        <option value="0" <?php echo $query_fecha == '0' ? 'selected' : ''; ?>>No</option>
                        <option value="ASC" <?php echo $query_fecha == 'ASC' ? 'selected' : ''; ?>>Asc</option>
                        <option value="DESC" <?php echo $query_fecha == 'DESC' ? 'selected' : ''; ?>>Desc</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="flex flex-col">

            <h2 class="mb-3 text-md font-extrabold text-blue-400 text-center sm:text-start">Buscar por</h2>
            <div class="flex sm:flex-row items-center justify-center flex-wrap">
                <div class="flex flex-col">
                    <label for="artista" class="mb-2 text-sm text-start text-gray-900 font-bold">Artista</label>
                    <input name="artista" id="artista" type="text" placeholder="Artista..." value="<?php echo htmlspecialchars($query_artista); ?>" class="flex items-center w-48 px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-white text-dark-grey-900 rounded-xl" />
                </div>
                <div class="flex flex-col">
                    <label for="genero" class="mb-2 text-sm text-start text-gray-900 font-bold">Género Musical</label>
                    <select name="genero" id="genero" class="flex items-center w-48  px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-white text-dark-grey-900 rounded-xl">
                        <option value="0">Cualquiera</option>
                        <?php
                        foreach ($genero as $value) {
                            $selected = $query_genero == $value ? 'selected' : '';
                            echo "<option value=\"$value\" $selected >$value</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="flex flex-col">
                    <label for="estado" class="mb-2 text-sm text-start text-gray-900 font-bold">Estado del disco</label>
                    <select name="estado" id="estado" class="flex items-center w-48  px-5 py-4 mr-2 text-sm font-medium outline-none focus:bg-grey-400 mb-7 placeholder:text-grey-700 bg-white text-dark-grey-900 rounded-xl capitalize">
                        <option value="0">Cualquiera</option>
                        <?php
                        foreach ($estado as $value) {
                            $capitalizado = ucwords(strtolower($value));
                            $selected = $query_estado == $value ? 'selected' : '';
                            echo "<option value=\"$value\" $selected>$capitalizado</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

    </div>
    <div class="flex items-center justify-center lg:justify-end lg:mr-14">
        <div class="<?php echo $filtros_aplicados ? 'flex' : 'hidden'; ?> justify-center items-center w-24 h-12 text-sm font-bold leading-none text-white transition duration-300 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-purple-blue-100 bg-blue-800 animate-fadeIn">
            <a href="./records.php">Limpiar</a>
        </div>
        <button type="submit" class="w-24 h-12 ml-2 text-sm font-bold leading-none text-white transition duration-300 rounded-xl hover:bg-blue-400 focus:ring-4 focus:ring-purple-blue-100 bg-blue-500">Aplicar</button>

    </div>



</form>