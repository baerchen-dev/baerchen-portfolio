<?php
/**
 * HOME · TRABAJOS (Figma: nodo 78:606) · id="trabajos" (destino de "VER TRABAJOS ↓" y del menú)
 * Sección oscura con todos los proyectos (mientras haya pocos; la página Trabajos queda en borrador).
 *
 * COLUMNAS DESPLAZADAS (md+): la columna derecha empieza más abajo.
 * Cada tarjeta ocupa 2 filas de la cuadrícula y empieza en la fila n+1 (su posición en el listado):
 *   1.ª → col. izquierda, filas 1–2 · 2.ª → col. derecha, filas 2–3 · 3.ª → izquierda, filas 3–4…
 * Así la derecha queda desplazada media tarjeta y en móvil se mantiene el orden natural.
 */
$proyectos = new WP_Query( array(
  'post_type'      => 'proyecto',
  'posts_per_page' => -1,
  'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),   // campo "Orden" del proyecto
  'no_found_rows'  => true,
) );
?>
<!-- Sube por encima del hero (efecto cortina) y después sigue el scroll normal.
     data-fondo="oscuro": el header pasa a crema encima de ella -->
<section id="trabajos" class="relative bg-ink text-bg" data-fondo="oscuro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-32 md:pt-40 pb-32 md:pb-16">

    <h2 class="font-medium text-[clamp(3rem,5vw,4.5rem)] leading-none"><?php echo baerchen_ola( __( 'Creando proyectos', 'baerchen' ), false ); // 72px · ola al entrar en pantalla ?></h2>

    <?php if ( $proyectos->have_posts() ) : ?>
      <div class="mt-16 md:mt-20 grid grid-cols-4 gap-x-4 gap-y-16 md:grid-cols-8 md:gap-x-6 md:gap-y-20 xl:grid-cols-12 xl:gap-x-8">
        <?php $n = 0; while ( $proyectos->have_posts() ) : $proyectos->the_post(); $n++; ?>
          <div class="col-span-4 md:row-[var(--fila)/span_2] <?php echo ( $n % 2 ) ? 'md:col-start-1 xl:col-span-6' : 'md:col-start-5 xl:col-start-7 xl:col-span-6'; ?>" style="--fila: <?php echo (int) $n; ?>">
            <?php get_template_part( 'components/card-proyecto', null, array( 'tema' => 'oscuro' ) ); ?>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; wp_reset_postdata(); ?>

  </div>
</section>
