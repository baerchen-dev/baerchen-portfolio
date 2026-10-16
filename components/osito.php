<?php
/**
 * OSITO (logo de Baerchen) · SVG en línea para que tome el color del texto (currentColor)
 * Dibujo en assets/img/osito.svg (Figma: componente "Osito", 290 × 293, recortado al dibujo).
 * Decorativo (aria-hidden): siempre va junto al nombre BAERCHEN.
 *
 * $args['clase'] Tamaño y colocación (p. ej. 'w-20 lg:w-27 h-auto')
 */
$clase = $args['clase'] ?? 'w-20 h-auto';
$svg   = file_get_contents( get_template_directory() . '/assets/img/osito.svg' );
if ( ! $svg ) return;

echo str_replace( '<svg ', '<svg class="' . esc_attr( $clase ) . '" aria-hidden="true" focusable="false" ', $svg );
