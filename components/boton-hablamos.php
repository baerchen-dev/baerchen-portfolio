<?php
/**
 * BOTÓN HABLAMOS →→
 * Texto en movimiento continuo (animate-marquee, definido en src/css/main.css).
 * Sin color propio: hereda el del contenedor.
 *
 * $args['clase'] Visibilidad y clases extra. Por defecto 'inline-flex'.
 *                 Incluir siempre el display (p. ej. 'hidden md:inline-flex'): si el componente
 *                 fijara el suyo, chocaría con 'hidden' y el botón se vería siempre
 * $args['url']   Destino. Por defecto, la página con slug "contacto"
 */
$contacto = get_page_by_path( 'contacto' );
$url      = $args['url'] ?? ( $contacto ? get_permalink( $contacto ) : home_url( '/contacto/' ) );
$clase    = $args['clase'] ?? 'inline-flex';
$texto    = __( 'Hablamos', 'baerchen' );

// Doble flecha →→ con el icono de la familia (se repite en el medidor y en las dos copias de la cinta)
ob_start();
?><span class="inline-flex -space-x-0.5"><?php get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-derecha', 'clase' => 'size-[1em]' ) ); get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-derecha', 'clase' => 'size-[1em]' ) ); ?></span><?php
$flechas = ob_get_clean();
?>
<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $clase ); ?> relative h-10 items-center overflow-hidden cursor-pointer font-mono font-medium text-base uppercase tracking-wider hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current">
  <span class="sr-only"><?php echo esc_html( $texto ); ?></span>

  <!-- Medidor invisible: da al botón el ancho exacto de una copia del texto -->
  <span class="invisible inline-flex items-center gap-2 whitespace-nowrap pr-4" aria-hidden="true"><?php echo esc_html( $texto ); ?> <?php echo $flechas; // SVG del tema ?></span>

  <!-- Dos copias iguales: al desplazar -50% el bucle no se nota -->
  <span class="absolute inset-y-0 left-0 w-max flex items-center animate-marquee motion-reduce:animate-none" aria-hidden="true">
    <span class="inline-flex items-center gap-2 whitespace-nowrap pr-4"><?php echo esc_html( $texto ); ?> <?php echo $flechas; ?></span>
    <span class="inline-flex items-center gap-2 whitespace-nowrap pr-4"><?php echo esc_html( $texto ); ?> <?php echo $flechas; ?></span>
  </span>
</a>