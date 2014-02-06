( function($) {
  
  asb = {};
  
  /*
@Todo add class new to messages that have <mark class="new"></mark>
  */


  Drupal.behaviors.asb = {
    attach: function(context, settings) {

      if( context == "[object HTMLDocument]" ){

        $('.login-normal').remove();
        $('.login-modal').show();

        $(".login-link.ctools-use-modal").click( function(e){
          $("#modalContent").addClass('login');
          $(window).resize();
        });

        asb.search_visibility_toggle( context, settings );
        asb.enhance_search();

        if( $(".page-user-messages") ){
          asb.highlight_new_messages();
        }
      }

    }

  }
  asb.enhance_search = function(){
    $(".region-search .views-widget-filter-keys label").css("display","none");
    $(".region-search .views-widget-filter-keys input").attr("placeholder","Search for a specific scheme");
    $(".region-search label" ).css('display','none');
  }

  asb.highlight_new_messages = function() {
    $( ".section-dashboard tr, .section-messages tr" ).each( function(){
      var tr = $(this);
      if( tr.find('mark.new').length ) $(this).addClass('new');
    });
  }


  Drupal.theme.prototype.CToolsModalDialog = function () {
    // console.log(Drupal.settings.asb_modal.types);
    console.log("asb_modal");
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
    // html +=        Drupal.CTools.Modal.currentSettings.throbber;
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
    if( $(".view-display-id-page_1") || $(".views-display-id-block_1") ){
      asb.modify_append_pager();
    }
    if( $(".scheme-collection") ){
      asb.scheme_overviews_clamp_descriptions();
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
      var option = $( '<option href="' + href + '">' + label + '</option>' );
      select.append( option );
    });
    var anylink = $('<option value="' + options.find( ".form-type-bef-link a" ).first().href + '">From any collection</option>');
    select.prepend( anylink );
    var defaultopt = $('<option selected="selected" value="' + options.find( ".form-type-bef-link a" ).first().href + '">Filter by Collection</option>');
    select.prepend( defaultopt );
    return select;
  }

  asb.modify_append_pager = function() {

    var infiniteScrollPager = $('#add_page_scroll_wrapper');

    var issues_filter = $('<div id="issues_filter"></div>');
    var issues_select = $("#edit-field-issues-goals-target-id").clone(false, false );
    issues_select.attr('id', 'pager_issue_filter' );
    issues_filter.append(issues_select);

    var collections_filter = $('<div id="collections_filter"></div>')
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
    pager_form.attr('action', form_action );
    pager_form.attr('method', form_method );
    pager_form.attr('accept-charset', form_charset );

    pager_form.append( issues_filter );
    pager_form.append( load_more_button );
    pager_form.append( collections_filter );

    infiniteScrollPager.append( pager_form );

    issues_select.change( function(e) {
      var val = $(this).attr('value');
      console.log( val );
      e.preventDefault();
      window.location.replace( val );
    });

    collections_select.change( function(e) {
      var val = $(this).attr('value');
      console.log( val );
      e.preventDefault();
      window.location.replace( val );
    });


  }

})(jQuery);
