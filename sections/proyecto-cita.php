<?php
/**
 * CASO DE ESTUDIO · CITA (Figma: bloque "03 — Cita" del caso de estudio) · oscuro
 * Cinta (marquesina, components/cinta.php) a todo el ancho → cita grande (Título sección) en las columnas 1–10,
 * con las comillas en terracota (acento del portfolio, no el del proyecto).
 * Las comillas las pone la plantilla: en el campo, la frase sin comillas.
 */
$campo = function ( $nombre ) {
  return function_exists( 'get_field' ) ? get_field( $nombre ) : '';
};

$cinta = $campo( 'caso_cinta' );
$cita  = $campo( 'caso_cita' );

if ( ! $cinta && ! $cita ) return;
?>
<section class="bg-ink text-bg overflow-hidden" data-fondo="oscuro">
  <div class="pt-12 pb-24 md:pb-32 flex flex-col gap-16 md:gap-28">

    <?php get_template_part( 'components/cinta', null, array( 'texto' => $cinta, 'color' => 'text-bg/10' ) ); ?>

    <?php if ( $cita ) : ?>
      <div class="w-full max-w-7xl mx-auto px-4 md:px-8 grid grid-cols-4 gap-x-4 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
        <blockquote class="col-span-4 md:col-span-8 xl:col-span-10">
          <p class="text-titulo-seccion"><span class="text-accent" aria-hidden="true">“</span><?php echo esc_html( $cita ); ?><span class="text-accent" aria-hidden="true">”</span></p>
        </blockquote>
      </div>
    <?php endif; ?>

  </div>
</section>
