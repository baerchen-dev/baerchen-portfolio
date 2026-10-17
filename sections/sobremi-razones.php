<?php
/**
 * SOBRE MÍ · POR QUÉ YO (Figma: bloque "03 — Por qué yo") · crema
 * Cabecera → lista de filas separadas por líneas ink/20: número (columna 1) · título (2–4) · texto (5–12).
 * Móvil: número y título en una línea y el texto debajo. Razones desde el campo "Razones" (Título | Texto).
 */
$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$etiqueta = $campo( 'sobre_razones_etiqueta', __( '/ Por qué yo', 'baerchen' ) );
$titular  = $campo( 'sobre_razones_titular', __( 'Una sola mirada para cuidar todo el recorrido.', 'baerchen' ) );
$razones  = baerchen_lista( $campo( 'sobre_razones_lista', __( "Visión completa | Diseño y desarrollo conviven desde el primer boceto.\nBase técnica real | Más de 20 años en tecnología. Entiendo lo que hay detrás de una web: servidor, correo y mantenimiento.\nCriterio y detalle | Cuido tanto la idea general como el último estado de un botón.\nCuatro idiomas | Trabajo en español, catalán, alemán e inglés.", 'baerchen' ) ), 2 );
?>
<section class="bg-bg" data-fondo="claro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-24 md:py-32">

    <?php get_template_part( 'components/cabecera-seccion', null, array( 'etiqueta' => $etiqueta, 'titular' => $titular ) ); ?>

    <?php if ( $razones ) : ?>
      <ol class="mt-16 md:mt-24 border-b border-ink/20">
        <?php foreach ( $razones as $i => list( $titulo, $texto ) ) : ?>
          <li class="grid grid-cols-4 gap-x-4 gap-y-3 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8 items-baseline border-t border-ink/20 py-8.5">
            <span class="font-mono font-medium text-sm uppercase leading-[1.4]" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
            <h3 class="col-span-3 md:col-span-7 xl:col-span-3 font-bold text-2xl leading-tight"><?php echo esc_html( $titulo ); ?></h3>
            <p class="col-span-4 col-start-1 md:col-span-7 md:col-start-2 xl:col-start-5 xl:col-span-8 text-parrafo text-ink/60"><?php echo esc_html( $texto ); ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
    <?php endif; ?>

  </div>
</section>
