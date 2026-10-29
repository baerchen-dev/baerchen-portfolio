<?php
/**
 * CASO DE ESTUDIO · LA ENTREGA (Figma: bloque "06 — La entrega" del caso de estudio) · oscuro, a todo el ancho
 * Dos composiciones, según el campo "Posición del titular":
 * - Sobre la imagen (por defecto): imagen a pantalla completa (16:9 desde md; 4:5 en móvil) con un degradado abajo, y
 *   encima, abajo a la izquierda, etiqueta + titular (Título sección) en las columnas 1–8. Para fotos (MQFF).
 * - Encima: etiqueta + titular arriba y la imagen debajo, entera y sin degradado. Para capturas con mucho texto (PASO),
 *   donde un titular encima chocaría con el texto de las pantallas.
 * Sin imagen: fondo ink. Quieta (sin efecto al hacer scroll).
 */
$campo = function ( $nombre ) {
  return function_exists( 'get_field' ) ? get_field( $nombre ) : '';
};

$titular   = $campo( 'caso_entrega_titular' );
$imagen_id = $campo( 'caso_entrega_imagen' );
$encima    = $imagen_id && 'encima' === $campo( 'caso_entrega_titular_posicion' );

if ( ! $titular ) return;

$textos = function () use ( $titular ) { ?>
  <div class="grid grid-cols-4 gap-x-4 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
    <div class="col-span-4 md:col-span-8 flex flex-col gap-6">
      <p class="font-mono text-base md:text-lg uppercase leading-none"><?php esc_html_e( '/ 04 — La entrega', 'baerchen' ); ?></p>
      <h2 class="text-titulo-seccion"><?php echo nl2br( esc_html( $titular ), false ); ?></h2>
    </div>
  </div>
<?php };
?>
<?php if ( $encima ) : ?>
<section class="bg-ink text-bg" data-fondo="oscuro">

  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-24 md:pt-32 pb-12 md:pb-16">
    <?php $textos(); ?>
  </div>

  <?php echo wp_get_attachment_image( $imagen_id, 'baerchen-ancho', false, array(
    'class' => 'block w-full h-auto',
    'sizes' => '100vw',
  ) ); ?>

</section>
<?php else : ?>
<section class="relative bg-ink text-bg overflow-hidden" data-fondo="oscuro">

  <?php if ( $imagen_id ) :
    echo wp_get_attachment_image( $imagen_id, 'baerchen-ancho', false, array(
      'class' => 'absolute inset-0 size-full object-cover',
      'sizes' => '100vw',
    ) );
  endif; ?>
  <div class="absolute inset-0 bg-linear-to-b from-transparent from-30% to-ink/75" aria-hidden="true"></div>

  <div class="relative max-w-7xl mx-auto px-4 md:px-8 pb-16 md:pb-28 aspect-4/5 md:aspect-auto md:min-h-[min(56.25vw,100svh)] flex flex-col justify-end">
    <?php $textos(); ?>
  </div>

</section>
<?php endif; ?>
