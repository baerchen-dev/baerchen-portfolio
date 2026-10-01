<?php
/**
 * HOME · SOBRE MÍ (Figma: nodo 102:124) · id="sobre-mi"
 * Texto en las columnas 1–7 · foto en las 8–12 (retícula 12 × 72px + 32px). Fondo crema.
 * Contenido desde los campos ACF "Home · Sobre mí" (Páginas → Inicio); si están vacíos, textos del diseño.
 *
 * EFECTO "CRECER DESDE LA DERECHA" (md+, automático):
 * La sección tiene fondo oscuro por fuera (md:bg-ink) y el panel crema por dentro ([data-crecer-panel]).
 * El panel empieza recortado (clip-path) exactamente a la foto ([data-crecer-foto]): se ve como una tarjeta sobre
 * oscuro. Cuando la foto llega arriba, header.js añade data-abierto y el recorte se abre solo en ~0,9 s
 * (transición en src/css/main.css). Si se vuelve a subir, se cierra. Sin efecto en móvil ni con "reducir movimiento".
 *
 * "MÁS SOBRE MÍ →" aparece si la página Sobre mí está publicada (aunque aún no tenga contenido).
 */
$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$etiqueta = $campo( 'sobremi_etiqueta', __( '/ Sobre mí', 'baerchen' ) );
$titular  = $campo( 'sobremi_titular', __( 'Doy vida a productos digitales', 'baerchen' ) );
$parrafo  = $campo( 'sobremi_parrafo', __( 'Soy Fran, diseñador UX/UI y desarrollador web. Diseño en Figma y lo llevo a WordPress sin constructores: webs rápidas, accesibles y hechas a medida, de principio a fin.', 'baerchen' ) );
$stack    = $campo( 'sobremi_stack', "DISEÑO | Figma · UX/UI · Prototipado\nDESARROLLO | WordPress · PHP · Tailwind · JavaScript\nCALIDAD | Accesibilidad · Rendimiento · SEO" );
$foto_id  = $campo( 'sobremi_foto', 0 );

// Stack: una línea por grupo, "NOMBRE | valores"
$grupos = array();
foreach ( preg_split( '/\r\n|\r|\n/', $stack ) as $linea ) {
  $partes = array_map( 'trim', explode( '|', $linea, 2 ) );
  if ( 2 === count( $partes ) && $partes[0] !== '' ) $grupos[] = $partes;
}

// Enlace a la página Sobre mí: si está publicada
$pagina_sobre = get_page_by_path( 'sobre-mi' );
$url_sobre    = ( $pagina_sobre && 'publish' === $pagina_sobre->post_status ) ? get_permalink( $pagina_sobre ) : '';
?>
<section id="sobre-mi" class="relative md:bg-ink" data-crecer data-fondo="oscuro">
  <div class="relative bg-bg" data-crecer-panel data-fondo="claro">
    <div class="max-w-7xl mx-auto px-4 md:px-8 py-24 md:pt-24 md:pb-40">
      <div class="grid grid-cols-4 gap-x-4 gap-y-12 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">

        <!-- TEXTO · columnas 1–7 -->
        <div class="col-span-4 md:col-span-5 xl:col-span-7 flex flex-col">
          <p class="font-mono text-base md:text-lg uppercase leading-none"><?php echo esc_html( $etiqueta ); ?></p>

          <h2 class="mt-8 font-medium text-[clamp(3rem,5vw,4.5rem)] leading-[0.9]"><?php echo baerchen_ola( $titular, false ); // ola al entrar en pantalla ?></h2>

          <p class="mt-12 md:mt-20 max-w-[28.75rem] text-lg leading-[1.3]"><?php echo esc_html( $parrafo ); ?></p>

          <?php if ( $grupos ) : ?>
            <dl class="mt-12 md:mt-20 grid grid-cols-[max-content_1fr] gap-x-6 gap-y-1 font-mono text-base md:text-lg leading-snug">
              <?php foreach ( $grupos as $grupo ) : ?>
                <dt class="uppercase"><?php echo esc_html( $grupo[0] ); ?></dt>
                <dd><?php echo esc_html( $grupo[1] ); ?></dd>
              <?php endforeach; ?>
            </dl>
          <?php endif; ?>

          <?php if ( $url_sobre ) : ?>
            <!-- Abajo del todo, alineado con el pie de la foto (como VER TRABAJOS en el hero) -->
            <a href="<?php echo esc_url( $url_sobre ); ?>" class="mt-12 md:mt-auto md:pt-12 self-start font-mono text-base uppercase leading-none cursor-pointer hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current">
              <?php esc_html_e( 'Más sobre mí', 'baerchen' ); ?> <span aria-hidden="true">→</span>
            </a>
          <?php endif; ?>
        </div>

        <!-- FOTO · columnas 8–12 · punto de partida del efecto de crecer -->
        <div class="col-span-4 md:col-span-3 xl:col-span-5" data-crecer-foto>
          <?php if ( $foto_id ) :
            $alt = get_post_meta( $foto_id, '_wp_attachment_image_alt', true );
            echo wp_get_attachment_image( $foto_id, 'baerchen-vertical', false, array(
              'class' => 'w-full aspect-3/4 object-cover rounded-4xl',
              'sizes' => '(min-width: 1280px) 488px, (min-width: 768px) 38vw, 100vw',
              'alt'   => $alt ? $alt : __( 'Escritorio de trabajo con Figma y código en pantalla', 'baerchen' ),
            ) );
          else : ?>
            <div class="w-full aspect-3/4 rounded-4xl bg-ink/10" aria-hidden="true"></div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</section>
