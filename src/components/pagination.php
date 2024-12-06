<div class="flex items-center justify-center py-10 lg:px-0 sm:px-6 px-4 mt-10">
  <!-- lg:w-3/5 -->
  <div class="md:w-4/5 w-full flex items-center justify-between border-t border-gray-200">
  <a href="?pagina=<?php echo ($pagina > 1) ? $pagina - 1 :  1 ?>">
    <div class="flex items-center pt-3 text-gray-600 hover:text-blue-700 cursor-pointer">
      <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1.1665 4H12.8332" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M1.1665 4L4.49984 7.33333" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M1.1665 4.00002L4.49984 0.666687" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
      <p class="text-sm ml-3 font-medium leading-none ">Anterior</p>
    </div>
  </a>
    <div class="sm:flex hidden">
      <?php
      for ($i = 1; $i <= $total_paginas; $i++) {
        if ($pagina == $i) {
          echo "<p class='text-sm font-medium leading-none cursor-pointer  text-blue-500 hover:text-blue-500 border-t border-transparent hover:border-blue-400 pt-3 mr-4 px-2'>$i</p>";
        } else {
          echo "<a href='?pagina=$i' class='text-sm font-medium leading-none cursor-pointer text-gray-600 hover:text-blue-700 border-t border-transparent hover:border-blue-400 pt-3 mr-4 px-2'>$i</a>";
        }
      }
      /* <p class="text-sm font-medium leading-none cursor-pointer text-gray-600 hover:text-blue-700 border-t border-transparent hover:border-blue-400 pt-3 mr-4 px-2">1</p> */
      ?>

    </div>
    <a href="?pagina=<?php echo ($pagina < $total_paginas) ? $pagina + 1 : $total_paginas ?>">
      <div class="flex items-center pt-3 text-gray-600 hover:text-blue-700 cursor-pointer">
        <p class="text-sm font-medium leading-none mr-3">Siguiente</p>
        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M1.1665 4H12.8332" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M9.5 7.33333L12.8333 4" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M9.5 0.666687L12.8333 4.00002" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
    </a>
  </div>
</div>