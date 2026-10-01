<?php
/**
 * TARJETA DE PROYECTO (Figma: Trabajos, nodo 75:514 · sección oscura, nodo 78:606)
 * Usar dentro de un loop de proyectos. Toda la tarjeta es un enlace.
 * PROVISIONAL (hasta diseñar los casos de estudio): si el proyecto tiene "URL de la web", abre esa web
 * en una pestaña nueva (↗ junto al nombre); si no, va al caso de estudio (/trabajos/{slug}/).
 * Imagen 9:8 (tamaño baerchen-tarjeta) · nombre Bold + frase al 60 % · etiquetas en Geist Mono con borde
 * Logo del proyecto encima de la foto, abajo a la izquierda: assets/img/proyectos/{slug}.svg (si existe)
 * Hover: la foto se acerca un 4 % dentro de su marco; el logo se queda quieto.
 *
 * $args['tema']  'claro' (por defecto) u 'oscuro' → colores del texto y de las etiquetas
 * $args['sizes'] Atributo sizes de la imagen (según el ancho que ocupe la tarjeta)
 */
$frase     = function_exists( 'get_field' ) ? get_field( 'proyecto_frase' ) : '';
$estado    = function_exists( 'get_field' ) ? get_field( 'proyecto_estado' ) : '';
$etiquetas = get_the_terms( get_the_ID(), 'etiqueta_proyecto' );
$sizes     = $args['sizes'] ?? '(min-width: 1280px) 592px, (min-width: 768px) 50vw, 100vw';
$oscuro    = ( $args['tema'] ?? 'claro' ) === 'oscuro';
$url_web   = function_exists( 'get_field' ) ? get_field( 'proyecto_url' ) : '';
$destino   = $url_web ? $url_web : get_permalink();

// Colores según el fondo (contraste AA comprobado: ink/60 sobre crema 4,7:1 · bg/60 sobre ink 6,7:1)
$c_nombre    = $oscuro ? 'text-bg' : 'text-ink';
$c_frase     = $oscuro ? 'text-bg/60' : 'text-ink/60';
$c_etiqueta  = $oscuro ? 'border-bg/50 text-bg' : 'border-ink/30 text-ink';
$c_desarrollo = $oscuro ? 'border-bg bg-bg text-ink' : 'border-ink bg-ink text-bg';

// Logo: SVG del tema con el mismo nombre que el slug del proyecto
$logo_ruta = '/assets/img/proyectos/' . get_post_field( 'post_name' ) . '.svg';
$logo_url  = file_exists( get_template_directory() . $logo_ruta ) ? get_template_directory_uri() . $logo_ruta : '';
?>
<a href="<?php echo esc_url( $destino ); ?>"<?php if ( $url_web ) : ?> target="_blank" rel="noopener"<?php endif; ?> class="group block cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current">

  <!-- IMAGEN + LOGO · alt vacíos: el nombre del proyecto ya está en el texto del enlace -->
  <div class="relative overflow-hidden rounded-4xl">
    <?php if ( has_post_thumbnail() ) :
      the_post_thumbnail( 'baerchen-tarjeta', array(
        'class' => 'w-full aspect-9/8 object-cover transition-transform duration-500 ease-out group-hover:scale-104 motion-reduce:transition-none',
        'sizes' => $sizes,
        'alt'   => '',
      ) );
    else : ?>
      <div class="w-full aspect-9/8 <?php echo $oscuro ? 'bg-bg/10' : 'bg-ink/10'; ?>" aria-hidden="true"></div>
    <?php endif; ?>

    <?php if ( $logo_url ) : ?>
      <img src="<?php echo esc_url( $logo_url ); ?>" alt="" class="absolute left-[6%] bottom-[7%] w-[35%] h-auto pointer-events-none" loading="lazy" decoding="async">
    <?php endif; ?>
  </div>

  <!-- TEXTO -->
  <div class="mt-4 flex flex-col gap-4">
    <p class="text-lg leading-snug">
      <span class="font-bold <?php echo esc_attr( $c_nombre ); ?>"><?php the_title(); ?><?php if ( $url_web ) : ?> <span aria-hidden="true">↗</span><span class="sr-only"><?php esc_html_e( '(se abre en una pestaña nueva)', 'baerchen' ); ?></span><?php endif; ?></span>
      <?php if ( $frase ) : ?><span class="<?php echo esc_attr( $c_frase ); ?>"><?php echo esc_html( $frase ); ?></span><?php endif; ?>
    </p>

    <?php if ( ( $etiquetas && ! is_wp_error( $etiquetas ) ) || 'desarrollo' === $estado ) : ?>
      <ul class="flex flex-wrap gap-2.5" aria-label="<?php esc_attr_e( 'Etiquetas', 'baerchen' ); ?>">
        <?php if ( 'desarrollo' === $estado ) : ?>
          <li class="font-mono font-bold text-sm uppercase leading-none p-2 rounded border <?php echo esc_attr( $c_desarrollo ); ?>"><?php esc_html_e( 'En desarrollo', 'baerchen' ); ?></li>
        <?php endif; ?>
        <?php if ( $etiquetas && ! is_wp_error( $etiquetas ) ) : foreach ( $etiquetas as $etiqueta ) : ?>
          <li class="font-mono font-bold text-sm uppercase leading-none p-2 rounded border <?php echo esc_attr( $c_etiqueta ); ?>"><?php echo esc_html( $etiqueta->name ); ?></li>
        <?php endforeach; endif; ?>
      </ul>
    <?php endif; ?>
  </div>

</a>
