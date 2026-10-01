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
?>
<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $clase ); ?> relative h-10 items-center overflow-hidden cursor-pointer font-mono font-medium text-base uppercase tracking-wider hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current">
  <span class="sr-only"><?php echo esc_html( $texto ); ?></span>

  <!-- Medidor invisible: da al botón el ancho exacto de una copia del texto -->
  <span class="invisible whitespace-nowrap pr-4" aria-hidden="true"><?php echo esc_html( $texto ); ?> →→</span>

  <!-- Dos copias iguales: al desplazar -50% el bucle no se nota -->
  <span class="absolute inset-y-0 left-0 w-max flex items-center animate-marquee motion-reduce:animate-none" aria-hidden="true">
    <span class="whitespace-nowrap pr-4"><?php echo esc_html( $texto ); ?> →→</span>
    <span class="whitespace-nowrap pr-4"><?php echo esc_html( $texto ); ?> →→</span>
  </span>
</a>
