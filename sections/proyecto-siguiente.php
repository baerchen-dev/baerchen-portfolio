<?php
/**
 * CASO DE ESTUDIO · SIGUIENTE (Figma: bloque "08 — Siguiente caso de estudio") · id="siguiente", oscuro
 * El proyecto que va después según el campo "Orden" (tras el último, vuelve al primero). Si solo hay uno, no sale.
 * Foto 9:8 en las columnas 1–7 (gris; al pasar el ratón recupera el color y se acerca un 4 %) + texto abajo en las 8–12:
 * "Caso de estudio — 02", nombre, frase, etiquetas y enlace. Todo el bloque es un enlace: al caso de estudio si lo tiene
 * (baerchen_proyecto_tiene_caso) y, si no, a su web real en una pestaña nueva. Sin ninguno de los dos (proyecto aún en
 * desarrollo): sin enlace y con "Caso de estudio en preparación".
 */
$siguiente = baerchen_proyecto_siguiente();
if ( ! $siguiente ) return;

$id        = $siguiente->ID;
$frase     = function_exists( 'get_field' ) ? get_field( 'proyecto_frase', $id ) : '';
$url_web   = function_exists( 'get_field' ) ? get_field( 'proyecto_url', $id ) : '';
$con_caso  = baerchen_proyecto_tiene_caso( $id );
$externo   = ! $con_caso && $url_web;
$enlace    = $con_caso || $url_web;
$destino   = $externo ? $url_web : get_permalink( $id );
$estado    = function_exists( 'get_field' ) ? get_field( 'proyecto_estado', $id ) : '';
$etiquetas = get_the_terms( $id, 'etiqueta_proyecto' );
$nota      = 'font-mono font-medium text-sm uppercase leading-[1.4]';
?>
<section id="siguiente" class="bg-ink text-bg" data-fondo="oscuro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-24 md:py-32">

    <p class="font-mono text-base md:text-lg uppercase leading-none"><?php esc_html_e( '/ Siguiente caso de estudio', 'baerchen' ); ?></p>

    <?php if ( $enlace ) : ?>
    <a href="<?php echo esc_url( $destino ); ?>"<?php if ( $externo ) : ?> target="_blank" rel="noopener"<?php endif; ?> class="group mt-16 grid grid-cols-4 gap-x-4 gap-y-8 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8 cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-8 focus-visible:outline-bg">
    <?php else : ?>
    <div class="group mt-16 grid grid-cols-4 gap-x-4 gap-y-8 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
    <?php endif; ?>

      <!-- FOTO · columnas 1–7 -->
      <div class="col-span-4 md:col-span-5 xl:col-span-7 overflow-hidden rounded-4xl">
        <?php if ( has_post_thumbnail( $id ) ) :
          echo get_the_post_thumbnail( $id, 'baerchen-tarjeta', array(
            'class' => 'w-full aspect-9/8 object-cover grayscale transition-[filter,scale] duration-700 ease-out group-hover:grayscale-0 group-hover:scale-104 motion-reduce:transition-none',
            'sizes' => '(min-width: 1280px) 704px, (min-width: 768px) 60vw, 100vw',
            'alt'   => '',
          ) );
        else : ?>
          <div class="w-full aspect-9/8 bg-bg/10" aria-hidden="true"></div>
        <?php endif; ?>
      </div>

      <!-- TEXTO · columnas 8–12, abajo -->
      <div class="col-span-4 md:col-span-3 xl:col-start-8 xl:col-span-5 self-end flex flex-col gap-6">
        <p class="<?php echo esc_attr( $nota ); ?> text-bg/60"><?php echo esc_html( sprintf( __( 'Caso de estudio — %s', 'baerchen' ), baerchen_proyecto_numero( $id ) ) ); ?></p>
        <h2 class="text-titulo-seccion"><?php echo esc_html( get_the_title( $id ) ); ?></h2>
        <?php if ( $frase ) : ?>
          <p class="text-parrafo text-bg/60"><?php echo esc_html( $frase ); ?></p>
        <?php endif; ?>
        <?php if ( ( $etiquetas && ! is_wp_error( $etiquetas ) ) || 'desarrollo' === $estado ) : ?>
          <ul class="flex flex-wrap gap-2.5" aria-label="<?php esc_attr_e( 'Etiquetas', 'baerchen' ); ?>">
            <?php if ( 'desarrollo' === $estado ) : ?>
              <li class="font-mono font-bold text-sm uppercase leading-none p-2 rounded border border-bg bg-bg text-ink"><?php esc_html_e( 'En desarrollo', 'baerchen' ); ?></li>
            <?php endif; ?>
            <?php if ( $etiquetas && ! is_wp_error( $etiquetas ) ) : foreach ( $etiquetas as $etiqueta ) : ?>
              <li class="font-mono font-bold text-sm uppercase leading-none p-2 rounded border border-bg/50"><?php echo esc_html( $etiqueta->name ); ?></li>
            <?php endforeach; endif; ?>
          </ul>
        <?php endif; ?>
        <?php if ( $enlace ) : ?>
          <span class="flex items-center gap-2 font-mono text-base uppercase leading-none">
            <?php echo esc_html( $externo ? __( 'Ver web', 'baerchen' ) : __( 'Ver caso de estudio', 'baerchen' ) ); ?>
            <?php get_template_part( 'components/icono', null, array( 'nombre' => $externo ? 'flecha-diagonal' : 'flecha-derecha', 'clase' => 'size-[1em]', 'mover' => $externo ? 'diagonal' : 'derecha' ) ); ?>
            <?php if ( $externo ) : ?><span class="sr-only"><?php esc_html_e( '(se abre en una pestaña nueva)', 'baerchen' ); ?></span><?php endif; ?>
          </span>
        <?php else : ?>
          <p class="<?php echo esc_attr( $nota ); ?> text-bg/60"><?php esc_html_e( 'Caso de estudio en preparación', 'baerchen' ); ?></p>
        <?php endif; ?>
      </div>

    <?php echo $enlace ? '</a>' : '</div>'; ?>
  </div>
</section>
