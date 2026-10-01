<?php
/**
 * FOOTER · COLUMNA (título + menú)
 * Se usa 3 veces en footer.php: Navegación, Social y Legal.
 *
 * $args['titulo']    Texto del título (se muestra en mayúsculas)
 * $args['ubicacion'] Ubicación del menú registrada en functions.php (main-menu, footer-social, footer-legal)
 */
$titulo    = $args['titulo'] ?? '';
$ubicacion = $args['ubicacion'] ?? '';
?>
<div class="flex flex-col gap-6">
  <p class="font-mono font-bold text-lg uppercase tracking-wider leading-none text-bg/60"><?php echo esc_html( $titulo ); ?></p>

  <nav aria-label="<?php echo esc_attr( $titulo ); ?>">
    <?php wp_nav_menu( array(
      'theme_location' => $ubicacion,
      'container'      => false,
      'menu_class'     => 'flex flex-col gap-4',
      'depth'          => 1,
      'fallback_cb'    => false,
      'link_class'     => 'font-medium text-base leading-none cursor-pointer hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current',
    ) ); ?>
  </nav>
</div>
