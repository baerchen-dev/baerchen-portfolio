/* CASO DE ESTUDIO · PROCESO STICKY (sections/proyecto-proceso.php)
 * Solo md+: añade data-listo a la sección (el CSS cambia las imágenes de cada capítulo por el escenario fijo) y marca
 * con data-activo el capítulo más cercano al centro de la pantalla y su escena. Con requestAnimationFrame para no
 * recalcular más de una vez por fotograma. En móvil quita data-listo: capítulos apilados con su imagen.
 */
const procesos = document.querySelectorAll( '[data-proceso]' );
const tablet = window.matchMedia( '(min-width: 48rem)' );

procesos.forEach( ( seccion ) => {
  const capitulos = [ ...seccion.querySelectorAll( '[data-capitulo]' ) ];
  const escenas   = [ ...seccion.querySelectorAll( '[data-escena]' ) ];
  let activo   = -1;
  let pendiente = false;

  function activar( indice ) {
    if ( indice === activo ) return;
    activo = indice;
    capitulos.forEach( ( c, i ) => c.toggleAttribute( 'data-activo', i === indice ) );
    escenas.forEach( ( e, i ) => e.toggleAttribute( 'data-activo', i === indice ) );
  }

  function actualizar() {
    pendiente = false;
    if ( ! tablet.matches ) return;
    const centro = window.innerHeight / 2;
    let cercano = 0;
    let distancia = Infinity;
    capitulos.forEach( ( capitulo, i ) => {
      const caja = capitulo.getBoundingClientRect();
      const d = Math.abs( caja.top + caja.height / 2 - centro );
      if ( d < distancia ) { distancia = d; cercano = i; }
    } );
    activar( cercano );
  }

  function pedir() {
    if ( pendiente ) return;
    pendiente = true;
    requestAnimationFrame( actualizar );
  }

  function preparar() {
    seccion.toggleAttribute( 'data-listo', tablet.matches );
    activo = -1;
    actualizar();
  }

  preparar();
  tablet.addEventListener( 'change', preparar );
  window.addEventListener( 'scroll', pedir, { passive: true } );
  window.addEventListener( 'resize', pedir );
} );
