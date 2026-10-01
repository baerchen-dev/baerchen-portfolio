/* HEADER Y SCROLL
 * 1. Logo grande (solo Home): al bajar más de UMBRAL px añade data-scrolled al header y el logo se encoge por CSS.
 * 2. Fondo bajo el header: mira qué sección está realmente encima en ese punto (elementsFromPoint, que respeta
 *    el clip-path) y, si su data-fondo es "oscuro", añade data-oscuro → header en crema (salvo con el menú abierto).
 * 3. Efecto cortina (md+): [data-cortina] se queda fija cuando termina de verse (top = alto de pantalla − alto
 *    de la sección) y la siguiente sube por encima.
 * 4. Crecer desde la derecha (md+, automático): mide la foto ([data-crecer-foto]) dentro del panel y pasa sus
 *    distancias al CSS (--c-t/--c-r/--c-b/--c-l), que recorta el panel a la foto. Cuando la foto llega arriba
 *    (ABRIR), añade data-abierto y el CSS lo abre en ~0,9 s; si se vuelve a subir (CERRAR), lo cierra.
 */
const header = document.querySelector( '.site-header' );

if ( header ) {
  const UMBRAL        = 40;
  const ABRIR         = 0.6;    // el borde superior de la foto llega al 60 % de la pantalla (se ve ~la mitad) → se abre
  const CERRAR        = 0.75;   // vuelve a bajar del 75 % → se cierra (margen para que no parpadee)
  const logoGrande    = header.hasAttribute( 'data-logo-grande' );
  const menuBoton     = header.querySelector( '.menu-toggle' );
  const cortinas      = document.querySelectorAll( '[data-cortina]' );
  const crecimientos  = document.querySelectorAll( '[data-crecer]' );
  const escritorio    = window.matchMedia( '(min-width: 48rem)' );
  const sinMovimiento = window.matchMedia( '(prefers-reduced-motion: reduce)' );
  let pendiente = false;

  const conEfectos = () => escritorio.matches && ! sinMovimiento.matches;

  /* 4 · CRECER: se abre o se cierra según dónde esté la foto */
  function actualizarCrecimientos() {
    crecimientos.forEach( ( seccion ) => {
      const foto = seccion.querySelector( '[data-crecer-foto]' );
      if ( ! foto || ! conEfectos() ) return;
      const arriba  = foto.getBoundingClientRect().top / window.innerHeight;
      const abierto = seccion.hasAttribute( 'data-abierto' );
      if ( ! abierto && arriba <= ABRIR ) seccion.setAttribute( 'data-abierto', '' );
      if ( abierto && arriba > CERRAR )   seccion.removeAttribute( 'data-abierto' );
    } );
  }

  /* 2 · FONDO BAJO EL HEADER */
  function actualizarHeader() {
    if ( logoGrande ) header.toggleAttribute( 'data-scrolled', window.scrollY > UMBRAL );

    // Punto de referencia: centro de la pantalla, a la altura de la fila del logo
    const y = header.getBoundingClientRect().top + 40;
    let fondo = 'claro';
    for ( const el of document.elementsFromPoint( window.innerWidth / 2, y ) ) {
      if ( header.contains( el ) ) continue;
      fondo = el.closest( '[data-fondo]' )?.dataset.fondo || 'claro';
      break;
    }
    const menuAbierto = menuBoton?.getAttribute( 'aria-expanded' ) === 'true';
    header.toggleAttribute( 'data-oscuro', fondo === 'oscuro' && ! menuAbierto );
  }

  /* 3 y 4 · MEDIDAS (al cargar y al cambiar el tamaño de la ventana) */
  function medir() {
    cortinas.forEach( ( el ) => {
      el.style.top = escritorio.matches ? Math.min( 0, window.innerHeight - el.offsetHeight ) + 'px' : '';
    } );
    crecimientos.forEach( ( seccion ) => {
      const panel = seccion.querySelector( '[data-crecer-panel]' );
      const foto  = seccion.querySelector( '[data-crecer-foto]' );
      if ( ! panel || ! foto ) return;
      // Distancias de la foto a los bordes del panel (el clip-path no cambia el tamaño, así que se miden bien)
      const p = panel.getBoundingClientRect();
      const f = foto.getBoundingClientRect();
      seccion.style.setProperty( '--c-t', ( f.top - p.top ) + 'px' );
      seccion.style.setProperty( '--c-r', ( p.right - f.right ) + 'px' );
      seccion.style.setProperty( '--c-b', ( p.bottom - f.bottom ) + 'px' );
      seccion.style.setProperty( '--c-l', ( f.left - p.left ) + 'px' );
    } );
  }

  function fotograma() {
    actualizarCrecimientos();
    actualizarHeader();
    pendiente = false;
  }

  // requestAnimationFrame: como mucho una actualización por fotograma
  function alHacerScroll() {
    if ( ! pendiente ) {
      requestAnimationFrame( fotograma );
      pendiente = true;
    }
  }

  window.addEventListener( 'scroll', alHacerScroll, { passive: true } );
  window.addEventListener( 'resize', () => { medir(); alHacerScroll(); } );
  window.addEventListener( 'load', () => { medir(); alHacerScroll(); } );   // con el alto real de las imágenes
  menuBoton?.addEventListener( 'click', () => requestAnimationFrame( actualizarHeader ) );
  // Al terminar de abrirse o cerrarse Sobre mí, el fondo bajo el header ha cambiado aunque no haya scroll
  crecimientos.forEach( ( seccion ) => seccion.querySelector( '[data-crecer-panel]' )?.addEventListener( 'transitionend', () => requestAnimationFrame( actualizarHeader ) ) );

  medir();
  fotograma();
}
