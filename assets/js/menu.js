/* MENÚ PRINCIPAL
 * Abre y cierra el menú (#menu-principal), que baja desde el header a todo el ancho
 */
const menuBoton = document.querySelector( '.menu-toggle' );
const menuPanel = document.getElementById( 'menu-principal' );

if ( menuBoton && menuPanel ) {

  function abrirMenu( conTeclado = false ) {
    menuBoton.setAttribute( 'aria-expanded', 'true' );
    menuBoton.setAttribute( 'aria-label', menuBoton.dataset.labelCerrar );
    menuPanel.setAttribute( 'data-open', '' );
    // Solo con teclado: con el ratón no hace falta y mostraría el recuadro de foco
    if ( conTeclado ) menuPanel.querySelector( 'a' )?.focus();
  }

  function cerrarMenu( devolverFoco = true ) {
    menuBoton.setAttribute( 'aria-expanded', 'false' );
    menuBoton.setAttribute( 'aria-label', menuBoton.dataset.labelAbrir );
    menuPanel.removeAttribute( 'data-open' );
    if ( devolverFoco ) menuBoton.focus();
  }

  const estaAbierto = () => menuBoton.getAttribute( 'aria-expanded' ) === 'true';
  const dentroDelMenu = ( el ) => menuPanel.contains( el ) || menuBoton.contains( el );

  // e.detail === 0 → el clic viene del teclado (Enter / Espacio), no del ratón
  menuBoton.addEventListener( 'click', ( e ) => estaAbierto() ? cerrarMenu( e.detail === 0 ) : abrirMenu( e.detail === 0 ) );

  // Escape cierra el menú
  document.addEventListener( 'keydown', ( e ) => {
    if ( e.key === 'Escape' && estaAbierto() ) cerrarMenu();
  } );

  // Clic fuera del menú lo cierra
  document.addEventListener( 'click', ( e ) => {
    if ( estaAbierto() && ! dentroDelMenu( e.target ) ) cerrarMenu( false );
  } );

  // Si el foco sale del menú con el tabulador, se cierra
  menuPanel.addEventListener( 'focusout', ( e ) => {
    if ( estaAbierto() && e.relatedTarget && ! dentroDelMenu( e.relatedTarget ) ) cerrarMenu( false );
  } );

  // Al pulsar un enlace se cierra (útil en anclas dentro de la misma página)
  menuPanel.addEventListener( 'click', ( e ) => {
    if ( e.target.closest( 'a' ) ) cerrarMenu( false );
  } );
}
