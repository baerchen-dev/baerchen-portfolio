<?php
/**
 * HOME · CIERRE (Figma: nodo 167:1336) · justo antes del footer, también oscuro
 * Disponibilidad → titular (ola de color) → 2 botones (formulario de Contacto · email) → línea para empleo (LinkedIn).
 * Contenido desde los campos ACF "Home · Cierre" (Páginas → Inicio); el email es el del campo "Email" de la página Contacto.
 * Botones: 80px de alto en móvil / 120px en xl, texto 24 → 40px (text-boton). Hover terracota: desde 24px cuenta como texto grande (3,9:1 ≥ 3:1).
 */
$campo = function ( $nombre, $defecto ) {
  $valor = function_exists( 'get_field' ) ? get_field( $nombre ) : '';
  return $valor ? $valor : $defecto;
};

$disponible       = function_exists( 'get_field' ) ? get_field( 'cierre_disponible' ) : true;
$disponible       = null === $disponible ? true : (bool) $disponible;   // sin guardar aún → visible
$texto_disponible = $campo( 'cierre_disponible_texto', __( 'Disponible para proyectos', 'baerchen' ) );
$titular          = $campo( 'cierre_titular', __( '¿Tienes un proyecto en mente?', 'baerchen' ) );
$boton_formulario = $campo( 'cierre_boton_formulario', __( 'Ir al formulario', 'baerchen' ) );
$boton_email      = $campo( 'cierre_boton_email', __( 'Envíame un email', 'baerchen' ) );
$texto_empleo     = $campo( 'cierre_empleo', __( '¿Buscas a alguien para tu equipo?', 'baerchen' ) );
$url_linkedin     = $campo( 'cierre_linkedin', 'https://www.linkedin.com/in/francisco-estevez-a48a69185/' );

// Formulario y email: los de la página Contacto
$contacto       = get_page_by_path( 'contacto' );
$url_formulario = ( $contacto ? get_permalink( $contacto ) : home_url( '/contacto/' ) ) . '#formulario';
$email          = ( $contacto && function_exists( 'get_field' ) ) ? get_field( 'contacto_email', $contacto->ID ) : '';
$email          = $email ? $email : 'info@baerchen.dev';

$boton = 'group flex h-20 xl:h-30 items-center justify-center gap-4 rounded-xl px-6 font-mono text-boton uppercase cursor-pointer transition-colors duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-bg';
?>
<section class="relative bg-ink text-bg" data-fondo="oscuro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 pt-24 md:pt-40 pb-24 md:pb-40">
    <div class="grid grid-cols-4 gap-x-4 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">

      <!-- DISPONIBILIDAD + TITULAR · columnas 1–9 -->
      <div class="col-span-4 md:col-span-8 xl:col-span-9 flex flex-col gap-8">
        <?php if ( $disponible && $texto_disponible ) : ?>
          <p class="flex items-center gap-3 font-mono text-base md:text-lg uppercase leading-none">
            <span class="size-3 shrink-0 rounded-full bg-bg" aria-hidden="true"></span><?php echo esc_html( $texto_disponible ); ?>
          </p>
        <?php endif; ?>
        <h2 class="text-titulo-pagina"><?php echo baerchen_ola( $titular, false ); // ola al entrar en pantalla ?></h2>
      </div>

      <!-- BOTONES · 6 + 6 columnas (en móvil y tablet, uno debajo de otro) -->
      <div class="col-span-4 md:col-span-8 xl:col-span-12 mt-16 md:mt-22 grid grid-cols-1 gap-4 xl:grid-cols-2 xl:gap-8">
        <a href="<?php echo esc_url( $url_formulario ); ?>" class="<?php echo esc_attr( $boton ); ?> bg-bg text-ink hover:bg-accent hover:text-bg">
          <?php echo esc_html( $boton_formulario ); ?>
          <?php get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-derecha', 'clase' => 'size-[1em] shrink-0', 'mover' => 'derecha' ) ); ?>
        </a>
        <a href="mailto:<?php echo antispambot( sanitize_email( $email ) ); ?>" class="<?php echo esc_attr( $boton ); ?> border border-bg/50 hover:border-accent hover:bg-accent">
          <?php echo esc_html( $boton_email ); ?>
          <?php get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-diagonal', 'clase' => 'size-[1em] shrink-0', 'mover' => 'diagonal' ) ); ?>
        </a>
      </div>

      <!-- EMPLEO (secundario) -->
      <?php if ( $texto_empleo && $url_linkedin ) : ?>
        <p class="col-span-4 md:col-span-8 xl:col-span-12 mt-12 md:mt-16 flex flex-wrap items-center gap-x-8 gap-y-2 text-base font-medium">
          <span class="uppercase text-bg/60"><?php echo esc_html( $texto_empleo ); ?></span>
          <a href="<?php echo esc_url( $url_linkedin ); ?>" target="_blank" rel="noopener" class="group inline-flex items-center gap-1 underline underline-offset-4 cursor-pointer hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-bg">
            LinkedIn
            <?php get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-diagonal', 'clase' => 'size-4', 'mover' => 'diagonal' ) ); ?>
            <span class="sr-only"><?php esc_html_e( '(se abre en una pestaña nueva)', 'baerchen' ); ?></span>
          </a>
        </p>
      <?php endif; ?>

    </div>
  </div>

  <!-- Línea fina: separa el cierre del footer (los dos son oscuros) -->
  <div class="max-w-7xl mx-auto px-4 md:px-8"><hr class="border-0 border-t border-bg/10"></div>
</section>
