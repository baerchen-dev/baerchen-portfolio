<?php
/**
 * SOBRE MÍ · TRAYECTORIA (Figma: bloque "04 — Trayectoria") · crema
 * Foto del poste en las columnas 1–4 (2:3) + texto y línea de tiempo en las 6–12.
 * xl: la foto se queda fija (sticky top-28, por debajo del header) mientras sube la línea de tiempo; su alto se limita
 * a la pantalla para que nunca se corte en portátiles bajos. Sin efecto en móvil y tablet (foto arriba).
 * sticky necesita self-start (en una rejilla los hijos se estiran) y ningún contenedor con overflow hidden.
 * Etapas desde el campo "Etapas" (Años | Título | Texto), de la más reciente a la más antigua.
 * Idea para la fase final (CLAUDE.md): que la foto cambie con cada etapa.
 */
$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$etiqueta = $campo( 'sobre_trayectoria_etiqueta', __( '/ Trayectoria', 'baerchen' ) );
$titular  = $campo( 'sobre_trayectoria_titular', __( 'No llegué por un camino recto. Y eso es una ventaja.', 'baerchen' ) );
$parrafo  = $campo( 'sobre_trayectoria_parrafo', __( 'Empecé diseñando moda, crecí en la tecnología y hoy junto las dos cosas: diseño y código.', 'baerchen' ) );
$foto_id  = $campo( 'sobre_trayectoria_foto', 0 );
$etapas   = baerchen_lista( $campo( 'sobre_trayectoria_lista', __( "2025 — Hoy | Diseño UX/UI y desarrollo web | Máster en La Hauss, certificado IFCD0110 cum laude y freelance desde 2026.\n2012 — 2023 | Alemania | Once años en Colonia: administración industrial y soporte IT de 1er y 2º nivel.\n1994 — 2011 | Barcelona | Servicio técnico y dirección comercial en empresas de informática.\n1991 — 1994 | El origen | Diseño de moda en el Institut Català de la Moda.", 'baerchen' ) ), 3 );
?>
<section class="bg-bg" data-fondo="claro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-16 pb-24 md:pb-32">
    <div class="grid grid-cols-4 gap-x-4 gap-y-12 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">

      <!-- FOTO · columnas 1–4, fija en xl -->
      <div class="col-span-4 xl:sticky xl:top-28 xl:self-start">
        <?php if ( $foto_id ) :
          $alt = get_post_meta( $foto_id, '_wp_attachment_image_alt', true );
          echo wp_get_attachment_image( $foto_id, 'baerchen-retrato', false, array(
            'class' => 'w-full aspect-2/3 xl:max-h-[calc(100svh-9rem)] object-cover rounded-4xl',
            'sizes' => '(min-width: 1280px) 384px, (min-width: 768px) 50vw, 100vw',
            'alt'      => $alt ? $alt : __( 'Poste de señales de senderismo en la montaña nevada', 'baerchen' ),
            'loading'  => 'lazy',
            'decoding' => 'async',
          ) );
        else : ?>
          <div class="w-full aspect-2/3 rounded-4xl bg-ink/10" aria-hidden="true"></div>
        <?php endif; ?>
      </div>

      <!-- TEXTO + LÍNEA DE TIEMPO · columnas 6–12 -->
      <div class="col-span-4 md:col-span-8 xl:col-start-6 xl:col-span-7 flex flex-col gap-8">
        <p class="font-mono text-base md:text-lg uppercase leading-none"><?php echo esc_html( $etiqueta ); ?></p>
        <h2 class="text-titulo-seccion"><?php echo nl2br( esc_html( $titular ), false ); ?></h2>
        <p class="text-parrafo"><?php echo esc_html( $parrafo ); ?></p>

        <?php if ( $etapas ) : ?>
          <ol class="mt-4 border-b border-ink">
            <?php foreach ( $etapas as $i => list( $anios, $titulo, $texto ) ) : ?>
              <li class="grid grid-cols-[2.5rem_1fr] sm:grid-cols-[3rem_7.5rem_1fr] gap-x-5.5 gap-y-3 border-t border-ink py-6.5">
                <span class="font-mono font-medium text-sm uppercase leading-[1.4]" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
                <span class="font-mono font-medium text-sm uppercase leading-[1.4]"><?php echo esc_html( $anios ); ?></span>
                <div class="col-start-2 sm:col-start-3 flex flex-col gap-4.5">
                  <h3 class="font-bold text-2xl leading-tight"><?php echo esc_html( $titulo ); ?></h3>
                  <p class="text-parrafo"><?php echo esc_html( $texto ); ?></p>
                </div>
              </li>
            <?php endforeach; ?>
          </ol>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>
