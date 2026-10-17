<?php
/**
 * ICONO SVG (en línea: toma el color del texto con currentColor)
 * Uso: get_template_part( 'components/icono', null, array( 'nombre' => 'flecha-derecha', 'clase' => 'size-5' ) );
 * $args['trazo'] Grosor del trazo en unidades de la caja de 24 (por defecto 2.25)
 * $args['mover'] 'derecha' o 'diagonal': la flecha se desplaza unos píxeles en su dirección al pasar el ratón por el
 *                enlace o botón que la contiene (ese elemento necesita la clase "group"). Quieta con "reducir movimiento".
 * Familia (2026-10-17, Figma "Iconos · flecha", variante C): trazo 2,25 y flechas que ocupan casi toda la caja,
 * para que tengan el mismo peso que el texto. Si se cambia aquí, cambiar también los dos SVG de inc/formulario-contacto.html.
 * Nombres: flecha-derecha (→), flecha-abajo (↓), flecha-diagonal (↗), desplegable (⌄)
 * Decorativo (aria-hidden): el texto del enlace o del botón ya dice qué hace.
 */
$trazos = array(
  'flecha-derecha'  => 'M4 12h16M13 5l7 7-7 7',
  'flecha-abajo'    => 'M12 4v16M5 13l7 7 7-7',
  'flecha-diagonal' => 'M5 19L18 6M7 6h11v11',
  'desplegable'     => 'M5 9l7 7 7-7',
);
$nombre = $args['nombre'] ?? 'flecha-derecha';
$clase  = $args['clase'] ?? 'size-5';
$trazo  = $args['trazo'] ?? 2.25;
$mover  = array(
  'derecha'  => 'transition-transform duration-300 ease-out motion-reduce:transition-none group-hover:translate-x-1',
  'diagonal' => 'transition-transform duration-300 ease-out motion-reduce:transition-none group-hover:translate-x-0.5 group-hover:-translate-y-0.5',
);
if ( isset( $args['mover'], $mover[ $args['mover'] ] ) ) $clase .= ' ' . $mover[ $args['mover'] ];
if ( ! isset( $trazos[ $nombre ] ) ) return;
?>
<svg class="<?php echo esc_attr( $clase ); ?>" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="<?php echo esc_attr( $trazo ); ?>" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="<?php echo esc_attr( $trazos[ $nombre ] ); ?>"/></svg>
