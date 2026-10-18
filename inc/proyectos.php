<?php
/**
 * PROYECTOS
 * Tipo de contenido "Proyecto" y sus etiquetas (los campos ACF están en acf-json/).
 * Se carga desde functions.php.
 *
 * URLs: la página Trabajos sigue en /trabajos/ (page-trabajos.php)
 *       y cada proyecto (caso de estudio) en /trabajos/{proyecto}/
 * Tras cambiar el slug: Ajustes → Enlaces permanentes → Guardar cambios.
 */

/* TIPO DE CONTENIDO Y ETIQUETAS */
function baerchen_registrar_proyectos() {
  register_post_type( 'proyecto', array(
    'labels'        => array(
      'name'          => __( 'Proyectos', 'baerchen' ),
      'singular_name' => __( 'Proyecto', 'baerchen' ),
      'add_new_item'  => __( 'Añadir proyecto', 'baerchen' ),
      'edit_item'     => __( 'Editar proyecto', 'baerchen' ),
      'all_items'     => __( 'Todos los proyectos', 'baerchen' ),
    ),
    'public'        => true,
    'has_archive'   => false,                 // el listado es la página Trabajos
    'rewrite'       => array( 'slug' => 'trabajos', 'with_front' => false ),
    'menu_icon'     => 'dashicons-portfolio',
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),   // page-attributes = campo "Orden"
    'show_in_rest'  => true,
  ) );

  register_taxonomy( 'etiqueta_proyecto', 'proyecto', array(
    'labels'            => array(
      'name'          => __( 'Etiquetas de proyecto', 'baerchen' ),
      'singular_name' => __( 'Etiqueta', 'baerchen' ),
      'add_new_item'  => __( 'Añadir etiqueta', 'baerchen' ),
    ),
    'public'            => false,             // sin páginas propias (de momento)
    'show_ui'           => true,
    'show_in_rest'      => true,
    'show_admin_column' => true,
    'hierarchical'      => false,
  ) );
}
add_action( 'init', 'baerchen_registrar_proyectos' );

/* ACF · CAMPOS: "Proyecto · Datos", "Proyecto · Caso de estudio" y "Trabajos · Cabecera" están en acf-json/ */

/* NÚMERO DEL CASO DE ESTUDIO ("01", "02"…)
 * Posición del proyecto en el mismo orden que la Home y la página Trabajos (campo "Orden" y, si empatan, fecha).
 * Así no hay que escribirlo a mano y se recoloca solo al reordenar o al pasar un proyecto a borrador.
 */
function baerchen_proyecto_numero( $id = null ) {
  $id  = $id ? $id : get_the_ID();
  $ids = get_posts( array(
    'post_type'      => 'proyecto',
    'posts_per_page' => -1,
    'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
    'fields'         => 'ids',
  ) );
  $posicion = array_search( $id, $ids, true );
  return sprintf( '%02d', false === $posicion ? 1 : $posicion + 1 );
}

/* SIGUIENTE PROYECTO · el que va después en el mismo orden (tras el último, el primero). null si solo hay uno. */
function baerchen_proyecto_siguiente( $id = null ) {
  $id  = $id ? $id : get_the_ID();
  $ids = get_posts( array(
    'post_type'      => 'proyecto',
    'posts_per_page' => -1,
    'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
    'fields'         => 'ids',
  ) );
  if ( count( $ids ) < 2 ) return null;
  $posicion = array_search( $id, $ids, true );
  $posicion = false === $posicion ? -1 : $posicion;
  return get_post( $ids[ ( $posicion + 1 ) % count( $ids ) ] );
}

/* CONTRASTE ENTRE DOS COLORES (fórmula de WCAG 2.2) · para el tablero del sistema (sections/proyecto-sistema.php)
 * baerchen_contraste( '#F10C94', '#020618' ) → 5.01
 */
function baerchen_luminancia( $hex ) {
  $hex = ltrim( $hex, '#' );
  if ( 3 === strlen( $hex ) ) $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
  $canal = function ( $valor ) {
    $c = hexdec( $valor ) / 255;
    return $c <= 0.03928 ? $c / 12.92 : pow( ( $c + 0.055 ) / 1.055, 2.4 );
  };
  return 0.2126 * $canal( substr( $hex, 0, 2 ) ) + 0.7152 * $canal( substr( $hex, 2, 2 ) ) + 0.0722 * $canal( substr( $hex, 4, 2 ) );
}
function baerchen_contraste( $a, $b ) {
  $la = baerchen_luminancia( $a );
  $lb = baerchen_luminancia( $b );
  return ( max( $la, $lb ) + 0.05 ) / ( min( $la, $lb ) + 0.05 );
}

/* FUENTES DEL PROYECTO (Google Fonts) · solo en su caso de estudio, para que la muestra del sistema sea real.
 * Lee el campo "Fuentes" (Familia | Peso | Uso | Muestra) y carga cada familia en 400 y en el peso indicado.
 */
function baerchen_fuentes_caso() {
  if ( ! is_singular( 'proyecto' ) || ! function_exists( 'get_field' ) ) return;
  $familias = array();
  foreach ( baerchen_lista( get_field( 'caso_sistema_fuentes' ), 4 ) as list( $familia, $peso ) ) {
    $pesos = array_unique( array_filter( array( 400, (int) $peso ) ) );
    sort( $pesos );
    $familias[] = 'family=' . str_replace( ' ', '+', trim( $familia ) ) . ':wght@' . implode( ';', $pesos );
  }
  if ( ! $familias ) return;
  wp_enqueue_style( 'baerchen-fuentes-caso', 'https://fonts.googleapis.com/css2?' . implode( '&', $familias ) . '&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'baerchen_fuentes_caso' );

/* ¿TIENE CASO DE ESTUDIO? · si el proyecto tiene rellena la entradilla del caso.
 * Mientras no la tenga, la tarjeta sigue abriendo la web real (components/card-proyecto.php).
 */
function baerchen_proyecto_tiene_caso( $id = null ) {
  return function_exists( 'get_field' ) && (bool) get_field( 'caso_entradilla', $id ? $id : get_the_ID() );
}
