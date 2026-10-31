<?php

/* MÓDULOS */
require_once get_template_directory() . '/inc/proyectos.php';   // tipo de contenido Proyecto, etiquetas y campos
require_once get_template_directory() . '/inc/compartir.php';   // imagen y textos al compartir un enlace (Open Graph)

/* SETUP */
function baerchen_setup() {
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
  register_nav_menus( array(
    'main-menu'     => __( 'Menú principal', 'baerchen' ),   // también es la columna NAVEGACIÓN del footer
    'footer-social' => __( 'Footer · Social', 'baerchen' ),
    'footer-legal'  => __( 'Footer · Legal', 'baerchen' ),
  ) );
}
add_action( 'after_setup_theme', 'baerchen_setup' );

/* TAMAÑOS DE IMAGEN

 */
function baerchen_tamanos_imagen() {
  add_image_size( 'baerchen-retrato', 976, 1448, true );   // foto del hero · 2:3 (Figma 488 × 724)
  add_image_size( 'baerchen-tarjeta', 1184, 1052, true );  // tarjeta de proyecto · 9:8 (Figma 592 × 527)
  add_image_size( 'baerchen-vertical', 976, 1308, true );  // foto de Sobre mí en la Home · 3:4 (Figma 488 × 654)
  add_image_size( 'baerchen-presentacion', 976, 1220, true ); // foto del hero de la página Sobre mí · 4:5 (Figma 488 × 610)
  add_image_size( 'baerchen-ancho', 2432, 0, false );      // imágenes grandes del caso de estudio (hasta 1216px)
  // Mitades (misma proporción): WordPress las añade al srcset y el móvil descarga la pequeña cuando le basta
  add_image_size( 'baerchen-retrato-mitad', 488, 724, true );
  add_image_size( 'baerchen-presentacion-mitad', 488, 610, true );
}
add_action( 'after_setup_theme', 'baerchen_tamanos_imagen' );

/* ACF · CAMPOS
 * Los grupos de campos están en acf-json/ (ACF los carga solo). Se editan desde ACF → Grupos de campos;
 * al guardar, ACF reescribe el .json correspondiente.
 */

/* LIMPIAR HEAD */
function baerchen_limpiar_cabecera() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  add_filter( 'emoji_svg_url', '__return_false' );
  add_filter( 'the_generator', '__return_false' );
  remove_action( 'wp_head', 'rsd_link' );
  remove_action( 'wp_head', 'wlwmanifest_link' );
}
add_action( 'after_setup_theme', 'baerchen_limpiar_cabecera' );

/* ESTILOS
 * assets/css/main.css se genera con Tailwind CLI (npm run dev / npm run build)
 */
function baerchen_enqueue_styles() {
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'classic-theme-styles' );
  wp_dequeue_style( 'global-styles' );

  // Fuentes: alojadas en el tema (assets/fonts/), declaradas con @font-face al principio de src/css/main.css
  $css = '/assets/css/main.css';
  wp_enqueue_style(
    'baerchen-main',
    get_template_directory_uri() . $css,
    array(),
    filemtime( get_template_directory() . $css )
  );

  // Número de letras del título: el logo grande de la Home calcula su tamaño con él (--text-logo)
  $letras = max( 1, mb_strlen( get_bloginfo( 'name' ) ) );
  wp_add_inline_style( 'baerchen-main', ':root{--logo-letras:' . (int) $letras . '}' );
}
add_action( 'wp_enqueue_scripts', 'baerchen_enqueue_styles', 20 );

/* SCRIPTS */
function baerchen_enqueue_scripts() {
  $js = '/assets/js/menu.js';
  wp_enqueue_script(
    'baerchen-menu',
    get_template_directory_uri() . $js,
    array(),
    filemtime( get_template_directory() . $js ),
    array( 'in_footer' => true, 'strategy' => 'defer' )
  );

  // Header y scroll: logo grande de la Home, header crema sobre fondos oscuros (también el footer) y efecto cortina
  $js_header = '/assets/js/header.js';
  wp_enqueue_script(
    'baerchen-header',
    get_template_directory_uri() . $js_header,
    array(),
    filemtime( get_template_directory() . $js_header ),
    array( 'in_footer' => true, 'strategy' => 'defer' )
  );
}
add_action( 'wp_enqueue_scripts', 'baerchen_enqueue_scripts' );

