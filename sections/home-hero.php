<?php
/**
 * HOME · HERO (Figma: nodo 68:424)
 * Retícula: móvil 4 columnas + 16px · md+ 12 columnas + 32px (Figma)
 * Escritorio: foto en las columnas 1–5 · texto en las 6–12. Móvil: texto y debajo la foto (sin VER TRABAJOS: se baja deslizando)
 * Los textos y la foto salen de los campos ACF "Home · Hero" (Páginas → Inicio).
 * Si un campo está vacío, se usa el texto del diseño.
 */
$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$etiqueta = $campo( 'hero_etiqueta', __( '/ Diseño UX & desarrollo web', 'baerchen' ) );
$titular  = $campo( 'hero_titular', __( 'Construyo webs que duran', 'baerchen' ) );
$parrafo  = $campo( 'hero_parrafo', __( 'Convierto tus ideas en productos digitales rápidos y fáciles de usar. Sin tecnicismos ni complicaciones: diseño con sentido y desarrollo a medida.', 'baerchen' ) );
$cta      = $campo( 'hero_cta', __( 'Ver trabajos', 'baerchen' ) );
$foto_id  = $campo( 'hero_foto', 0 );

$url_cta = '#trabajos';   // sección Trabajos de la Home (sections/home-trabajos.php)
?>
<!-- data-cortina: se queda fija al terminar de verse y la sección de trabajos sube por encima (top calculado en header.js) -->
<section class="relative bg-bg md:sticky" data-cortina data-fondo="claro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-12 pb-16 md:pb-24">
    <div class="grid grid-cols-4 gap-x-4 gap-y-10 md:grid-cols-12 md:gap-x-8">

      <!-- FOTO · columnas 1–5 (en móvil, después del texto) -->
      <div class="col-span-4 md:col-span-5 order-2 md:order-1">
        <?php if ( $foto_id ) :
          $alt = get_post_meta( $foto_id, '_wp_attachment_image_alt', true );
          echo wp_get_attachment_image( $foto_id, 'baerchen-retrato', false, array(
            'class'         => 'w-full aspect-2/3 object-cover rounded-4xl',
            'sizes'         => '(min-width: 1280px) 488px, (min-width: 768px) 38vw, 100vw',
            'alt'           => $alt ? $alt : __( 'Retrato de Francisco Estévez', 'baerchen' ),
            'loading'       => 'eager',
            'fetchpriority' => 'high',
          ) );
        else : ?>
          <div class="w-full aspect-2/3 rounded-4xl bg-ink/10" aria-hidden="true"></div>
        <?php endif; ?>
      </div>

      <!-- TEXTO · columnas 6–12 -->
      <div class="col-span-4 md:col-span-7 order-1 md:order-2 flex flex-col">
        <p class="font-mono text-base md:text-lg uppercase leading-none"><?php echo esc_html( $etiqueta ); ?></p>

        <h1 class="mt-8 font-medium text-[clamp(3rem,5.7vw,5.125rem)] leading-[0.88]"><?php echo baerchen_ola( $titular ); // ola de color (functions.php) ?></h1>

        <p class="mt-12 md:mt-20 max-w-[36.875rem] text-lg md:text-xl leading-[1.25]"><?php echo esc_html( $parrafo ); ?></p>

        <!-- Solo md+: abajo del todo, alineado con el pie de la foto. En móvil se baja deslizando -->
        <a href="<?php echo esc_url( $url_cta ); ?>" class="hidden md:block md:mt-auto self-start font-mono text-base uppercase leading-none cursor-pointer hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current">
          <?php echo esc_html( $cta ); ?> <span class="inline-block motion-safe:animate-bounce" aria-hidden="true">↓</span>
        </a>
      </div>

    </div>
  </div>
</section>
