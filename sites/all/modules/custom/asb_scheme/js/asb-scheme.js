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
      // we could append this in the HTML just trying to take some of the load off.
      $("#carousel-wrapper").after('<nav id="scheme-images-nav"><a class="cycle-arrow" id="scheme-images-previous" href="#">Previous</a><a id="scheme-images-next" class="cycle-arrow" href="#">Next</a></nav>');
      $("#carousel-wrapper").cycle({
        fx:     'fade', 
        speed:  450, 
        timeout: 4000,
        fx:    'scrollHorz',
        pause: 1, // pause on hover
        next:   '#scheme-images-next', 
        prev:   '#scheme-images-previous',
        fit: 1

      });
    });

})(jQuery);
