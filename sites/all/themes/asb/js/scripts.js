( function($) {
  
  asb = {};
  
  Drupal.behaviors.asb = {
    attach: function(context, settings) {
      // Catch TypeError in case form is called via ajax.
      // Fixes problems with Update tab and field modal edit.
      try {
//        console.log( context, context.body.className.indexOf( "page-schemes" ) );
        if( context.body.className.indexOf( "page-schemes" ) < 0) {
          // console.log( 'Drupal.behaviors.asb.attach', context, settings );
          $( ".region-search" ).addClass('atrest');
          $( ".region-search" ).addClass('hidden');
        }
        // only hide search for people with JS.
        $( "#nav-find" ).click( function( e ) { 
          e.preventDefault();
          $( ".region-search" ).removeClass('atrest');
          $( ".region-search" ).toggleClass('hidden');
        });
      } catch (err) {
      	if (err.name === 'TypeError') { console.log('Skipping javascript hide search.'); }
      }

      if( $(".view-display-id-page_1") || $(".views-display-id-block_1") ){
        asb.modify_append_pager();
      }
    }

  }

  asb.modify_append_pager = function() {
    var infiniteScrollPager = $('#add_page_scroll_wrapper');
    var searchbox_clone = $("#edit-keys-wrapper input").clone(false,false);
    var issuesfilter_clone = $("#edit-field-issues-goals-target-id-wrapper").clone(false, false );
    var form_filters = $("#views-exposed-form-scheme-overview-filtered-page-1");
    var form_action = form_filters.attr("action");
    var form_method = form_filters.attr("method");
    var form_charset = form_filters.attr("accept-charset");

    issuesfilter_clone.attr('id', 'pager_issue_filter' );
    issuesfilter_clone.removeAttr('id');
    searchbox_clone.removeAttr('id');
    
// could probably do with a single form, but meh.
    var issuesfilterform = $("<form></form>");
    issuesfilterform.attr('action', form_action );
    issuesfilterform.attr('method', form_method );
    issuesfilterform.attr('accept-charset', form_charset );
    issuesfilterform.append( issuesfilter_clone );

    var searchform = $("<form></form>");
    searchform.attr('action', form_action );
    searchform.attr('method', form_method );
    searchform.attr('accept-charset', form_charset );
    searchform.append(searchbox_clone);

    infiniteScrollPager.prepend( issuesfilterform );
    infiniteScrollPager.append( searchform );

    issuesfilter_clone.change( function(e) {
      var val = $(this).attr('value');
      console.log( val );
      e.preventDefault();
      window.location.replace( val );
    });

    searchbox_clone.focus( function(e){
      console.log("focus");
      $(this).keypress(function(e) {
//        console.log( "Handler for .keypress() called.", e.which );
        if( e.which == 13 ){
          e.preventDefault();
          searchform.submit();
        }
      });
    });

    searchbox_clone.blur( function(e){
      $(this).unbind( 'keypress' );
    });
  }

})(jQuery);
