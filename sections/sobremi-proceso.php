<?php
/**
 * SOBRE MÍ · CÓMO TRABAJO (Figma: bloque "02 — Cómo trabajo") · id="como-trabajo", oscuro
 * Cabecera (etiqueta 1–4 + titular 5–12) → 3 tarjetas de 4 columnas con borde bg/20: número, título y texto.
 * Tablet: una tarjeta debajo de otra. Tarjetas desde el campo "Tarjetas" (una por línea: Título | Texto).
 */
$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$etiqueta = $campo( 'sobre_proceso_etiqueta', __( '/ Cómo trabajo', 'baerchen' ) );
$titular  = $campo( 'sobre_proceso_titular', __( 'De la pregunta correcta al producto que funciona.', 'baerchen' ) );
$tarjetas = baerchen_lista( $campo( 'sobre_proceso_lista', __( "Entender antes de diseñar | Empiezo por el problema, las personas y el contexto. Las decisiones visuales llegan después.\nDiseñar con intención | Convierto lo complejo en recorridos claros, sistemas coherentes y decisiones que se pueden explicar.\nConstruir para durar | Desarrollo soluciones rápidas, accesibles y fáciles de mantener. Sin capas innecesarias.", 'baerchen' ) ), 2 );
?>
<section id="como-trabajo" class="bg-ink text-bg scroll-mt-18" data-fondo="oscuro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-24 md:py-28">

    <?php get_template_part( 'components/cabecera-seccion', null, array( 'etiqueta' => $etiqueta, 'titular' => $titular ) ); ?>

    <?php if ( $tarjetas ) : ?>
      <ol class="mt-16 md:mt-24 grid grid-cols-4 gap-4 md:grid-cols-8 md:gap-6 xl:grid-cols-12 xl:gap-8">
        <?php foreach ( $tarjetas as $i => list( $titulo, $texto ) ) : ?>
          <li class="col-span-4 md:col-span-8 xl:col-span-4 flex flex-col gap-18 border border-bg/20 p-6">
            <span class="font-mono font-medium text-sm uppercase leading-[1.4] text-bg/60" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
            <div class="flex flex-col gap-4.5">
              <h3 class="font-bold text-2xl leading-tight"><?php echo esc_html( $titulo ); ?></h3>
              <p class="text-parrafo text-bg/60"><?php echo esc_html( $texto ); ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    <?php endif; ?>

  </div>
</section>
