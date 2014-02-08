(function($) {
  Drupal.behaviors.asbScheme = {
    attach: function(context, settings) {
      jQuery('#edit-field-issues-goals').find('input[name=field_issues_goals[und]]:checked').click();
      jQuery('#edit-field-scheme-goals-taxonomy').show();
    }
  }
})(jQuery);
