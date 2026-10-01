<?php
/**
 * PÁGINA TRABAJOS (Figma: "Grid / XL 1445 Trabajos", nodo 51:197)
 * WordPress la usa automáticamente para la página con slug "trabajos".
 * Titular editable en el campo ACF "Trabajos · Cabecera". Tarjetas: components/card-proyecto.php
 * Retícula: móvil 1 por fila · md 2 por fila (4 de 8 col.) · xl 2 por fila (6 de 12 col. = 592px)
 */
get_header();

$titular = function_exists( 'get_field' ) ? get_field( 'trabajos_titular' ) : '';
$titular = $titular ? $titular : __( 'Creando proyectos', 'baerchen' );

$proyectos = new WP_Query( array(
  'post_type'      => 'proyecto',
  'posts_per_page' => -1,
  'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),   // campo "Orden" del proyecto
  'no_found_rows'  => true,
) );
?>
<section class="bg-bg">
  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-16 md:pt-24 pb-24">

    <h1 class="font-medium text-5xl md:text-[3.5rem] leading-none"><?php echo esc_html( $titular ); ?></h1>

    <?php if ( $proyectos->have_posts() ) : ?>
      <div class="mt-16 md:mt-20 grid grid-cols-4 gap-x-4 gap-y-16 md:grid-cols-8 md:gap-x-6 md:gap-y-20 xl:grid-cols-12 xl:gap-x-8">
        <?php while ( $proyectos->have_posts() ) : $proyectos->the_post(); ?>
          <div class="col-span-4 xl:col-span-6">
            <?php get_template_part( 'components/card-proyecto' ); ?>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else : ?>
      <p class="mt-16 text-lg text-ink/60"><?php esc_html_e( 'Pronto habrá proyectos aquí.', 'baerchen' ); ?></p>
    <?php endif; wp_reset_postdata(); ?>

  </div>
</section>

<?php get_footer(); ?>
