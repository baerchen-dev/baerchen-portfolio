<?php
/**
 * CASO DE ESTUDIO · PRESENTACIÓN (Figma: bloque "01 — Hero" del caso de estudio)
 * Etiqueta "Caso de estudio — 01" + titular (h1, ola de color al cargar) en las columnas 1–7, foto 2:3 en las 8–12
 * y, abajo a la izquierda (alineados con el pie de la foto), entradilla + contexto + "Ver web en vivo ↗".
 * Tablet: etiqueta y titular a todo el ancho; debajo, foto (1–4) y texto (5–8). Móvil: todo apilado.
 * Movimiento (src/css/main.css): la foto entra con una cortina y los textos suben; nada con "reducir movimiento".
 */
$campo = function ( $nombre ) {
  return function_exists( 'get_field' ) ? get_field( $nombre ) : '';
};

$titular    = $campo( 'caso_titular' ) ?: get_the_title();
$entradilla = $campo( 'caso_entradilla' );
$contexto   = $campo( 'caso_contexto' );
$url_web    = $campo( 'proyecto_url' );
$foto_id    = $campo( 'caso_foto' ) ?: get_post_thumbnail_id();
$foto_arr   = $campo( 'caso_foto_arriba' );
$foto_abj   = $campo( 'caso_foto_abajo' );
$numero     = baerchen_proyecto_numero();
?>
<section class="bg-bg" data-fondo="claro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-12 md:pt-16 pb-24 md:pb-32 grid grid-cols-4 gap-x-4 gap-y-10 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">

    <!-- ETIQUETA + TITULAR · columnas 1–7 -->
    <div class="col-span-4 md:col-span-8 xl:col-span-7 xl:row-start-1 flex flex-col gap-8">
      <p class="entrada font-mono text-base md:text-lg uppercase leading-none">
        <?php echo esc_html( sprintf( __( 'Caso de estudio — %s', 'baerchen' ), $numero ) ); ?>
      </p>
      <h1 class="text-titulo-pagina"><?php echo baerchen_ola( $titular ); // ola de color al cargar ?></h1>
    </div>

    <!-- FOTO · columnas 8–12 (2:3), con dos líneas de datos encima -->
    <div class="group cortina relative col-span-4 md:row-start-2 xl:col-start-8 xl:col-span-5 xl:row-start-1 xl:row-span-2 overflow-hidden rounded-4xl">
      <?php if ( $foto_id ) :
        echo wp_get_attachment_image( $foto_id, 'baerchen-retrato', false, array(
          'class'         => 'w-full aspect-2/3 object-cover transition-transform duration-700 ease-out group-hover:scale-104 motion-reduce:transition-none',
          'sizes'         => '(min-width: 1280px) 488px, (min-width: 768px) 50vw, 100vw',
          'loading'       => 'eager',
          'fetchpriority' => 'high',
        ) );
      else : ?>
        <div class="w-full aspect-2/3 bg-ink/10" aria-hidden="true"></div>
      <?php endif; ?>

      <?php if ( $foto_arr || $foto_abj ) : ?>
        <!-- Degradados para que el texto crema se lea sobre cualquier foto -->
        <div class="absolute inset-0 bg-linear-to-b from-ink/50 via-transparent to-ink/50 pointer-events-none" aria-hidden="true"></div>
        <?php if ( $foto_arr ) : ?>
          <p class="absolute left-6 top-6 md:left-8 md:top-8 font-mono font-medium text-sm uppercase leading-[1.4] text-bg"><?php echo esc_html( $foto_arr ); ?></p>
        <?php endif; ?>
        <?php if ( $foto_abj ) : ?>
          <p class="absolute left-6 right-6 bottom-6 md:left-8 md:right-8 md:bottom-8 font-mono font-medium text-sm uppercase leading-[1.4] text-bg"><?php echo esc_html( $foto_abj ); ?></p>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <!-- ENTRADILLA + CONTEXTO + WEB · abajo a la izquierda, alineados con el pie de la foto -->
    <?php if ( $entradilla || $contexto || $url_web ) : ?>
      <div class="entrada entrada-2 col-span-4 md:col-start-5 md:row-start-2 xl:col-start-1 xl:col-span-7 xl:row-start-2 self-end flex flex-col gap-8">
        <?php if ( $entradilla ) : ?>
          <p class="text-parrafo-destacado xl:max-w-148"><?php echo esc_html( $entradilla ); ?></p>
        <?php endif; ?>

        <?php if ( $contexto || $url_web ) : ?>
          <div class="pt-6 border-t border-ink/18 flex flex-wrap items-center justify-between gap-x-8 gap-y-4">
            <?php if ( $contexto ) : ?>
              <p class="font-mono font-medium text-sm uppercase leading-[1.4] text-ink/60"><?php echo esc_html( $contexto ); ?></p>
            <?php endif; ?>
            <?php if ( $url_web ) : ?>
              <a href="<?php echo esc_url( $url_web ); ?>" target="_blank" rel="noopener" class="group flex items-center gap-2 font-mono text-base uppercase leading-none cursor-pointer hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current">
                <?php esc_html_e( 'Ver web en vivo', 'baerchen' ); ?>
                <?php get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-diagonal', 'clase' => 'size-[1em]', 'mover' => 'diagonal' ) ); ?>
                <span class="sr-only"><?php esc_html_e( '(se abre en una pestaña nueva)', 'baerchen' ); ?></span>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>
</section>
