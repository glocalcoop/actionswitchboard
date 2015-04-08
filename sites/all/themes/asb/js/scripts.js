// Avoid `console` errors in browsers that lack a console.
(function() {
  var method;
  var noop = function () {};
  var methods = [
    'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
    'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
    'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
    'timeStamp', 'trace', 'warn'
  ];
  var length = methods.length;
  var console = (window.console = window.console || {});

  while (length--) {
    method = methods[length];

    // Only stub undefined methods.
    if (!console[method]) {
      console[method] = noop;
    }
  }
})();

(function($) {

  asb = {};


  Drupal.behaviors.asb = {
    attach: function(context, settings) {

      if(context == "[object HTMLDocument]"){

        $('.login-normal').remove();
        $('.login-modal').show();

        if($(".login-link.ctools-use-modal").length){
          $(".login-link.ctools-use-modal").click( function(e){
            $("#modalContent").addClass('login');
            $(window).resize();
          });
        }

        if($('a[title="Request Membership"]').length){
          $('a[title="Request Membership"]').click( function(e){
            $("#modalContent").addClass('request-membership');
          });
        }

        if($('.view-display-id-block .donate-button a').length){
          $('.view-display-id-block .donate-button a').click( function(e){
            $("#modalContent").addClass('donate-skills');
          });
        }

        asb.search_visibility_toggle(context, settings);
        asb.enhance_search();

        if($("block-views-scheme-overview-block-1") || $(".view-id-scheme_overview_filtered")){
          asb.modify_append_pager();
        }

        if($(".scheme-collection")) {
          //console.log("clamp!");
          asb.scheme_overviews_clamp_descriptions();
        }

        if($(".page-user-messages")) {
          asb.highlight_new_messages();
        }

      }

    }

  }


  asb.newsletterSubscribeKeyEvents = function(e) {
    switch(e.keyCode) {
      case  13: // enter
        asb.submitNewsletter(e);
        break;
      case 27: //esc
        asb.closeNewsletterSubscribeModal(e);
        break;
    }
  }

  asb.enhance_search = function(){
    $(".region-search .views-widget-filter-keys label").css("display","none");
    $(".region-search .views-widget-filter-keys input").attr("placeholder","Search for a specific scheme");
    $(".region-search label" ).css('display','none');
    asb.setup_filter_icon_toggle();
  }

  asb.highlight_new_messages = function() {
    $( ".section-dashboard tr, .section-messages tr" ).each( function(){
      var tr = $(this);
      if( tr.find('mark.new').length ) $(this).addClass('new');
    });
  }

  Drupal.theme.prototype.CToolsModalDialog = function () {
    // console.log(Drupal.settings.asb_modal.types);
    var html = '';
    html += '<div id="ctools-modal" class="popups-box">';
    html += '   <div class="ctools-modal-content ctools-modal-asb-modal-update">';
    html += '       <div class="modal-content-wrapper">'
    html += '           <header class="modal-head-wrapper">';
    html += '               <span class="modal-update-title" style="display:none;">Add Update</span>';
    html += '               <span class="popups-close"><a class="close ctools-close-modal" href="#"><span>Close Window</span></a></span>';
    html += '           </header>';
    html += '           <div class="modal-scroll"><div id="modal-content" class="modal-content popups-body"></div></div>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
  }

  /**
   * Provide the HTML to create the throbber.
   */
  Drupal.theme.prototype.CToolsModalThrobber = function () {
    var html = '';
    html += '  <div id="modal-throbber">';
    html += '    <div class="modal-throbber-wrapper">';
    html += '    </div>';
    html += '  </div>';

    return html;
  };


  asb.search_visibility_toggle = function( context, settings ){
    // Catch TypeError in case form is called via ajax.
    // Fixes problems with Update tab and field modal edit.
    try {
//    console.log( context, context.body.className.indexOf( "page-schemes" ) );
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

  }

  asb.scheme_overviews_clamp_descriptions = function(){
    // truncate titles after 2 lines with …
    $(".scheme-collection .scheme-name a").each( function(){
      // console.log( "asb.scheme-name a", this );
      if( $(this).text() ) $clamp( this, { clamp: 2 } );
    });
    // truncate descriptions after 6 lines with …
    $(".scheme-collection .scheme-description .field-body p").each( function(){
      // console.log( "asb.scheme_overviews_clamp_descriptions", this );
      if( $(this).text() ) $clamp( this, { clamp: 6 } );
    });
  }

  asb.build_collections_pulldown = function() {
    var options = $(".region-search .bef-select-as-links");
    var select = $('<select class="collections"></select>');
    options.each( function() {
      var el = $(this);
      var label = el.find( ".form-type-bef-link a" ).last().text();
      var href = el.find( ".form-type-bef-link a" ).last().attr('href');
      var option = $( '<option></option>' );
      option.text(label);
      option.attr('value',href);
      select.append( option );
    });
    var anylink = $('<option value="' + options.find( ".form-type-bef-link a" ).first().href + '">From any collection</option>');
    select.prepend( anylink );
    var defaultopt = $('<option selected="selected" value="' + options.find( ".form-type-bef-link a" ).first().val() + '">Filter by Collection</option>');
    select.prepend( defaultopt );
    return select;
  }

  asb.setup_filter_icon_toggle = function(){
    var featured_all_href = $("#edit-field-featured-value-all a").attr('href');
    var featured_icon= $("#edit-field-featured-value-1");
    if( featured_icon.hasClass('selected') ){
      featured_icon.on( 'click', function(e){
        e.preventDefault();
        window.location.replace( featured_all_href );
      });
    }
    var movie_all_href = $("#edit-field-from-the-movie-value-all a").attr('href');
    var movie_icon= $("#edit-field-from-the-movie-value-1");
    if( movie_icon.hasClass('selected') ){
      movie_icon.on( 'click', function(e){
        e.preventDefault();
        window.location.replace( movie_all_href );
      });
    }
    var completed_all_href = $("#edit-sid-all a").attr('href');
    var completed_icon= $("#edit-sid-5");
    if( completed_icon.hasClass('selected') ){
      completed_icon.on( 'click', function(e){
        e.preventDefault();
        window.location.replace( completed_all_href );
      });
    }
  }

  asb.modify_append_pager = function() {

    // console.log( "asb.modify_append_pager" );
    var infiniteScrollPager = $('#add_page_scroll_wrapper');

    var issues_filter = $('<div id="issues_filter"></div>');
    var issues_select = $("#edit-field-issues-goals-target-id").clone( false, false );
    // console.log(issues_select);
    issues_select.attr('id', 'pager_issue_filter' );
    issues_filter.append(issues_select);

    var collections_filter = $('<div id="collections_filter"></div>');
    var collections_select = asb.build_collections_pulldown();
    collections_filter.append( collections_select );

    var load_more_button = $("#load_more_schemes_button");
    // remove from dom... to add in the right spot later
    load_more_button.remove();

    var schemes_search_form = $("#views-exposed-form-scheme-overview-filtered-page-1");
    var form_action = schemes_search_form.attr("action");
    var form_method = schemes_search_form.attr("method");
    var form_charset = schemes_search_form.attr("accept-charset");

    var pager_form = $("<form></form>");
    pager_form.attr( 'action', form_action );
    pager_form.attr( 'method', form_method );
    pager_form.attr( 'accept-charset', form_charset );

    pager_form.append( issues_filter );
    pager_form.append( load_more_button );
    pager_form.append( collections_filter );

    infiniteScrollPager.append( pager_form );

    load_more_button.click( function( e ) {
      e.preventDefault();
      $.autopager('load');
    });

    issues_select.change( function(e) {
      var val = $(this).val();
      e.preventDefault();
      pager_form.submit();
    });

    collections_select.change( function(e) {
      var val = ($(this).val() != "undefined" )? $(this).val() : '/schemes';
      e.preventDefault();
      window.location.replace( val );
    });

  }

})(jQuery);
