( function( window, document ) {
  function pharmacy_shop_keepFocusInMenu() {
    document.addEventListener( 'keydown', function( e ) {
      const pharmacy_shop_nav = document.querySelector( '.sidenav' );
      if ( ! pharmacy_shop_nav || ! pharmacy_shop_nav.classList.contains( 'open' ) ) {
        return;
      }
      const elements = [...pharmacy_shop_nav.querySelectorAll( 'input, a, button' )],
        pharmacy_shop_lastEl = elements[ elements.length - 1 ],
        pharmacy_shop_firstEl = elements[0],
        pharmacy_shop_activeEl = document.activeElement,
        tabKey = e.keyCode === 9,
        shiftKey = e.shiftKey;
      if ( ! shiftKey && tabKey && pharmacy_shop_lastEl === pharmacy_shop_activeEl ) {
        e.preventDefault();
        pharmacy_shop_firstEl.focus();
      }
      if ( shiftKey && tabKey && pharmacy_shop_firstEl === pharmacy_shop_activeEl ) {
        e.preventDefault();
        pharmacy_shop_lastEl.focus();
      }
    } );
  }
  pharmacy_shop_keepFocusInMenu();
} )( window, document );