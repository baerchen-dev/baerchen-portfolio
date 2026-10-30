<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <?php wp_head(); ?>
</head>

<body <?php body_class( 'min-h-screen flex flex-col bg-bg text-ink font-sans antialiased' ); ?>>
<?php wp_body_open(); ?>

<a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-60 focus:bg-ink focus:text-bg focus:px-4 focus:py-2 focus:rounded">
  <?php esc_html_e( 'Saltar al contenido', 'baerchen' ); ?>
</a>

<?php
$es_home = is_front_page();
?>

<!-- ============================================================ HEADER ============================================================
 * Fixed (no sticky): el logo de la Home cambia de tamaño al hacer scroll y con sticky la página saltaría.
 * assets/js/header.js añade data-scrolled al bajar (logo de la Home) y data-oscuro sobre secciones oscuras (texto crema).
-->
<header class="site-header group/header fixed inset-x-0 top-0 z-50 pt-[env(safe-area-inset-top)] text-ink data-oscuro:text-bg transition-colors duration-300" <?php echo $es_home ? 'data-logo-grande' : ''; ?>>

  <!-- CRISTAL · también detrás de la hora del móvil (el padding del header deja sitio a la barra de estado).
       Escritorio: solo desenfoque, invisible sobre el fondo liso. Pantallas táctiles (también el móvil en horizontal, que
       supera md): con un velo del color de la sección, porque las fotos ensuciaban la banda y le quitaban contraste al logo.
       Se desvanece hacia abajo en lugar de terminar en un borde -->
  <div class="absolute inset-x-0 top-0 -bottom-6 -z-10 backdrop-blur-2xl mask-b-from-75% md:pointer-fine:mask-b-from-60% bg-bg/55 group-data-oscuro/header:bg-ink/85 md:pointer-fine:bg-transparent md:pointer-fine:group-data-oscuro/header:bg-transparent transition-colors duration-300" aria-hidden="true"></div>

  <!-- MENÚ PRINCIPAL · superficie a todo el ancho, por detrás de la fila del logo.
       Va después del cristal: con el mismo -z-10, se pinta encima y el cristal no lo desenfoca -->
  <?php get_template_part( 'components/menu-principal' ); ?>

  <div class="max-w-7xl mx-auto px-4 md:px-8 py-4 flex items-start justify-between gap-6">

    <!-- LOGO -->
    <div class="min-h-10 min-w-0 flex items-center">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="font-extrabold uppercase tracking-titulo leading-none whitespace-nowrap transition-[font-size] duration-500 ease-out focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current <?php echo $es_home ? 'text-logo group-data-scrolled/header:text-3xl' : 'text-3xl'; ?>">
        <?php bloginfo( 'name' ); ?>
      </a>

    </div>

    <!-- ACCIONES · HABLAMOS (escritorio) + botón de menú -->
    <div class="h-10 shrink-0 flex items-center gap-6">
      <?php get_template_part( 'components/boton-hablamos', null, array( 'clase' => 'hidden md:inline-flex' ) ); ?>

      <button type="button" class="menu-toggle group relative -mr-2 size-10 cursor-pointer focus-visible:outline-2 focus-visible:outline-current" aria-controls="menu-principal" aria-expanded="false" aria-label="<?php esc_attr_e( 'Abrir menú', 'baerchen' ); ?>" data-label-abrir="<?php esc_attr_e( 'Abrir menú', 'baerchen' ); ?>" data-label-cerrar="<?php esc_attr_e( 'Cerrar menú', 'baerchen' ); ?>">
        <!-- Dos líneas (larga arriba, corta abajo a la derecha) que se cruzan en ✕ al abrir; la corta crece para que la ✕ sea simétrica -->
        <span class="absolute right-1 top-4 h-[1.5px] w-7.5 bg-current transition-[top,rotate] duration-300 group-aria-expanded:top-4.75 group-aria-expanded:rotate-45" aria-hidden="true"></span>
        <span class="absolute right-1 top-5.5 h-[1.5px] w-4.75 bg-current transition-[top,rotate,width] duration-300 group-aria-expanded:top-4.75 group-aria-expanded:w-7.5 group-aria-expanded:-rotate-45" aria-hidden="true"></span>
      </button>
    </div>

  </div>
</header>

<!-- El padding superior deja sitio al header fixed (en la Home, al logo grande) -->
<main id="contenido" class="flex-1 <?php echo $es_home ? 'pt-[calc(var(--text-logo)+2rem+env(safe-area-inset-top))]' : 'pt-[calc(4.5rem+env(safe-area-inset-top))]'; ?>">
