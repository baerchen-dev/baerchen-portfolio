<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
<header class="site-header group/header fixed inset-x-0 top-0 z-50 text-ink data-oscuro:text-bg transition-colors duration-300" <?php echo $es_home ? 'data-logo-grande' : ''; ?>>

  <!-- CRISTAL · solo desenfoque, sin color: invisible sobre el fondo liso, se nota cuando pasa contenido por debajo.
       Se desvanece hacia abajo en lugar de terminar en un borde -->
  <div class="absolute inset-x-0 top-0 -bottom-6 -z-10 backdrop-blur-2xl mask-b-from-60%" aria-hidden="true"></div>

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
        <!-- Dos líneas que se cruzan en ✕ al abrir -->
        <span class="absolute left-2 top-3.5 h-0.5 w-6 bg-current transition-[top,rotate] duration-300 group-aria-expanded:top-4.75 group-aria-expanded:rotate-45" aria-hidden="true"></span>
        <span class="absolute left-2 top-6 h-0.5 w-6 bg-current transition-[top,rotate] duration-300 group-aria-expanded:top-4.75 group-aria-expanded:-rotate-45" aria-hidden="true"></span>
      </button>
    </div>

  </div>
</header>

<!-- El padding superior deja sitio al header fixed (en la Home, al logo grande) -->
<main id="contenido" class="flex-1 <?php echo $es_home ? 'pt-[calc(var(--text-logo)+2rem)]' : 'pt-18'; ?>">
