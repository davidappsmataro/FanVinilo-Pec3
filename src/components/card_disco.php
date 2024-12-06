<!-- component -->
 <a href="./post.php?id=<?php echo $id; ?>">

     <div class="flex justify-center items-center ">
         <div class="max-w-[720px] mx-auto">
             <div class="relative flex flex-col text-gray-700 bg-white shadow-md bg-clip-border rounded-xl w-72">
                 <div class="relative mx-4 mt-4 overflow-hidden text-gray-700 bg-white bg-clip-border rounded-xl h-64">
                     <?php
                echo '<img src="' . $imagen . '" alt="card-image" class="object-cover w-full h-full" />';
                ?>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <p class="block font-sans text-base antialiased font-medium leading-relaxed text-blue-gray-900">
                        <?php echo $artista ? $artista : 'Artista'; ?>
                    </p>
                    <p class="block font-sans text-xl antialiased font-bold leading-relaxed text-blue-gray-900">
                        <?php echo $precio ? $precio . '€' : 'Precio'; ?>
                    </p>
                </div>
                <p class="block font-sans text-xl antialiased font-bold leading-normal text-blue-500">
                    <?php echo $titulo ? $titulo : 'Título'; ?>
                </p>
            </div>
            
        </div>
    </div>
</div>
</a>