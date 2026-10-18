<?php
/**
 * CASO DE ESTUDIO · EL SISTEMA (Figma: bloque "05 — El sistema" del caso de estudio) · crema
 * Cabecera (etiqueta 1–4 + titular 5–12) → texto en las columnas 5–12 → tablero:
 *   fila 1: fuente principal (1–8) + colores apilados (9–12)
 *   fila 2: fuente secundaria (1–4) + principio (5–8) + contraste del acento (9–12)
 * Las piezas del tablero usan las fuentes y los colores DEL PROYECTO (estilos en línea); las etiquetas, los del portfolio.
 * Fuentes desde el campo "Fuentes" (Familia | Peso | Uso | Muestra), cargadas de Google Fonts solo en este caso
 * (baerchen_fuentes_caso() en inc/proyectos.php). Colores desde "Colores" (Nombre | #hex): el último es el acento.
 * El contraste se calcula solo (baerchen_contraste): ≥ 4,5 texto normal (AA) · ≥ 3 solo grande y botones.
 */
$campo = function ( $nombre ) {
  return function_exists( 'get_field' ) ? get_field( $nombre ) : '';
};

$titular   = $campo( 'caso_sistema_titular' );
$texto     = $campo( 'caso_sistema_texto' );
$fuentes   = array_slice( baerchen_lista( $campo( 'caso_sistema_fuentes' ), 4 ), 0, 2 );
$principio = $campo( 'caso_sistema_principio' );
$colores   = array();
foreach ( array_slice( baerchen_lista( $campo( 'caso_sistema_colores' ), 2 ), 0, 3 ) as list( $nombre, $hex ) ) {
  $hex = sanitize_hex_color( $hex );
  if ( $hex ) $colores[] = array( 'nombre' => $nombre, 'hex' => strtoupper( $hex ) );
}

if ( ! $titular && ! $fuentes && ! $colores ) return;

