<?php
/**
 * PÁGINA CONTACTO (Figma: "Grid / XL 1444 contacto", nodo 123:1544)
 * WordPress la usa automáticamente para la página con slug "contacto".
 * xl: texto en las columnas 1–5 · columna 6 vacía · formulario en las 7–12. Debajo, la cinta y 3 tarjetas de servicios.
 * Móvil y tablet: todo apilado (texto → formulario → cinta → tarjetas).
 * Contenido desde los campos ACF "Contacto" (acf-json/group_baerchen_contacto.json); si están vacíos, textos del diseño.
 * Formulario: Contact Form 7 (código del formulario en inc/formulario-contacto.html; su código corto, en el campo "Formulario").
 */
get_header();

$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$etiqueta       = $campo( 'contacto_etiqueta', __( '/ Contacto', 'baerchen' ) );
$titular        = $campo( 'contacto_titular', __( 'Construyamos algo juntos', 'baerchen' ) );
$etiqueta_email = $campo( 'contacto_etiqueta_email', __( '/ Escríbeme', 'baerchen' ) );
$email          = $campo( 'contacto_email', 'info@baerchen.dev' );
$respuesta      = $campo( 'contacto_respuesta', __( 'Respondo en 24–48 h', 'baerchen' ) );
$formulario     = $campo( 'contacto_formulario', '' );
$cinta          = $campo( 'contacto_cinta', __( 'Diseño UX/UI · Desarrollo WordPress · Mejora de webs', 'baerchen' ) );

$servicios_defecto = array(
  1 => array( 'titulo' => __( 'Diseño UX/UI', 'baerchen' ),        'frase' => __( 'De la idea al prototipo, pensando en quien la va a usar.', 'baerchen' ), 'lista' => "Investigación y arquitectura\nWireframes y prototipo en Figma\nDiseño visual responsive\nSistema de diseño" ),
  2 => array( 'titulo' => __( 'Desarrollo WordPress', 'baerchen' ),'frase' => __( 'Webs a medida, rápidas y fáciles de editar.', 'baerchen' ),              'lista' => "Tema a medida, sin constructores\nResponsive y accesible\nOptimización de velocidad y SEO técnico\nPanel fácil de editar (ACF)" ),
  3 => array( 'titulo' => __( 'Mejora de webs', 'baerchen' ),      'frase' => __( 'Tu web actual, más rápida, accesible y fácil de usar.', 'baerchen' ),    'lista' => "Auditoría de velocidad y accesibilidad\nOptimización de imágenes y código\nCorrecciones de diseño y responsive\nSEO técnico y mantenimiento" ),
);
?>
<section class="bg-bg">
  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-16 md:pt-24 xl:pt-36">
    <div class="grid grid-cols-4 gap-x-4 gap-y-16 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">

      <!-- TEXTO · columnas 1–5 (en xl, alineado arriba con el primer campo y abajo con el botón) -->
      <div class="col-span-4 md:col-span-8 xl:col-span-5 flex flex-col gap-16 xl:justify-between">
        <div class="flex flex-col gap-8">
          <p class="font-mono text-base md:text-lg uppercase leading-none"><?php echo esc_html( $etiqueta ); ?></p>
          <h1 class="text-titulo-seccion"><?php echo baerchen_ola( $titular ); // ola de color al cargar ?></h1>
        </div>

        <div class="flex flex-col gap-6">
          <p class="font-mono text-base md:text-lg uppercase leading-none"><?php echo esc_html( $etiqueta_email ); ?></p>
          <a href="mailto:<?php echo antispambot( sanitize_email( $email ) ); ?>" class="self-start text-email break-all cursor-pointer hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current"><?php echo antispambot( sanitize_email( $email ) ); ?></a>
          <?php if ( $respuesta ) : ?><p class="font-mono font-medium text-sm uppercase leading-[1.4] text-ink/60"><?php echo esc_html( $respuesta ); ?></p><?php endif; ?>
        </div>
      </div>

      <!-- FORMULARIO · columnas 7–12 -->
      <div id="formulario" class="col-span-4 md:col-span-8 xl:col-start-7 xl:col-span-6 formulario-contacto scroll-mt-28">
        <?php if ( $formulario ) :
          echo do_shortcode( wp_kses_post( $formulario ) );
        elseif ( current_user_can( 'edit_pages' ) ) : ?>
          <!-- Solo lo ven los administradores -->
          <p class="rounded-xl bg-white/50 p-6 text-base"><?php esc_html_e( 'Falta el formulario: crea uno en Contacto → Añadir nuevo (código en inc/formulario-contacto.html) y pega su código corto en el campo "Formulario" de esta página.', 'baerchen' ); ?></p>
        <?php endif; ?>
      </div>

    </div>
  </div>

  <!-- CINTA · a todo el ancho de la pantalla, fuera de la retícula -->
  <div class="mt-24">
    <?php get_template_part( 'components/cinta', null, array( 'texto' => $cinta ) ); ?>
  </div>

  <!-- SERVICIOS · 3 tarjetas de 4 columnas -->
  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-24 pb-24 md:pb-40">
    <h2 class="sr-only"><?php esc_html_e( 'Servicios', 'baerchen' ); ?></h2>
    <div class="grid grid-cols-4 gap-4 md:grid-cols-8 md:gap-6 xl:grid-cols-12 xl:gap-8">
      <?php for ( $n = 1; $n <= 3; $n++ ) :
        $servicio = function_exists( 'get_field' ) ? get_field( 'servicio_' . $n ) : null;
        $servicio = array_merge( $servicios_defecto[ $n ], array_filter( (array) $servicio ) ); ?>
        <div class="col-span-4 md:col-span-8 xl:col-span-4">
          <?php get_template_part( 'components/tarjeta-servicio', null, $servicio ); ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