/* SCRIPTS · ANIMACIONES (ola de color y las que se añadan en la fase final) */
function baerchen_enqueue_animaciones() {
  $js = '/assets/js/animaciones.js';
  wp_enqueue_script(
    'baerchen-animaciones',
    get_template_directory_uri() . $js,
    array(),
    filemtime( get_template_directory() . $js ),
    array( 'in_footer' => true, 'strategy' => 'defer' )
  );
}
add_action( 'wp_enqueue_scripts', 'baerchen_enqueue_animaciones' );

/* SCRIPTS · CASO DE ESTUDIO (proceso sticky), solo en las páginas de proyecto */
function baerchen_enqueue_caso() {
  if ( ! is_singular( 'proyecto' ) ) return;
  $js = '/assets/js/caso-sticky.js';
  wp_enqueue_script(
    'baerchen-caso-sticky',
    get_template_directory_uri() . $js,
    array(),
    filemtime( get_template_directory() . $js ),
    array( 'in_footer' => true, 'strategy' => 'defer' )
  );
}
add_action( 'wp_enqueue_scripts', 'baerchen_enqueue_caso' );

/* CONTACT FORM 7
 * Sus archivos (CSS y JS) solo se cargan en la página Contacto, y sin los <p> y <br> que añade al formulario
 * (la maquetación la lleva el propio código del formulario: inc/formulario-contacto.html).
 */
add_filter( 'wpcf7_load_js',  fn() => is_page( 'contacto' ) );
add_filter( 'wpcf7_load_css', fn() => is_page( 'contacto' ) );
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/* CF7 encola Turnstile en todas las páginas y los filtros de arriba no le afectan. */
add_action( 'wp_enqueue_scripts', function () {
  if ( ! is_page( 'contacto' ) ) {
    wp_dequeue_script( 'cloudflare-turnstile' );
  }
}, 20 );

/* TEXTO · OLA DE COLOR (inspirada en wearedirect.co)
 * Parte el texto en letras para que una ola de color accent lo recorra al cargar y al pasar el ratón.
 * Uso: <h1><?php echo baerchen_ola( $titular ); ?></h1>  (ya escapa el texto)
 *      baerchen_ola( $texto, false ) → la ola empieza al entrar en pantalla (titulares que no se ven al cargar)
 * Los saltos de línea del texto (campos de varias líneas) se convierten en <br>.
 * Los lectores de pantalla leen el texto entero (sr-only); las letras sueltas van ocultas (aria-hidden).
 * Animación en src/css/main.css (.ola) · al entrar en pantalla y al pasar el ratón: assets/js/animaciones.js
 */
function baerchen_ola( $texto, $al_cargar = true ) {
  $letras = '';
  $texto  = str_replace( "\r", '', $texto );
  foreach ( mb_str_split( $texto ) as $i => $letra ) {
    if ( "\n" === $letra ) { $letras .= '<br>'; continue; }
    $letras .= ' ' === $letra ? ' ' : '<span style="--i:' . (int) $i . '">' . esc_html( $letra ) . '</span>';
  }
  $clases = $al_cargar ? 'ola ola-activa' : 'ola';
  return '<span class="sr-only">' . esc_html( $texto ) . '</span><span class="' . $clases . '" aria-hidden="true">' . $letras . '</span>';
}

/* TEXTO · LISTA DE UNA LÍNEA POR ELEMENTO (campos ACF de texto largo; ACF gratuito no tiene repetidores)
 * Cada línea se parte por "|": "Título | Texto" → array( 'Título', 'Texto' ). Se descartan las líneas vacías
 * y las que no tienen el número de partes pedido.
 * Uso: foreach ( baerchen_lista( $texto, 2 ) as list( $titulo, $parrafo ) ) { … }
 */
