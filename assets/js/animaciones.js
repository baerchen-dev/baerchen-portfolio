/* ANIMACIONES
 * Ola de color (.ola, generada con baerchen_ola() en PHP):
 * - con .ola-activa desde el HTML se reproduce al cargar (solo CSS)
 * - sin ella, empieza al entrar en pantalla (IntersectionObserver)
 * - se repite al pasar el ratón por encima del texto
 */
const olas = document.querySelectorAll( '.ola' );
const sinMovimiento = window.matchMedia( '(prefers-reduced-motion: reduce)' );

function reproducirOla( ola ) {
  // Reiniciar la animación: quitar la clase, forzar un repintado y volver a ponerla
  ola.classList.remove( 'ola-activa' );
  void ola.offsetWidth;
  ola.classList.add( 'ola-activa' );
}

// Al entrar en pantalla (una sola vez)
const alVerse = new IntersectionObserver( ( entradas ) => {
  entradas.forEach( ( entrada ) => {
    if ( entrada.isIntersecting ) {
      entrada.target.classList.add( 'ola-activa' );
      alVerse.unobserve( entrada.target );
    }
  } );
}, { threshold: 0.6 } );

olas.forEach( ( ola ) => {
  if ( ! ola.classList.contains( 'ola-activa' ) ) alVerse.observe( ola );

  ola.addEventListener( 'mouseenter', () => {
    if ( ! sinMovimiento.matches ) reproducirOla( ola );
  } );
} );
