<?php
/**
 * ICONO SVG (en línea: toma el color del texto con currentColor)
 * Uso: get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-derecha', 'clase' => 'size-5' ) );
 * $args['trazo'] Grosor del trazo en unidades de la caja de 24 (por defecto 1.5; 2 en iconos grandes junto a texto Medium)
 * Nombres: flecha-derecha (→), flecha-abajo (↓), flecha-diagonal (↗), desplegable (⌄)
 * Decorativo (aria-hidden): el texto del enlace o del botón ya dice qué hace.
 */
$trazos = array(
  'flecha-derecha'  => 'M5 12h14M13 6l6 6-6 6',
  'flecha-abajo'    => 'M12 5v14M6 13l6 6 6-6',
  'flecha-diagonal' => 'M7 17L17 7M8 7h9v9',
  'desplegable'     => 'M6 9l6 6 6-6',
);
$nombre = $args['nombre'] ?? 'flecha-derecha';
$clase  = $args['clase'] ?? 'size-5';
$trazo  = $args['trazo'] ?? 1.5;
if ( ! isset( $trazos[ $nombre ] ) ) return;
?>
<svg class="<?php echo esc_attr( $clase ); ?>" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="<?php echo esc_attr( $trazo ); ?>" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="<?php echo esc_attr( $trazos[ $nombre ] ); ?>"/></svg>
