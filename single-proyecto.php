<?php
/**
 * CASO DE ESTUDIO (Figma: página "Casos de estudio", marco "Caso de estudio — 01 · MQFF", nodo 344:93)
 * WordPress la usa automáticamente para cada proyecto (/trabajos/{proyecto}/).
 * Bloques: presentación (crema) → el encargo (crema) → cita (oscuro) → proceso sticky (crema) → sistema (crema)
 * → la entrega (imagen a todo el ancho) → alcance y aprendizajes (crema) → siguiente proyecto (oscuro) → cierre de la Home → footer.
 * Contenido desde los campos ACF "Proyecto · Caso de estudio" (acf-json/group_baerchen_caso.json).
 * Sin textos por defecto: la plantilla es para todos los proyectos, y cada bloque solo sale si tiene contenido.
 */
get_header();

while ( have_posts() ) : the_post(); ?>

  <?php get_template_part( 'sections/proyecto-hero' ); ?>
  <?php get_template_part( 'sections/proyecto-encargo' ); ?>
  <?php get_template_part( 'sections/proyecto-cita' ); ?>
  <?php get_template_part( 'sections/proyecto-proceso' ); ?>
  <?php get_template_part( 'sections/proyecto-sistema' ); ?>
  <?php get_template_part( 'sections/proyecto-entrega' ); ?>
  <?php get_template_part( 'sections/proyecto-alcance' ); ?>
  <?php get_template_part( 'sections/proyecto-siguiente' ); ?>
  <?php get_template_part( 'sections/home-cierre' ); ?>

<?php endwhile;

get_footer();
