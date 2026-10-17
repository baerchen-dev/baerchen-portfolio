<?php
/**
 * SOBRE MÍ · PRESENTACIÓN (Figma: bloque "01 — Hero" del marco Sobre mí)
 * Etiqueta → titular (h1, ola de color al cargar) → foto en las columnas 1–5 + texto en las 7–12, centrado en vertical.
 * Tablet: foto y texto en 4 + 4 columnas. Móvil: todo apilado (etiqueta → titular → foto → texto).
 * "CONOCE CÓMO TRABAJO ↓" baja al bloque siguiente (#como-trabajo).
 */
$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$etiqueta   = $campo( 'sobre_etiqueta', __( '/ Sobre mí', 'baerchen' ) );
$titular    = $campo( 'sobre_titular', __( "Diseño con sentido.\nDesarrollo sin atajos.", 'baerchen' ) );
$entradilla = $campo( 'sobre_entradilla', __( 'Soy Fran, diseñador UX/UI y desarrollador web. Diseño y construyo webs claras, cuidadas y fáciles de usar.', 'baerchen' ) );
$parrafo    = $campo( 'sobre_parrafo', __( 'Me muevo entre Figma y el código porque creo que una buena experiencia no termina en una pantalla: también tiene que funcionar bien, cargar rápido y durar.', 'baerchen' ) );
$enlace     = $campo( 'sobre_enlace', __( 'Conoce cómo trabajo', 'baerchen' ) );
$foto_id    = $campo( 'sobre_foto', 0 );
?>
<section class="bg-bg" data-fondo="claro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-12 md:pt-16 pb-24 md:pb-32">

    <p class="font-mono text-base md:text-lg uppercase leading-none"><?php echo esc_html( $etiqueta ); ?></p>

    <h1 class="mt-8 md:mt-18 text-titulo-pagina"><?php echo baerchen_ola( $titular ); // ola de color al cargar ?></h1>

    <div class="mt-12 md:mt-18 grid grid-cols-4 gap-x-4 gap-y-10 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">

      <!-- FOTO · columnas 1–5 -->
      <div class="col-span-4 xl:col-span-5">
        <?php if ( $foto_id ) :
          $alt = get_post_meta( $foto_id, '_wp_attachment_image_alt', true );
          echo wp_get_attachment_image( $foto_id, 'baerchen-presentacion', false, array(
            'class'         => 'w-full aspect-4/5 object-cover rounded-4xl',
            'sizes'         => '(min-width: 1280px) 488px, (min-width: 768px) 50vw, 100vw',
            'alt'           => $alt ? $alt : __( 'Retrato de Francisco Estévez', 'baerchen' ),
            'loading'       => 'eager',
            'fetchpriority' => 'high',
          ) );
        else : ?>
          <div class="w-full aspect-4/5 rounded-4xl bg-ink/10" aria-hidden="true"></div>
        <?php endif; ?>
      </div>

      <!-- TEXTO · columnas 7–12, centrado en vertical con la foto -->
      <div class="col-span-4 xl:col-start-7 xl:col-span-6 self-center flex flex-col gap-8">
        <p class="text-entradilla"><?php echo esc_html( $entradilla ); ?></p>
        <p class="text-parrafo text-ink/60"><?php echo esc_html( $parrafo ); ?></p>
        <a href="#como-trabajo" class="self-start flex items-center gap-2 font-mono text-base uppercase leading-none cursor-pointer hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current">
          <?php echo esc_html( $enlace ); ?>
          <?php get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-abajo', 'clase' => 'size-[1em] motion-safe:animate-bounce' ) ); ?>
        </a>
      </div>

    </div>
  </div>
</section>
