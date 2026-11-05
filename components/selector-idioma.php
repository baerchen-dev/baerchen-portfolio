<?php
/**
 * SELECTOR DE IDIOMA · 🌐 ES / EN (bola del mundo: icono "idioma" de components/icono.php)
 * Figma: ficha "Selector de idioma" (02 — Components, sección Base).
 * Cada idioma enlaza a la traducción de la página actual; si la página aún no está traducida,
 * Polylang lleva a la portada de ese idioma. El actual va en el color del texto y sin enlace;
 * el otro, al 60 %. Sin color propio: hereda el del contenedor (crema sobre secciones oscuras).
 * Sin Polylang, o con un solo idioma con contenido publicado, no muestra nada.
 *
 * $args['clase'] Visibilidad y clases extra. Por defecto 'flex'. Incluir siempre el display
 *                 (p. ej. 'hidden md:flex'), como en boton-hablamos.php
 */
if ( ! function_exists( 'pll_the_languages' ) ) {
  return;
}

$idiomas = pll_the_languages( array(
  'raw'                    => 1,
  'hide_if_empty'          => 1,   // un idioma sin nada publicado no aparece (p. ej. mientras todo en inglés sea borrador)
  'hide_if_no_translation' => 0,
) );

if ( ! is_array( $idiomas ) || count( $idiomas ) < 2 ) {
  return;
}

$clase = $args['clase'] ?? 'flex';
$i     = 0;
?>
<nav class="<?php echo esc_attr( $clase ); ?> items-center gap-2" aria-label="<?php esc_attr_e( 'Idioma', 'baerchen' ); ?>">
  <?php get_template_part( 'components/icono', null, array( 'nombre' => 'idioma', 'clase' => 'size-[1em] shrink-0' ) ); // decorativa: el nav ya se llama "Idioma" ?>
  <ul class="flex items-center gap-2 font-mono font-medium text-base uppercase tracking-wider leading-none">
    <?php foreach ( $idiomas as $idioma ) :
      $lang = str_replace( '_', '-', $idioma['locale'] );
      ?>
      <?php if ( $i++ > 0 ) : ?>
        <li class="opacity-60" aria-hidden="true">/</li>
      <?php endif; ?>
      <li>
        <?php if ( $idioma['current_lang'] ) : ?>
          <span aria-current="true"><?php echo esc_html( $idioma['slug'] ); ?><span class="sr-only"> (<?php echo esc_html( $idioma['name'] ); ?>)</span></span>
        <?php else : ?>
          <a href="<?php echo esc_url( $idioma['url'] ); ?>" hreflang="<?php echo esc_attr( $lang ); ?>" lang="<?php echo esc_attr( $lang ); ?>" class="opacity-60 hover:opacity-100 cursor-pointer transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current"><?php echo esc_html( $idioma['slug'] ); ?><span class="sr-only"> (<?php echo esc_html( $idioma['name'] ); ?>)</span></a>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>
