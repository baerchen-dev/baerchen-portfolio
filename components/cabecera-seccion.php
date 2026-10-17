<?php
/**
 * CABECERA DE SECCIÓN · etiqueta en las columnas 1–4 + titular (h2, Título sección) en las 5–12
 * Móvil y tablet: etiqueta encima del titular. Sin color propio: hereda el del bloque (crema u oscuro).
 * Se usa en los bloques de la página Sobre mí.
 *
 * $args['etiqueta'] Texto mono (p. ej. "/ Cómo trabajo")
 * $args['titular']  Titular; los saltos de línea se respetan
 */
$etiqueta = $args['etiqueta'] ?? '';
$titular  = $args['titular'] ?? '';
?>
<div class="grid grid-cols-4 gap-x-4 gap-y-8 md:grid-cols-8 md:gap-x-6 xl:grid-cols-12 xl:gap-x-8">
  <p class="col-span-4 md:col-span-8 xl:col-span-4 font-mono text-base md:text-lg uppercase leading-none"><?php echo esc_html( $etiqueta ); ?></p>
  <h2 class="col-span-4 md:col-span-8 text-titulo-seccion"><?php echo nl2br( esc_html( $titular ), false ); ?></h2>
</div>
