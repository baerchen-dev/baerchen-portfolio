<?php
/**
 * CINTA (marquesina) · texto grande y tenue desplazándose despacio, a todo el ancho de la pantalla
 * $args['texto'] Frase que se repite (p. ej. "Diseño UX/UI · Desarrollo WordPress · Mejora de webs")
 * Dos copias iguales + desplazamiento de -50% → bucle continuo (animate-cinta en src/css/main.css).
 * text-cinta (src/css/main.css) lleva interlineado 1.2: con 1, el overflow-hidden cortaría las tildes de las mayúsculas (Ñ, Í).
 * Se para al pasar el ratón; quieta con "reducir movimiento". Decorativa: oculta para lectores de pantalla.
 */
$texto = $args['texto'] ?? '';
if ( '' === trim( $texto ) ) return;
?>
<div class="overflow-hidden select-none" aria-hidden="true">
  <div class="flex w-max animate-cinta hover:[animation-play-state:paused] motion-reduce:animate-none">
    <?php for ( $i = 0; $i < 2; $i++ ) : ?>
      <p class="shrink-0 whitespace-nowrap pr-[0.4em] text-cinta uppercase text-ink/10"><?php echo esc_html( $texto ); ?> ·</p>
    <?php endfor; ?>
  </div>
</div>
