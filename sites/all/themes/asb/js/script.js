(function($) {
  
  asb = {};
  
  Drupal.behaviors.asb = {

    attach: function(context, settings) {

//      console.log( 'Drupal.behaviors.asb.attach', context, settings );
      $( ".region-search" ).css('overflow','hidden');

      // only hide search for people with JS.

      $( "#navigation .menu-mlid-1205" ).click( function( e ) {
        e.preventDefault();
        $( ".region-search" ).toggleClass('active');
      });

    }

  }

})(jQuery);
