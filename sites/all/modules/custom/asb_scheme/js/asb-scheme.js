(function($) {
  Drupal.behaviors.asbScheme = {
    attach: function(context, settings) {
      $('ul.primary li.ctools-use-ajax a.use-ajax').ajaxComplete(function() { //.click(function() {
        $('ul.primary a.active').removeClass('active');
        $(this).addClass('active');
      });
    }
  }
    $(window).bind('load', function() {
        $("#scheme-images").cycle();
    });

})(jQuery);
