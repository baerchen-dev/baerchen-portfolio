<?php
/**
 * TARJETA DE SERVICIO (página Contacto)
 * $args['titulo'] · $args['frase'] (opcional) · $args['lista'] (texto, un punto por línea)
 */
$titulo = $args['titulo'] ?? '';
$frase  = $args['frase'] ?? '';
$lista  = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $args['lista'] ?? '' ) ) );
if ( '' === $titulo ) return;
?>
<article class="h-full rounded-xl bg-white/50 p-6 flex flex-col gap-8">
  <div class="flex flex-col gap-3">
    <h3 class="font-medium text-2xl leading-tight"><?php echo esc_html( $titulo ); ?></h3>
    <?php if ( $frase ) : ?><p class="text-base text-ink/60"><?php echo esc_html( $frase ); ?></p><?php endif; ?>
  </div>

  <?php if ( $lista ) : ?>
    <div class="flex flex-col gap-3">
      <p class="font-medium text-sm uppercase leading-none"><?php esc_html_e( 'Qué incluye', 'baerchen' ); ?></p>
      <ul class="font-mono font-medium text-sm uppercase leading-snug">
        <?php foreach ( $lista as $punto ) : ?><li><?php echo esc_html( $punto ); ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
</article>
