<?php
/**
 * SOBRE MÍ · FUERA DE LA PANTALLA (Figma: bloque "04 — Fuera de la pantalla") · oscuro
 * Cabecera → 3 fotos 2:3 de 4 columnas, cada una con título y texto (bg/60). Tablet: 2 por fila. Móvil: una debajo de otra.
 * Contenido desde los grupos "Afición 1–3" (foto, título, texto).
 */
$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$etiqueta = $campo( 'sobre_aficiones_etiqueta', __( '/ Fuera de la pantalla', 'baerchen' ) );
$titular  = $campo( 'sobre_aficiones_titular', __( 'Lo que hago cuando cierro el portátil.', 'baerchen' ) );

$defecto = array(
  1 => array( 'titulo' => __( 'Sierra de Málaga', 'baerchen' ), 'texto' => __( 'Organizo rutas en un club de senderismo. De ahí nació PASO.', 'baerchen' ) ),
  2 => array( 'titulo' => __( 'Moda · 1992', 'baerchen' ),      'texto' => __( 'Figurines a lápiz de mi etapa en el Institut Català de la Moda. Ahí aprendí proporción, textura y detalle.', 'baerchen' ) ),
  3 => array( 'titulo' => __( 'Baerchen', 'baerchen' ),         'texto' => __( '«Osito» en alemán, un guiño a mis años trabajando en Alemania. Hoy, con vistas a la Costa del Sol.', 'baerchen' ) ),
);
$aficiones = array();
foreach ( $defecto as $n => $def ) {
  $grupo       = function_exists( 'get_field' ) ? (array) get_field( 'sobre_aficion_' . $n ) : array();
  $aficiones[] = array(
    'foto'   => $grupo['foto'] ?? 0,
    'titulo' => ! empty( $grupo['titulo'] ) ? $grupo['titulo'] : $def['titulo'],
    'texto'  => ! empty( $grupo['texto'] ) ? $grupo['texto'] : $def['texto'],
  );
}
?>
<section class="bg-ink text-bg" data-fondo="oscuro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-24 md:py-32">

    <?php get_template_part( 'components/cabecera-seccion', null, array( 'etiqueta' => $etiqueta, 'titular' => $titular ) ); ?>

    <ul class="mt-16 md:mt-20 grid grid-cols-4 gap-x-4 gap-y-12 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
      <?php foreach ( $aficiones as $aficion ) : ?>
        <li class="col-span-4 flex flex-col gap-4">
          <?php if ( $aficion['foto'] ) :
            echo wp_get_attachment_image( $aficion['foto'], 'baerchen-retrato', false, array(
              'class' => 'w-full aspect-2/3 object-cover rounded-4xl',
              'sizes' => '(min-width: 1280px) 384px, (min-width: 768px) 50vw, 100vw',
              'alt'   => '',   // decorativa: el título y el texto ya cuentan qué es
            ) );
          else : ?>
            <div class="w-full aspect-2/3 rounded-4xl bg-bg/10" aria-hidden="true"></div>
          <?php endif; ?>
          <div class="pt-2 flex flex-col gap-2.5">
            <h3 class="font-bold text-2xl leading-tight"><?php echo esc_html( $aficion['titulo'] ); ?></h3>
            <p class="text-parrafo text-bg/60"><?php echo esc_html( $aficion['texto'] ); ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>

  </div>
</section>
