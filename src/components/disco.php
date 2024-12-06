<!-- component -->
<main class="container mx-auto flex flex-col flex-grow mt-10 max-w-full">
    <h1 class="block font-sans text-3xl antialiased font-bold leading-normal text-blue-500 text-center uppercase"> <?php echo $titulo ? $titulo : 'Título'; ?></h1>
    <div class="flex flex-col md:flex-row justify-center items-center md:items-start mt-5">
        <div class="mx-4 mt-4 overflow-hidden text-gray-700 max-w-full w-96 rounded-xl shadow-md   ">
            <?php
            echo '<img src="' . $imagen . '" alt="card-image" class="object-cover w-full h-full" />';
            ?>
        </div>
        <div class="p-6 flex flex-col">
            <div class="mb-2">
                <div class="font-bold text-lg">Artista</div>
                <p class="block font-sans text-xl leading-relaxed text-gray-600 uppercase mb-2 first-letter:uppercase">
                    <?php echo $artista; ?>
                </p>
                <div class="font-bold text-lg">Género Musical</div>
                <p class="block font-sans text-xl antialiased leading-relaxed text-gray-600 mb-2 first-letter:uppercase">
                    <?php echo $genero; ?>
                </p>
                <div class="font-bold text-lg">Estado del Disco</div>
                <p class="block font-sans text-xl antialiased leading-relaxed  text-gray-600 mb-2 first-letter:uppercase">
                    <?php echo $estado; ?>
                </p>
                <div class="font-bold text-lg">Fecha de lanzamiento</div>
                <p class="block font-sans text-xl antialiased leading-relaxed  text-gray-600 mb-2 first-letter:uppercase">
                    <?php echo $f_lanzamiento; ?>
                </p>
            </div>
            <div class="mb-2">
                <div class="font-bold text-lg">Precio</div>
                <p class="block font-sans text-3xl leading-relaxed text-blue-500 font-bold uppercase mb-2">
                    <?php echo $precio.'€'; ?>
                </p>
               
            </div>

        </div>


    </div>
</main>