// Color de texto para cada fondo: el color de la paleta con más contraste sobre él
$sobre = function ( $fondo ) use ( $colores ) {
  $mejor = '#FFFFFF'; $max = 0;
  foreach ( $colores as $c ) {
    $r = baerchen_contraste( $fondo, $c['hex'] );
    if ( $r > $max ) { $max = $r; $mejor = $c['hex']; }
  }
  return $mejor;
};
// Fondo de las tarjetas oscuras: el color más oscuro de la paleta (si no hay, el ink del portfolio)
$oscuro = '#141311';
if ( $colores ) {
  $ordenados = $colores;
  usort( $ordenados, fn( $a, $b ) => baerchen_luminancia( $a['hex'] ) <=> baerchen_luminancia( $b['hex'] ) );
  $oscuro = $ordenados[0]['hex'];
}
$claro  = $sobre( $oscuro );
$acento = $colores ? end( $colores )['hex'] : '';
$fuente = fn( $familia, $peso ) => 'font-family:\'' . esc_attr( $familia ) . '\', sans-serif;font-weight:' . (int) $peso;
$nota   = 'font-mono font-medium text-sm uppercase leading-[1.4]';
?>
<section class="bg-bg" data-fondo="claro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-24 md:py-32">

    <?php if ( $titular ) get_template_part( 'components/cabecera-seccion', null, array( 'etiqueta' => __( '/ 03 — El sistema', 'baerchen' ), 'titular' => $titular ) ); ?>

    <?php if ( $texto ) : ?>
      <div class="mt-12 md:mt-16 grid grid-cols-4 gap-x-4 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
        <p class="col-span-4 md:col-span-6 xl:col-start-5 xl:col-span-6 text-parrafo"><?php echo esc_html( $texto ); ?></p>
      </div>
    <?php endif; ?>

    <div class="mt-16 grid grid-cols-4 gap-4 md:grid-cols-8 md:gap-6 xl:grid-cols-12 xl:gap-8">

      <!-- FUENTE PRINCIPAL · columnas 1–8 -->
      <?php if ( isset( $fuentes[0] ) ) : list( $familia, $peso, $uso, $muestra ) = $fuentes[0]; ?>
        <figure class="col-span-4 md:col-span-8 min-h-80 xl:min-h-110 flex flex-col justify-between gap-10 rounded-4xl p-8 md:p-10" style="background-color:<?php echo esc_attr( $oscuro ); ?>;color:<?php echo esc_attr( $claro ); ?>">
          <p class="text-[8rem] md:text-[12.5rem] leading-none" style="<?php echo $fuente( $familia, $peso ); ?>" aria-hidden="true">Aa</p>
          <figcaption class="flex flex-col gap-3">
            <?php if ( $muestra ) : ?>
              <p class="text-[1.75rem] md:text-[2.5rem] leading-none uppercase" style="<?php echo $fuente( $familia, $peso ); ?>"><?php echo esc_html( $muestra ); ?></p>
            <?php endif; ?>
            <p class="<?php echo $nota; ?> opacity-60"><?php echo esc_html( $familia . ( $uso ? ' · ' . $uso : '' ) ); ?></p>
          </figcaption>
        </figure>
      <?php endif; ?>

      <!-- COLORES · columnas 9–12, apilados (tablet: en fila) -->
      <?php if ( $colores ) : ?>
        <ul class="col-span-4 md:col-span-8 xl:col-span-4 grid gap-4 md:grid-cols-3 xl:grid-cols-1" aria-label="<?php esc_attr_e( 'Colores', 'baerchen' ); ?>">
          <?php foreach ( $colores as $c ) : ?>
            <?php $borde = baerchen_contraste( $c['hex'], '#F6F4F0' ) < 1.5 ? 'border border-ink/18' : ''; // colores casi iguales al fondo (blanco): borde fino ?>
            <li class="min-h-28 flex items-end justify-between gap-4 rounded-3xl p-6 <?php echo esc_attr( $borde . ' ' . $nota ); ?>" style="background-color:<?php echo esc_attr( $c['hex'] ); ?>;color:<?php echo esc_attr( $sobre( $c['hex'] ) ); ?>">
              <span><?php echo esc_html( $c['nombre'] ); ?></span>
              <span><?php echo esc_html( $c['hex'] ); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <!-- FUENTE SECUNDARIA · columnas 1–4 -->
      <?php if ( isset( $fuentes[1] ) ) : list( $familia, $peso, $uso, $muestra ) = $fuentes[1]; ?>
        <figure class="col-span-4 min-h-70 flex flex-col justify-between gap-10 rounded-4xl p-8 bg-white border border-ink/18" style="color:<?php echo esc_attr( $oscuro ); ?>">
          <p class="text-[1.75rem] leading-[1.2] uppercase" style="<?php echo $fuente( $familia, $peso ); ?>"><?php echo esc_html( $muestra ? $muestra : $familia ); ?></p>
          <figcaption class="<?php echo $nota; ?> opacity-60"><?php echo esc_html( $familia . ( $uso ? ' · ' . $uso : '' ) ); ?></figcaption>
        </figure>
      <?php endif; ?>

      <!-- PRINCIPIO · columnas 5–8 -->
      <?php if ( $principio ) : ?>
        <div class="col-span-4 min-h-70 flex flex-col justify-between gap-10 rounded-4xl p-8 border border-ink/20">
          <p class="<?php echo $nota; ?> text-ink/60"><?php esc_html_e( 'Principio', 'baerchen' ); ?></p>
          <p class="font-bold text-2xl leading-tight"><?php echo esc_html( $principio ); ?></p>
        </div>
      <?php endif; ?>

      <!-- CONTRASTE DEL ACENTO · columnas 9–12 (sobre cada uno de los otros colores) -->
      <?php if ( count( $colores ) > 1 ) : ?>
        <div class="col-span-4 md:col-span-8 xl:col-span-4 min-h-70 flex flex-col gap-5 rounded-4xl p-8" style="background-color:<?php echo esc_attr( $oscuro ); ?>;color:<?php echo esc_attr( $claro ); ?>">
          <p class="<?php echo $nota; ?> opacity-60"><?php echo esc_html( sprintf( __( 'Contraste del %s', 'baerchen' ), mb_strtolower( end( $colores )['nombre'] ) ) ); ?></p>
          <ul class="flex flex-col gap-4">
            <?php foreach ( array_slice( $colores, 0, -1 ) as $c ) :
              $ratio = baerchen_contraste( $acento, $c['hex'] );
              $uso   = $ratio >= 4.5 ? __( 'texto normal (AA)', 'baerchen' ) : ( $ratio >= 3 ? __( 'solo grande y botones', 'baerchen' ) : __( 'solo decorativo', 'baerchen' ) );
              ?>
              <li class="flex items-center gap-4">
                <span class="size-18 shrink-0 grid place-items-center rounded-2xl border border-white/20 text-[2rem] leading-none" style="background-color:<?php echo esc_attr( $c['hex'] ); ?>;color:<?php echo esc_attr( $acento ); ?>;<?php echo isset( $fuentes[0] ) ? $fuente( $fuentes[0][0], $fuentes[0][1] ) : ''; ?>" aria-hidden="true">Aa</span>
                <span class="flex flex-col gap-1">
                  <span class="text-2xl leading-none font-extrabold"><?php echo esc_html( number_format_i18n( $ratio, 1 ) . ':1' ); ?></span>
                  <span class="<?php echo $nota; ?> opacity-60"><?php echo esc_html( sprintf( __( 'Sobre %1$s · %2$s', 'baerchen' ), mb_strtolower( $c['nombre'] ), $uso ) ); ?></span>
                </span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>
