(function($) {
  
  asb = {};

  console.log( 'hi' );
  
  Drupal.behaviors.asb = {
    attach: function(context, settings) {
//      console.log( 'Drupal.behaviors.asb.attach', context, settings );
//      $( "#region-search" ).height( 0 );
      console.log( $( "#navigation .nav menu-mlid-1205" ) );
      $( "#navigation .nav menu-mlid-1205" ).click( function( e ) {
        e.preventDefault();
        console.log( "!!!!", e );
      });
    }
  }

})(jQuery);
