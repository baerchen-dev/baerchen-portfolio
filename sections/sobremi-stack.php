<?php
/**
 * SOBRE MÍ · STACK (Figma: bloque "05 — Stack") · crema
 * Cabecera → filas separadas por líneas ink/20: NOMBRE en mono (columnas 1–4) · herramientas en Párrafo destacado (5–12).
 * Móvil y tablet: el nombre encima de las herramientas. Grupos desde el campo "Herramientas" (NOMBRE | herramientas).
 */
$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$etiqueta = $campo( 'sobre_stack_etiqueta', __( '/ Stack', 'baerchen' ) );
$titular  = $campo( 'sobre_stack_titular', __( 'Las herramientas cambian. El criterio permanece.', 'baerchen' ) );
$grupos   = baerchen_lista( $campo( 'sobre_stack_lista', __( "Diseño | Figma · FigJam · Prototipado · Design systems\nDesarrollo | WordPress · JavaScript · React\nFront-end | HTML · CSS · Tailwind · Git\nCalidad | Accesibilidad · Rendimiento · SEO técnico · Responsive", 'baerchen' ) ), 2 );
?>
<section class="bg-bg" data-fondo="claro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-24 md:py-32">

    <?php get_template_part( 'components/cabecera-seccion', null, array( 'etiqueta' => $etiqueta, 'titular' => $titular ) ); ?>

    <?php if ( $grupos ) : ?>
      <dl class="mt-16 md:mt-20 border-b border-ink/20">
        <?php foreach ( $grupos as list( $nombre, $herramientas ) ) : ?>
          <div class="grid grid-cols-4 gap-x-4 gap-y-3 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8 xl:items-center border-t border-ink/20 py-7">
            <dt class="col-span-4 md:col-span-8 xl:col-span-4 font-mono font-medium text-sm uppercase leading-[1.4]"><?php echo esc_html( $nombre ); ?></dt>
            <dd class="col-span-4 md:col-span-8 text-parrafo-destacado"><?php echo esc_html( $herramientas ); ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    <?php endif; ?>

  </div>
</section>
