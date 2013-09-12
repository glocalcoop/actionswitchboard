// -*- tab-width: 2 -*-
(function($) {
  Drupal.behaviors.asbModal = {
    attach: function(context, settings) {
      $('.modal-update-title').hide();
      $('ul.primary li.ctools-use-ajax a.use-ajax').click(function() {
        $('ul.primary a.active').removeClass('active');
        $(this).addClass('active');
      });
      $('#modalContent').ajaxComplete(function() {
        var nodeId = $('form.node-form').attr('id');
        // var nodeId = 'update-node-form';
        var nodeType = nodeId.split('-');
        var typeUp = nodeType[0].substr(0,1).toUpperCase()+nodeType[0].substr(1);
        $('.modal-update-title').html('Add ' + typeUp);
        $('.modal-update-title').show();
      });
    }
  }
})(jQuery);

