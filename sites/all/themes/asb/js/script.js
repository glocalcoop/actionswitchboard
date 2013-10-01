(function($) {
  
  asb = {};
  
  Drupal.behaviors.asb = {

    attach: function(context, settings) {

//      console.log( 'Drupal.behaviors.asb.attach', context, settings );
      $( ".region-search" ).css('overflow','hidden');
      $( ".region-search" ).addClass('hidden');

      // only hide search for people with JS.

      $( "#nav-find" ).click( function( e ) {
        e.preventDefault();
        $( ".region-search" ).toggleClass('active');
        $( ".region-search" ).toggleClass('hidden');
      });

    }

  }

})(jQuery);
