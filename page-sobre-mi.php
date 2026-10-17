<?php
/**
 * PÁGINA SOBRE MÍ (Figma: marco "Sobre mí", nodo 234:2189)
 * WordPress la usa automáticamente para la página con slug "sobre-mi".
 * Bloques: presentación (crema) → cómo trabajo (oscuro) → por qué yo (crema) → trayectoria (crema, foto fija)
 * → fuera de la pantalla (oscuro) → stack (crema) → cierre de la Home (oscuro) → footer.
 * Contenido desde los campos ACF "Sobre mí (página)" (acf-json/group_baerchen_sobremi_pagina.json);
 * si están vacíos, textos del diseño.
 */
get_header(); ?>

<?php get_template_part( 'sections/sobremi-hero' ); ?>
<?php get_template_part( 'sections/sobremi-proceso' ); ?>
<?php get_template_part( 'sections/sobremi-razones' ); ?>
<?php get_template_part( 'sections/sobremi-trayectoria' ); ?>
<?php get_template_part( 'sections/sobremi-aficiones' ); ?>
<?php get_template_part( 'sections/sobremi-stack' ); ?>
<?php get_template_part( 'sections/home-cierre' ); ?>

<?php get_footer(); ?>
