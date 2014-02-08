(function($, Drupal) {
   // Our function name is prototyped as part of the Drupal.ajax namespace, adding to the commands:
   Drupal.ajax.prototype.commands.afterAjaxCallbackAsb = function(ajax, response, status) {
     // Now we close the modal
     $('a.close')[0].click();
     $('li.update-tab a')[0].click();
   };
 }(jQuery, Drupal));
