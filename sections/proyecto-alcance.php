<?php
/**
 * CASO DE ESTUDIO · ALCANCE Y APRENDIZAJES (Figma: bloque "07 — Alcance y aprendizajes" del caso de estudio) · crema
 * Cabecera → cifras en 3 columnas de 4 (Valor | Texto) → texto en las columnas 5–12 → "Qué haría distinto hoy"
 * (filas como en Sobre mí: número · título · texto) → enlace grande "Visitar {proyecto} ↗" a la web publicada.
 * Enlace: todo el bloque, fondo ink; al pasar el ratón, terracota (texto de 24px o más: cuenta como grande, 3,9:1).
 */
$campo = function ( $nombre ) {
  return function_exists( 'get_field' ) ? get_field( $nombre ) : '';
};

$titular      = $campo( 'caso_alcance_titular' );
$cifras       = array_slice( baerchen_lista( $campo( 'caso_alcance_cifras' ), 2 ), 0, 3 );
$texto        = $campo( 'caso_alcance_texto' );
$aprendizajes = baerchen_lista( $campo( 'caso_aprendizajes' ), 2 );
$url_web      = $campo( 'proyecto_url' );

if ( ! $titular && ! $cifras && ! $aprendizajes && ! $url_web ) return;

$nota = 'font-mono font-medium text-sm uppercase leading-[1.4]';
?>
<section id="resultado" class="bg-bg scroll-mt-18" data-fondo="claro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-24 md:py-32">

    <?php if ( $titular ) get_template_part( 'components/cabecera-seccion', null, array( 'etiqueta' => __( '/ Alcance', 'baerchen' ), 'titular' => $titular ) ); ?>

    <!-- CIFRAS -->
    <?php if ( $cifras ) : ?>
      <dl class="mt-16 md:mt-24 grid grid-cols-4 gap-x-4 gap-y-8 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
        <?php foreach ( $cifras as list( $valor, $descripcion ) ) : ?>
          <div class="col-span-4 md:col-span-8 xl:col-span-4 flex flex-col-reverse justify-end gap-4 pt-6 border-t border-ink/18">
            <dt class="text-parrafo text-ink/60"><?php echo esc_html( $descripcion ); ?></dt>
            <dd class="text-cifra"><?php echo esc_html( $valor ); ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    <?php endif; ?>

    <?php if ( $texto ) : ?>
      <div class="mt-16 md:mt-24 grid grid-cols-4 gap-x-4 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
        <p class="col-span-4 md:col-span-6 xl:col-start-5 xl:col-span-6 text-parrafo"><?php echo esc_html( $texto ); ?></p>
      </div>
    <?php endif; ?>

    <!-- QUÉ HARÍA DISTINTO HOY -->
    <?php if ( $aprendizajes ) : ?>
      <div class="mt-16 md:mt-24">
        <h3 class="font-mono text-base md:text-lg uppercase leading-none"><?php esc_html_e( 'Qué haría distinto hoy', 'baerchen' ); ?></h3>
        <ol class="mt-6 border-b border-ink/18">
          <?php foreach ( $aprendizajes as $i => list( $titulo, $descripcion ) ) : ?>
            <li class="grid grid-cols-4 gap-x-4 gap-y-3 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8 items-baseline border-t border-ink/18 py-8">
              <span class="<?php echo esc_attr( $nota ); ?> text-ink/60" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
              <h4 class="col-span-3 md:col-span-7 xl:col-span-3 font-bold text-2xl leading-tight"><?php echo esc_html( $titulo ); ?></h4>
              <p class="col-span-4 col-start-1 md:col-span-7 md:col-start-2 xl:col-start-5 xl:col-span-8 text-parrafo text-ink/60"><?php echo esc_html( $descripcion ); ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    <?php endif; ?>

    <!-- VISITAR LA WEB PUBLICADA -->
    <?php if ( $url_web ) : ?>
      <a href="<?php echo esc_url( $url_web ); ?>" target="_blank" rel="noopener" class="group mt-16 md:mt-24 flex flex-col gap-6 md:flex-row md:items-center md:justify-between rounded-4xl bg-ink text-bg p-8 md:p-10 cursor-pointer transition-colors duration-300 hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-ink">
        <span class="<?php echo esc_attr( $nota ); ?> text-bg/60 group-hover:text-bg transition-colors duration-300"><?php esc_html_e( 'Explorar el proyecto publicado', 'baerchen' ); ?></span>
        <span class="flex items-center gap-4 font-mono text-boton uppercase">
          <?php echo esc_html( sprintf( __( 'Visitar %s', 'baerchen' ), get_the_title() ) ); ?>
          <?php get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-diagonal', 'clase' => 'size-[0.9em]', 'mover' => 'diagonal' ) ); ?>
          <span class="sr-only"><?php esc_html_e( '(se abre en una pestaña nueva)', 'baerchen' ); ?></span>
        </span>
      </a>
    <?php endif; ?>

  </div>
</section>
