(function($) {
  
  asb = {};
  
  Drupal.behaviors.asb = {

    attach: function(context, settings) {

//      console.log( 'Drupal.behaviors.asb.attach', context, settings );
      $( ".region-search" ).css('overflow','hidden');
//      $( ".region-search" ).css('height', 0);

  $( ".region-search" ).addClass('atrest');
 $( ".region-search" ).addClass('hidden');

      // only hide search for people with JS.

      $( "#nav-find" ).click( function( e ) {
        $( ".region-search" ).removeClass('atrest');
        e.preventDefault();
        $( ".region-search" ).toggleClass('hidden');
      });

    }

  }

})(jQuery);
