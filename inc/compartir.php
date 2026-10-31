<?php
/**
 * COMPARTIR · Open Graph (WhatsApp, Telegram, LinkedIn…)
 * Imagen: en los casos de estudio, su imagen destacada recortada a 1200 × 630 (JPG en uploads/baerchen-compartir/, se hace
 * la primera vez que hace falta y al guardar el proyecto); en el resto, assets/img/compartir.jpg (Figma: Recursos · Casos de estudio).
 * Descripción: la misma que ve Google (baerchen_descripcion(), en functions.php).
 */

define( 'BAERCHEN_COMPARTIR_ANCHO', 1200 );
define( 'BAERCHEN_COMPARTIR_ALTO', 630 );

/* Imagen de un proyecto para compartir → array( 'url', 'ancho', 'alto' ) o null (sin imagen destacada).
 * Medidas reales: WordPress no amplía, así que una original más pequeña queda por debajo de 1200 × 630. */
function baerchen_proyecto_imagen_compartir( $post = null ) {
  $post    = get_post( $post );
  $adjunto = get_post_thumbnail_id( $post );
  $origen  = $adjunto ? get_attached_file( $adjunto ) : '';
  if ( ! $origen || ! file_exists( $origen ) ) return null;

  $subidas = wp_upload_dir();
  $nombre  = sprintf( '%d-%d-%d.jpg', $post->ID, $adjunto, filemtime( $origen ) );   // cambia la imagen → archivo nuevo
  $carpeta = trailingslashit( $subidas['basedir'] ) . 'baerchen-compartir/';
  $archivo = $carpeta . $nombre;

  if ( ! file_exists( $archivo ) ) {
    wp_mkdir_p( $carpeta );
    foreach ( glob( $carpeta . $post->ID . '-*.jpg' ) ?: array() as $viejo ) wp_delete_file( $viejo );
    $editor = wp_get_image_editor( $origen );
    if ( is_wp_error( $editor ) ) return null;
    $editor->resize( BAERCHEN_COMPARTIR_ANCHO, BAERCHEN_COMPARTIR_ALTO, true );   // recorte centrado
    $editor->set_quality( 80 );
    // En JPG, aunque la original sea WebP: lo entienden todas las apps al previsualizar enlaces
    if ( is_wp_error( $editor->save( $archivo, 'image/jpeg' ) ) ) return null;
  }

  $medidas = wp_getimagesize( $archivo );
  return array(
    'url'   => trailingslashit( $subidas['baseurl'] ) . 'baerchen-compartir/' . $nombre,
    'ancho' => $medidas ? $medidas[0] : BAERCHEN_COMPARTIR_ANCHO,
    'alto'  => $medidas ? $medidas[1] : BAERCHEN_COMPARTIR_ALTO,
  );
}

/* Al guardar un proyecto, su imagen queda hecha (así la primera visita de WhatsApp no espera) */
function baerchen_proyecto_guardar_compartir( $post_id ) {
  if ( 'proyecto' === get_post_type( $post_id ) && 'publish' === get_post_status( $post_id ) ) baerchen_proyecto_imagen_compartir( $post_id );
}
add_action( 'acf/save_post', 'baerchen_proyecto_guardar_compartir', 20 );

/* Etiquetas en el <head> */
function baerchen_compartir_etiquetas() {
  $marca  = get_bloginfo( 'name' );
  $titulo = $marca . ' · ' . __( 'Diseño UX y desarrollo web', 'baerchen' );
  $imagen = array(
    'url'   => get_template_directory_uri() . '/assets/img/compartir.jpg',
    'ancho' => BAERCHEN_COMPARTIR_ANCHO,
    'alto'  => BAERCHEN_COMPARTIR_ALTO,
  );
  $tipo   = 'website';
  $url    = home_url( '/' );

  if ( is_singular( 'proyecto' ) ) {
    $titulo = get_the_title() . ' · ' . __( 'Caso de estudio', 'baerchen' );
    $imagen = baerchen_proyecto_imagen_compartir() ?: $imagen;
    $tipo   = 'article';
    $url    = get_permalink();
  } elseif ( is_singular() && ! is_front_page() ) {
    $titulo = get_the_title() . ' · ' . $marca;
    $url    = get_permalink();
  }

  $etiquetas = array(
    'og:site_name'    => $marca,
    'og:locale'       => 'es_ES',
    'og:type'         => $tipo,
    'og:title'        => $titulo,
    'og:description'  => baerchen_descripcion(),
    'og:url'          => $url,
    'og:image'        => $imagen['url'],
    'og:image:width'  => $imagen['ancho'],
    'og:image:height' => $imagen['alto'],
    'og:image:alt'    => $titulo,
    'twitter:card'    => 'summary_large_image',
  );
  foreach ( $etiquetas as $nombre => $valor ) {
    $atributo = str_starts_with( $nombre, 'twitter:' ) ? 'name' : 'property';
    printf( '<meta %s="%s" content="%s">' . "\n", $atributo, esc_attr( $nombre ), esc_attr( $valor ) );
  }
}
add_action( 'wp_head', 'baerchen_compartir_etiquetas', 5 );
