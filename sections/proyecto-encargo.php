<?php
/**
 * CASO DE ESTUDIO · EL ENCARGO (Figma: bloque "02 — El encargo" del caso de estudio) · id="proyecto", crema
 * Cabecera (etiqueta 1–4 + titular 5–12) → dos párrafos en las columnas 5–8 y 9–12 (los dos en ink: mismo peso)
 * → ficha en 4 columnas de 3 (tablet y móvil: 2 por fila), con línea arriba.
 * Ficha desde el campo "Ficha" (una línea por dato: Etiqueta | Valor). El bloque no sale si está todo vacío.
 */
$campo = function ( $nombre ) {
  return function_exists( 'get_field' ) ? get_field( $nombre ) : '';
};

$titular = $campo( 'caso_encargo_titular' );
$texto_1 = $campo( 'caso_encargo_texto_1' );
$texto_2 = $campo( 'caso_encargo_texto_2' );
$ficha   = baerchen_lista( $campo( 'caso_ficha' ), 2 );

if ( ! $titular && ! $texto_1 && ! $texto_2 && ! $ficha ) return;
?>
<section id="proyecto" class="bg-bg scroll-mt-18" data-fondo="claro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 pb-24 md:pb-32">

    <?php if ( $titular ) get_template_part( 'components/cabecera-seccion', null, array( 'etiqueta' => __( '/ 01 — El encargo', 'baerchen' ), 'titular' => $titular ) ); ?>

    <?php if ( $texto_1 || $texto_2 ) : ?>
      <div class="mt-12 md:mt-16 grid grid-cols-4 gap-x-4 gap-y-6 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
        <?php if ( $texto_1 ) : ?>
          <p class="col-span-4 xl:col-start-5 text-parrafo"><?php echo esc_html( $texto_1 ); ?></p>
        <?php endif; ?>
        <?php if ( $texto_2 ) : ?>
          <p class="col-span-4 xl:col-start-9 text-parrafo"><?php echo esc_html( $texto_2 ); ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ( $ficha ) : ?>
      <dl class="mt-16 md:mt-24 grid grid-cols-4 gap-x-4 gap-y-8 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
        <?php foreach ( $ficha as list( $etiqueta, $valor ) ) : ?>
          <div class="col-span-2 md:col-span-4 xl:col-span-3 flex flex-col gap-3 pt-6 border-t border-ink/18">
            <dt class="font-mono font-medium text-sm uppercase leading-[1.4] text-ink/60"><?php echo esc_html( $etiqueta ); ?></dt>
            <dd class="text-parrafo font-bold"><?php echo esc_html( $valor ); ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    <?php endif; ?>

  </div>
</section>
