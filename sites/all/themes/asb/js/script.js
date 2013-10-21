( function($) {
  
  asb = {};
  
  Drupal.behaviors.asb = {

    attach: function(context, settings) {
      // Catch TypeError in case form is called via ajax.
      // Fixes problems with Update tab and field modal edit.
      try {
        //console.log( context.body.className.indexOf( "page-schemes" ) );
        if( context.body.className.indexOf( "page-schemes" ) < 0) {
          // console.log( 'Drupal.behaviors.asb.attach', context, settings );
          // $( ".region-search" ).css('overflow','hidden');
//          $( ".region-search" ).css( 'height', $(".region-search").height() );
          $( ".region-search" ).addClass('atrest');
          $( ".region-search" ).addClass('hidden');
        }

        // only hide search for people with JS.
        $( "#nav-find" ).click( function( e ) {
          e.preventDefault();
//          $( ".region-search" ).removeClass('atrest');
          $( ".region-search" ).toggleClass('hidden');
        });
      } catch (err) {
      	if (err.name === 'TypeError') { console.log('Skipping javascript hide search.'); }
      }
    }
  }

})(jQuery);
