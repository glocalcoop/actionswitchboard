// $Id:

(function ($) {
var views_infinite_scroll_was_initialised = false;
Drupal.behaviors.views_infinite_scroll = {
  attach:function( context, settings ) {
    // Make sure that autopager plugin is loaded
    if($.autopager) {
      if(!views_infinite_scroll_was_initialised) {
        views_infinite_scroll_was_initialised = true;
        // There should not be multiple Infinite Scroll Views on the same page
        if(Drupal.settings.views_infinite_scroll.length == 1) { 
          var settings = Drupal.settings.views_infinite_scroll[0];
          var use_ajax = false;
          // Make sure that views ajax is disabled
          if(Drupal.settings.views && Drupal.settings.views.ajaxViews) {
            $.each(Drupal.settings.views.ajaxViews, function(key, value) {
              if((value.view_name == settings.view_name) && (value.view_display_id == settings.display)) {
                use_ajax = true;
              }
            });
          }
          if(!use_ajax) {
            var view_selector    = 'div.view-id-' + settings.view_name + '.view-display-id-' + settings.display;
            var content_selector = view_selector + ' > ' + settings.content_selector;
            var items_selector   = content_selector + ' ' + settings.items_selector;
            var pager_selector   = view_selector + ' > div.item-list ' + settings.pager_selector;
            var next_selector    = view_selector + ' ' + settings.next_selector;
            var img_location     = view_selector + ' > div.view-content';
            var img_path         = settings.img_path;
            var img              = '<div id="views_infinite_scroll-ajax-loader"><img src="' + img_path + '" alt="loading..."/></div>';
            var load_more_button = $("<a id='load_more_schemes_button' href='#' title='Load more schemes...' href='schemes'>Load More Schemes</a>");
            $(view_selector).after( load_more_button );

            $(content_selector).addClass('clearfix');
            $(content_selector).css({
              'position': 'relative'
            });
            var spinner = $('<div class="loading_spinner"><h4>Message</h4></div>').appendTo( $(view_selector) );

            spinner.hide();
            console.log("hihihihi");
            var handle = $.autopager({
              autoLoad: false,
              appendTo: content_selector,
              content: items_selector,
              link: next_selector,
              page: 0,
              start: function() {
                  console.log('start');
                spinner.fadeIn();
//                $(img_location).after(img);
              },
              load: function() {
                console.log("loading...");
//                $('div#views_infinite_scroll-ajax-loader').remove();
                Drupal.attachBehaviors(this);
                spinner.fadeOut();
              }
            });
            load_more_button.click( function( e ) {
              console.log( 'load_more_button clicked!' );
              e.preventDefault();
              $.autopager('load');
            } );



            // Trigger autoload if content height is less than doc height already
            var prev_content_height = $(content_selector).height();
            do {
              var last = $(items_selector).filter(':last');
              if(last.offset().top + last.height() < $(document).scrollTop() + $(window).height()) {
                last = $(items_selector).filter(':last');
                handle.autopager('load');
              }
              else {
                break;
              }
            }
            while ($(content_selector).height() > prev_content_height);

          }
          else {  
            alert(Drupal.t('Views infinite scroll pager is not compatible with Ajax Views. Please disable "Use Ajax" option.'));
          }
        }
        else if(Drupal.settings.views_infinite_scroll.length > 1) {
          alert(Drupal.t('Views Infinite Scroll module can\'t handle more than one infinite view in the same page.'));
        }
      }
    }
    else {
      alert(Drupal.t('Autopager jquery plugin in not loaded.'));
    }
  }
}

})(jQuery);
