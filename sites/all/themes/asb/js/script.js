(function($) {
  
  asb = {};
  
  Drupal.behaviors.asb = {

    attach: function(context, settings) {

      if( context.body.className.substr( "page-schemes" ) == -1 ) {

        console.log( 'Drupal.behaviors.asb.attach', context, settings );
        $( ".region-search" ).css('overflow','hidden');
        $( ".region-search" ).addClass('atrest');
        $( ".region-search" ).addClass('hidden');

        // only hide search for people with JS.

        $( "#nav-find" ).click( function( e ) {
          e.preventDefault();
          $( ".region-search" ).removeClass('atrest');
          $( ".region-search" ).toggleClass('hidden');
        });

      }

    }

  }

})(jQuery);
