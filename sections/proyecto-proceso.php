<?php
/**
 * CASO DE ESTUDIO · PROCESO STICKY (Figma: bloque "04 — Proceso (sticky)" del caso de estudio) · id="proceso", crema
 * Cabecera (etiqueta 1–4 + titular 5–12) → capítulos a la izquierda + escenario fijo a la derecha.
 * Capítulos desde el campo "Capítulos" (una línea por capítulo: Antetítulo | Título | Texto), imagen n.º 1–4 en sus campos.
 * Si el último capítulo no tiene imagen propia, su escena es un collage con las imágenes de los anteriores.
 *
 * Funcionamiento (assets/js/caso-sticky.js, solo md+): al cargar añade data-listo a la sección. Entonces se oculta la
 * imagen de cada capítulo y aparece el escenario fijo (columnas 7–12); el capítulo más cercano al centro de la pantalla
 * lleva data-activo y su escena también. CSS (src/css/main.css): capítulos inactivos al 30 % y la escena activa entra
 * con una cortina. Móvil, sin JS o antes de que cargue: capítulos apilados, cada uno con su imagen; no se oculta nada.
 * Rótulos del escenario en etiqueta crema (como las del collage): se leen sobre cualquier imagen, clara u oscura.
 * El escenario repite las imágenes: va oculto para lectores de pantalla (las imágenes con texto alternativo son las de
 * cada capítulo).
 */
$campo = function ( $nombre ) {
  return function_exists( 'get_field' ) ? get_field( $nombre ) : '';
};

$titular    = $campo( 'caso_proceso_titular' );
$capitulos  = array_slice( baerchen_lista( $campo( 'caso_capitulos' ), 3 ), 0, 4 );
$imagenes   = array();
foreach ( $capitulos as $i => $capitulo ) $imagenes[ $i ] = $campo( 'caso_capitulo_' . ( $i + 1 ) . '_imagen' );

if ( ! $capitulos ) return;

$total  = count( $capitulos );
$ultimo = $total - 1;
// Collage del último capítulo: sin imagen propia y con al menos dos imágenes antes
$previas  = array_filter( array_slice( $imagenes, 0, $ultimo ) );
$collage  = ! $imagenes[ $ultimo ] && count( $previas ) >= 2;
$sizes    = '(min-width: 1280px) 592px, (min-width: 768px) 50vw, 100vw';
$num      = fn( $i ) => sprintf( '%02d', $i + 1 );

// Posición y giro de cada tarjeta del collage (en % del escenario)
$tarjetas = array( 'left-[7%] top-[11%] -rotate-4', 'left-[39%] top-[35%] rotate-3', 'left-[12%] top-[58%] -rotate-2' );
?>
<section id="proceso" class="group/proceso bg-bg scroll-mt-18" data-fondo="claro" data-proceso>
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-24 md:py-32">

    <?php if ( $titular ) get_template_part( 'components/cabecera-seccion', null, array( 'etiqueta' => __( '/ 02 — El proceso', 'baerchen' ), 'titular' => $titular ) ); ?>

    <div class="mt-16 md:mt-24 grid grid-cols-4 gap-x-4 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">

      <!-- CAPÍTULOS · columnas 1–5 (tablet 1–4) -->
      <ol class="col-span-4 xl:col-span-5 flex flex-col gap-20 md:gap-0">
        <?php foreach ( $capitulos as $i => list( $antetitulo, $titulo, $texto ) ) : ?>
          <li class="proceso-capitulo flex flex-col justify-center gap-4 md:group-data-listo/proceso:min-h-[min(90svh,48rem)]" data-capitulo="<?php echo (int) $i; ?>">
            <p class="font-mono font-medium text-sm uppercase leading-[1.4] text-ink/60"><?php echo esc_html( $num( $i ) . ' — ' . $antetitulo ); ?></p>
            <h3 class="font-bold text-2xl md:text-[2rem] leading-none"><?php echo esc_html( $titulo ); ?></h3>
            <p class="text-parrafo text-ink/60"><?php echo esc_html( $texto ); ?></p>

            <!-- Imagen del capítulo (móvil, sin JS): se oculta cuando el escenario fijo toma el relevo -->
            <?php if ( $imagenes[ $i ] ) : ?>
              <figure class="mt-4 md:group-data-listo/proceso:hidden">
                <?php echo wp_get_attachment_image( $imagenes[ $i ], 'baerchen-ancho', false, array( 'class' => 'w-full aspect-[592/860] object-cover rounded-4xl', 'sizes' => $sizes ) ); ?>
              </figure>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ol>

      <!-- ESCENARIO FIJO · columnas 7–12 (tablet 5–8) · solo md+ con JS -->
      <div class="hidden md:group-data-listo/proceso:block md:col-start-5 md:col-span-4 xl:col-start-7 xl:col-span-6" aria-hidden="true">
        <div class="proceso-escenario sticky top-24 ml-auto w-full aspect-[592/860] overflow-hidden rounded-4xl bg-accent text-bg">
          <?php foreach ( $capitulos as $i => list( $antetitulo ) ) : ?>
            <div class="proceso-escena absolute inset-0" data-escena="<?php echo (int) $i; ?>">

              <?php if ( $i === $ultimo && $collage ) : ?>
                <?php $n = 0; foreach ( $previas as $j => $imagen_id ) : if ( $n > 2 ) break; ?>
                  <div class="absolute w-[54%] aspect-4/3 overflow-hidden rounded-2xl bg-bg shadow-xl <?php echo esc_attr( $tarjetas[ $n ] ); ?>">
                    <?php echo wp_get_attachment_image( $imagen_id, 'baerchen-ancho', false, array( 'class' => 'size-full object-cover', 'sizes' => '(min-width: 1280px) 320px, 30vw', 'alt' => '' ) ); ?>
                    <span class="absolute left-3 top-3 rounded bg-bg px-2 py-1 font-mono font-medium text-sm uppercase leading-[1.4] text-ink"><?php echo esc_html( $capitulos[ $j ][0] ); ?></span>
                  </div>
                <?php $n++; endforeach; ?>
              <?php elseif ( $imagenes[ $i ] ) : ?>
                <?php echo wp_get_attachment_image( $imagenes[ $i ], 'baerchen-ancho', false, array( 'class' => 'size-full object-cover', 'sizes' => $sizes, 'alt' => '' ) ); ?>
              <?php endif; ?>

              <p class="absolute right-6 top-6 md:right-8 md:top-8 rounded bg-bg px-2 py-1 font-mono font-medium text-sm uppercase leading-[1.4] text-ink"><?php echo esc_html( $num( $i ) . ' — ' . sprintf( '%02d', $total ) ); ?></p>
              <p class="absolute left-6 bottom-6 md:left-8 md:bottom-8 rounded bg-bg px-2 py-1 font-mono font-medium text-sm uppercase leading-[1.4] text-ink"><?php echo esc_html( $num( $i ) . ' / ' . $antetitulo ); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</section>