function baerchen_lista( $texto, $partes = 2 ) {
  $lista = array();
  foreach ( preg_split( '/\r\n|\r|\n/', (string) $texto ) as $linea ) {
    $trozos = array_map( 'trim', explode( '|', $linea, $partes ) );
    if ( count( $trozos ) === $partes && '' !== $trozos[0] ) $lista[] = $trozos;
  }
  return $lista;
}

/* MENÚS — CLASES EN LOS ENLACES
 * Permite pasar 'link_class' a wp_nav_menu() para dar clases de Tailwind a cada <a>
 */
function baerchen_nav_link_class( $atts, $item, $args ) {
  if ( ! empty( $args->link_class ) ) {
    $atts['class'] = $args->link_class;
  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'baerchen_nav_link_class', 10, 3 );

/* FAVICON (osito, assets/img/)
 * favicon.svg cambia de color solo: ink en modo claro, crema en modo oscuro (media query dentro del SVG).
 * apple-touch-icon.png: 180 × 180, fondo crema opaco (iOS no admite transparencia ni SVG).
 * Si algún día se pone un "Icono del sitio" en Ajustes → Generales, WordPress añadiría el suyo: dejarlo vacío.
 */
function baerchen_favicon() {
  $img = get_template_directory_uri() . '/assets/img/';
  echo '<link rel="icon" href="' . esc_url( $img . 'favicon.svg' ) . '" type="image/svg+xml">' . "\n";
  echo '<link rel="apple-touch-icon" href="' . esc_url( $img . 'apple-touch-icon.png' ) . '">' . "\n";
}
add_action( 'wp_head', 'baerchen_favicon' );

/* META DESCRIPCIÓN (el texto gris que enseña Google bajo el título)
 * Campo "Descripción para Google" (acf-json/group_baerchen_seo.json) en cada página y proyecto.
 * Si está vacío: proyecto → entradilla del caso o frase de la tarjeta · Home → párrafo del hero ·
 * Sobre mí → entradilla · resto → texto general. Se corta a 160 caracteres sin partir palabras.
 */
function baerchen_descripcion() {
  $texto = '';
  if ( function_exists( 'get_field' ) && is_singular() ) {
    $texto = get_field( 'seo_descripcion' );
    if ( ! $texto && is_singular( 'proyecto' ) ) $texto = get_field( 'caso_entradilla' ) ?: get_field( 'proyecto_frase' );
    if ( ! $texto && is_front_page() )           $texto = get_field( 'hero_parrafo' );
    if ( ! $texto && is_page( 'sobre-mi' ) )     $texto = get_field( 'sobre_entradilla' );
  }
  if ( ! $texto ) $texto = __( 'Portfolio de Francisco Estévez, diseñador UX/UI y desarrollador web: webs claras, rápidas y a medida, del diseño en Figma al desarrollo en WordPress.', 'baerchen' );
  $texto = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $texto ) ) );
  if ( mb_strlen( $texto ) > 160 ) $texto = rtrim( mb_substr( $texto, 0, mb_strrpos( mb_substr( $texto, 0, 157 ), ' ' ) ), ' ,.;:' ) . '…';
  return $texto;
}
function baerchen_meta_descripcion() {
  echo '<meta name="description" content="' . esc_attr( baerchen_descripcion() ) . '">' . "\n";
}
add_action( 'wp_head', 'baerchen_meta_descripcion', 1 );

/* PRECARGA DE LA FUENTE PRINCIPAL · el navegador la pide a la vez que el CSS, sin esperar a leerlo (titulares del hero) */
function baerchen_precargar_fuente() {
  echo '<link rel="preload" href="' . esc_url( get_template_directory_uri() . '/assets/fonts/plus-jakarta-sans-latin.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
}
add_action( 'wp_head', 'baerchen_precargar_fuente', 2 );
