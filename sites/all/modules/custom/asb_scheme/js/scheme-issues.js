(function($) {
  Drupal.behaviors.asbScheme = {
    attach: function(context, settings) {

      function checkParentgoals(myGoal) {
        // Mark parent goals as checked when 
        // child goals are checked
        var myClasses = myGoal.attr('class').split(/\s+/);
        $.each(myClasses, function(index, value) {
          if(value.indexOf('pgoal') >= 0) {
            $('input#edit-field-issues-goals-und-' + value.split('pgoal-')[1]).prop('checked', true);
          }
        });
      };

      function getRandomColor() {
        // Generate a random color on the lighter side
        // of the spectrum.

        var letters = '9ABCDEF'.split('');
        var color = '#';
        var grey = letters[Math.round(Math.random() * 6)]
        for (var i = 0; i < 6; i++ ) {
          color += letters[Math.round(Math.random() * 6)]
        }
        return color;
      }

      function shTopLevelGoals(issue,sh) {
        //  show/hide top level goals for the issue
        //  based on classes associated with the goal
        // sh should be either show or hide
        var goals = $('.issue-' + issue);
        goals.each(function () {
          if($(this).attr('class').split(/\s+/).length < 3) {
            if(sh == "show") {
              $('.' + $(this).attr('class').split(/\s+/)[0]).parent('span').parent('label').parent('.form-item').show();
            } else {
              $('.' + $(this).attr('class').split(/\s+/)[0]).parent('span').parent('label').parent('.form-item').hide();
            }
          } else {
            $('.' + $(this).attr('class').split(/\s+/)[0]).parent('span').parent('label').parent('.form-item').hide();
          }
        });
      }

      var issues = $('#edit-field-issues-goals-und .form-item:contains("Issue")').children('label').children('.field-content');
      var is = $('#edit-field-issues-goals-und .form-item:contains("Issue")').children('input:checked')
      if (is.length == 1) {
        $('#edit-field-issues-goals-und .form-item:contains("Issue")').hide();
        is.parent().show();
        shTopLevelGoals(is.val(),"show");
      }

      issues.each(function() {
        var color = getRandomColor();
        $('.form-item-field-issues-goals-und-' + $(this).text()).css('background', color);
        $('.issue-' + $(this).text()).parent('span').parent('label').parent('.form-item').css('background', color);                                                        
        if($('#edit-field-issues-goals-und-' + $(this).text()).prop('checked')) {
          // Show top level goals for the checked issue on load
          shTopLevelGoals($(this).text(), "show");
        } else {
          $('.issue-' + $(this).text()).parent('span').parent('label').parent('.form-item').hide();
        }
        // Here we bind a show/hide click event to issue checkboxes
        $('.form-item-field-issues-goals-und-' + $(this).text()).on("click", function() {
          if($(this).children('input').prop('checked') == false) {
            $('#edit-field-issues-goals-und .form-item:contains("Issue")').show();
            shTopLevelGoals($(this).children('input').val(),"hide");
          } else {
            $('#edit-field-issues-goals-und .form-item:contains("Issue")').hide();  
            $(this).show();
            shTopLevelGoals($(this).children('input').val(), "show");
            
          }
        });
      });

      var goals = $('[class*=goal-nid-]')
      goals.each(function() {
        // Loop over each goal checkbox 
        var children = $('.pgoal-' + $(this).text()).parent('span').parent('label').parent('.form-item');
        // Here we re-odrer goals so child goals come after parent goals
        children.insertAfter('.form-item-field-issues-goals-und-' + $(this).text());
        // Change state of child goals based no checked status of parents
        if($('#edit-field-issues-goals-und-' + $(this).text()).prop('checked')) {
          $('.pgoal-' + $(this).text()).parent('span').parent('label').parent('.form-item').show();
        }else{
          $('.pgoal-' + $(this).text()).parent('span').parent('label').parent('.form-item').hide();
        }
        // bind show/hide functionality to goal checkboxes
        $('#edit-field-issues-goals-und-' + $(this).text()).on("click", function() {
          if($(this).prop('checked')) {
            $('.pgoal-' + $(this).val()).parent('span').parent('label').parent('.form-item').show()
            checkParentgoals($('.goal-nid-' + $(this).val()));
          }else{
            $('.pgoal-' + $(this).val()).parent('span').parent('label').parent('.form-item').hide();
            $('.pgoal-' + $(this).val()).parent('span').parent('label').parent('.form-item').children('input').prop('checked',false);
          }
        });
      });
    }
  }  
})(jQuery);
