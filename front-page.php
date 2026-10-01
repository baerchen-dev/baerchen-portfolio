<?php
/**
 * HOME
 * WordPress usa esta plantilla automáticamente para la página de inicio (Ajustes → Lectura).
 * Efecto cortina (md+): la sección que va a ser tapada lleva md:sticky + data-cortina (header.js calcula su top para
 * que se fije al terminar de verse); la siguiente, con fondo opaco y position relative, sube por encima. El footer, sin efecto.
 * Orden: hero (cortina) → trabajos (sube por encima) → sobre mí (se abre sola desde la foto, data-crecer).
 */
get_header(); ?>

<?php get_template_part( 'sections/home-hero' ); ?>
<?php get_template_part( 'sections/home-trabajos' ); ?>
<?php get_template_part( 'sections/home-sobre-mi' ); ?>

<?php get_footer(); ?>
