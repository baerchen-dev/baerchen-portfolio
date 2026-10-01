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

/* ACF · CAMPOS: "Proyecto · Datos" y "Trabajos · Cabecera" están en acf-json/ */
