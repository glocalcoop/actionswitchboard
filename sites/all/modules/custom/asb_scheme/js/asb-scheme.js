(function($) {
  Drupal.behaviors.asbScheme = {
    attach: function(context, settings) {
      $("#scheme-images").cycle();
      $('ul.primary li.ctools-use-ajax a.use-ajax').ajaxComplete(function() { //.click(function() {
        $('ul.primary a.active').removeClass('active');
        $(this).addClass('active');
      });
    }
  }
})(jQuery);
