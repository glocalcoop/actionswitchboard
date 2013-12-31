/**
* Provide the HTML to create the modal dialog.
*/
(function ($) {

Drupal.theme.prototype.asb_modal = function () {
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


   // Drupal.behaviors.asb_modal = {
   //  attach: function( context, settings ){
   //      console.log("ASB MODAL!!!")
   //      $("input[id*='remove-button']", context).once( function(){
   //        console.log("looking for remove-button inputs");
   //        var ri = $(this);
   //        var rb = $('<a class="icon delete" href="#"><span>Delete</span></a>' );
   //        //ri.css('display','none');
   //        rb.insertAfter( ri );
   //        console.log( ri.form );
   //        // rb.click( clickHandler );
   //        rb.click( function(e){
   //          console.log( this.form );
   //          console.log( ri.data );
   //          console.log( ri.data("events").click );
   //          ri.click();
   //          e.preventDefault();
   //        });
   //      });
   //  }
   // }

})(jQuery);