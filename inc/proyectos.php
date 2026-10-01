<?php
/**
 * PROYECTOS
 * Tipo de contenido "Proyecto", sus etiquetas y sus campos ACF.
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

/* ACF · CAMPOS */
function baerchen_campos_proyectos() {
  if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

  // Datos de cada proyecto
  acf_add_local_field_group( array(
    'key'      => 'group_baerchen_proyecto',
    'title'    => 'Proyecto · Datos',
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'proyecto' ) ) ),
    'position' => 'acf_after_title',
    'fields'   => array(
      array( 'key' => 'field_proyecto_frase',  'name' => 'proyecto_frase',  'label' => 'Frase',  'type' => 'text', 'maxlength' => 60, 'instructions' => 'Corta (3–6 palabras). Sale en gris junto al nombre en la tarjeta.' ),
      array( 'key' => 'field_proyecto_url',    'name' => 'proyecto_url',    'label' => 'URL de la web', 'type' => 'url' ),
      array( 'key' => 'field_proyecto_estado', 'name' => 'proyecto_estado', 'label' => 'Estado', 'type' => 'select', 'choices' => array( 'terminado' => 'Terminado', 'desarrollo' => 'En desarrollo' ), 'default_value' => 'terminado', 'instructions' => '"En desarrollo" añade la etiqueta EN DESARROLLO a la tarjeta.' ),
      array( 'key' => 'field_proyecto_anio',   'name' => 'proyecto_anio',   'label' => 'Año', 'type' => 'number' ),
      array( 'key' => 'field_proyecto_rol',    'name' => 'proyecto_rol',    'label' => 'Rol', 'type' => 'text', 'placeholder' => 'Diseño UX/UI y desarrollo' ),
    ),
  ) );

  // Título de la página Trabajos
  $trabajos = get_page_by_path( 'trabajos' );
  if ( $trabajos ) {
    acf_add_local_field_group( array(
      'key'      => 'group_baerchen_trabajos',
      'title'    => 'Trabajos · Cabecera',
      'location' => array( array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) $trabajos->ID ) ) ),
      'position' => 'acf_after_title',
      'fields'   => array(
        array( 'key' => 'field_trabajos_titular', 'name' => 'trabajos_titular', 'label' => 'Titular', 'type' => 'text', 'placeholder' => 'Creando proyectos' ),
      ),
    ) );
  }
}
add_action( 'acf/init', 'baerchen_campos_proyectos' );
