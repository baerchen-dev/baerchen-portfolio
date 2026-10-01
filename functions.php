<?php

/* MÓDULOS */
require_once get_template_directory() . '/inc/proyectos.php';   // tipo de contenido Proyecto, etiquetas y campos

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
  add_image_size( 'baerchen-ancho', 2432, 0, false );      // imágenes grandes del caso de estudio (hasta 1216px)
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

  wp_enqueue_style(
    'baerchen-fonts',
    'https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400..700&family=Plus+Jakarta+Sans:wght@400..800&display=swap',
    array(),
    null
  );

  $css = '/assets/css/main.css';
  wp_enqueue_style(
    'baerchen-main',
    get_template_directory_uri() . $css,
    array( 'baerchen-fonts' ),
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

/* TEXTO · OLA DE COLOR (inspirada en wearedirect.co)
 * Parte el texto en letras para que una ola de color accent lo recorra al cargar y al pasar el ratón.
 * Uso: <h1><?php echo baerchen_ola( $titular ); ?></h1>  (ya escapa el texto)
 *      baerchen_ola( $texto, false ) → la ola empieza al entrar en pantalla (titulares que no se ven al cargar)
 * Los lectores de pantalla leen el texto entero (sr-only); las letras sueltas van ocultas (aria-hidden).
 * Animación en src/css/main.css (.ola) · al entrar en pantalla y al pasar el ratón: assets/js/animaciones.js
 */
function baerchen_ola( $texto, $al_cargar = true ) {
  $letras = '';
  foreach ( mb_str_split( $texto ) as $i => $letra ) {
    $letras .= ' ' === $letra ? ' ' : '<span style="--i:' . (int) $i . '">' . esc_html( $letra ) . '</span>';
  }
  $clases = $al_cargar ? 'ola ola-activa' : 'ola';
  return '<span class="sr-only">' . esc_html( $texto ) . '</span><span class="' . $clases . '" aria-hidden="true">' . $letras . '</span>';
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

/* PRECONNECT A GOOGLE FONTS */
function baerchen_resource_hints( $urls, $relation_type ) {
  if ( 'preconnect' === $relation_type ) {
    $urls[] = 'https://fonts.googleapis.com';
    $urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
  }
  return $urls;
}
add_filter( 'wp_resource_hints', 'baerchen_resource_hints', 10, 2 );
