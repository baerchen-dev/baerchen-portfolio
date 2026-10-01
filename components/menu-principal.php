<!-- MENÚ PRINCIPAL · prolongación del header a todo el ancho
 * Superficie de cristal que baja desde arriba del todo (por detrás de la fila del logo, -z-10)
 * y se difumina hacia abajo, igual que el header. Enlaces alineados a la derecha.
 * Se abre con .menu-toggle (JS en assets/js/menu.js).
 * Los enlaces entran escalonados desde la derecha: retardos en src/css/main.css (#menu-principal li)
 * Hover: el enlace crece un 25 % hacia la izquierda (scale, no font-size, para no mover los demás)
-->
<div id="menu-principal" class="absolute inset-x-0 top-0 -z-10 pt-20 pb-24 bg-bg/90 backdrop-blur-2xl mask-b-from-75% invisible opacity-0 data-open:visible data-open:opacity-100 transition-[opacity,visibility] duration-300">
  <div class="max-w-7xl mx-auto px-4 md:px-8 flex justify-end">

    <nav aria-label="<?php esc_attr_e( 'Navegación principal', 'baerchen' ); ?>">
      <?php wp_nav_menu( array(
        'theme_location' => 'main-menu',
        'container'      => false,
        'menu_class'     => 'flex flex-col items-end gap-3',
        'depth'          => 1,
        'fallback_cb'    => false,
        'link_class'     => 'inline-flex items-center font-bold text-xl md:text-[1.375rem] uppercase tracking-titulo leading-none cursor-pointer origin-right hover:scale-125 transition-transform duration-300 ease-out motion-reduce:transition-none motion-reduce:hover:scale-100 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current',
      ) ); ?>
    </nav>

  </div>
</div>
