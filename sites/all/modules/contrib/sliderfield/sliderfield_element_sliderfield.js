(function($, Drupal) {
  /**
   * This script adds jQuery slider functionality to transform_slider form element
   */
  Drupal.behaviors.SliderFieldSliderField = {
    attach: function (context, settings) {

      // Create sliders
      $('.sliderfield-container:not(.sliderfield-processed)', context).each(function () {

        $(this).addClass('sliderfield-processed');
        var slider_id = $(this).parent().attr('id');
        var setting = settings['sliderfield_' + slider_id];

        // Get values
        var $slider = $(this).parents('.sliderfield', context);

        var $values = [];
        var $value = $slider.find('.sliderfield-value-field', context).val() - 0;
        var $value2 = $slider.find('.sliderfield-value2-field', context).val() - 0;
        if (!isNaN($value2)) {
          $values = [$value, $value2];
        } else {
          setting.value = $value;
          setting.current_value = $value;
        }

        if (!setting.display_inputs) {
          $slider.find('.sliderfield-value-field, .sliderfield-value2-field', context).hide();
          $slider.find('label', $slider.find('.sliderfield-value-field, .sliderfield-value2-field', context).parents()).hide();
        }
        // Setup slider
        $(this).slider({
          value: $value,
          animate : setting.animate,
          max : setting.max - 0,
          min : setting.min - 0,
          orientation : setting.orientation,
          range : setting.range,
          step : setting.step,
          values : $values,
          slide: sliderfieldsSlideProcess,
          stop: sliderfieldsSlideStop,
          change: sliderfieldsSlideChange,
          create: sliderfieldsSlideCreate,
        });

        if (setting.disabled) {
          $(this).slider( "disable" );
        }

        sliderfieldsSlideUpdateFields($slider, {value: $value, values: $values});

        // Adjust the range when the target field is changed
        var adjust_field = $(setting.adjust_field_max_css_selector  + ',' + setting.adjust_field_min_css_selector);
        if (adjust_field.length) {
          adjust_field.bind('keyup', function(event) {
            var $target = $(event.target);
            var option_name = "";
            var target_value = parseInt($target.val());
            if (target_value) {
              if ($target.hasClass(setting.adjust_field_min_css_selector.replace('.', ''))) {
                option_name = "min";
                $slider.find('.sliderfield-min-value-field', context).val(target_value);
              } else if ($target.hasClass(setting.adjust_field_max_css_selector.replace('.', ''))) {
                option_name = "max";
                $slider.find('.sliderfield-max-value-field', context).val(target_value);
              }
              var $SliderField = $slider.find('.sliderfield-container', context);
              $SliderField.slider("option", option_name, target_value);
              $SliderField.slider("option", {
                "value" : $SliderField.slider('value'),
                "values" : $SliderField.slider('values')
              });
            }
          });
          adjust_field.trigger('keyup');
        }
      });



      // Bind left textfield changes
      $('.sliderfield-value-field:not(.sliderfield-processed)', context)
          .addClass('sliderfield-processed')
          .keyup(function(e) {
            // Get container
            var $slider = $(this).parents('.sliderfield', context);

            // Left input value
            var $value = $(this).val() - 0;
            if (isNaN($value)) {
              $value = 0;
              $slider.find('.sliderfield-value-field', context).val($value);
            }

            // Get slider max value
            var $SliderField = $slider.find('.sliderfield-container', context);
            var $max = $SliderField.slider('option', 'max');

            // Validate left input
            if ($value > $max) {
              $value = $max;
              $slider.find('.sliderfield-value-field', context).val($value);
            }

            // Setup right value
            //$slider.find('.sliderfield-right-field', context).val($max - $left);

            // Move slider without toggling events
            $SliderField.slider({value: $value});
          });

      // Bind left textfield changes
      $('.sliderfield-value2-field:not(.sliderfield-processed)', context)
          .addClass('sliderfield-processed')
          .keyup(function(e) {

            // Get container
            var $slider = $(this).parents('.sliderfield', context);

            // Left input value
            var $value = $(this).val() - 0;
            if (isNaN($value)) {
              $value = 0;
              $slider.find('.sliderfield-value2-field', context).val($value);
            }

            // Get slider max value
            var $SliderField = $slider.find('.sliderfield-container', context);
            var $max = $SliderField.slider('option', 'max');

            // Validate left input
            if ($value > $max) {
              $value = $max;
              $slider.find('.sliderfield-value2-field', context).val($value);
            }

            // Setup right value
            //$slider.find('.sliderfield-right-field', context).val($max - $left);

            // Move slider without toggling events
            $SliderField.slider('values', 1, $value);
          });
    }
  }

  var sliderfieldsSlideStop = function($slider, ui) {
    var $slider = $(this).parents('.sliderfield');
    $slider_id = $slider.attr('id');
    var setting = Drupal.settings['sliderfield_' + $slider_id];
    if (ui.value) {
      //setting.value = ui.value;
      //setting.current_value = ui.value;
    }
  }

  // Slider update related fields
  var sliderfieldsSlideUpdateFields = function($slider, ui) {
    $slider_id = $slider.attr('id');
    var setting = Drupal.settings['sliderfield_' + $slider_id];

    var $values = [];
    if ($slider.find('.sliderfield-value2-field').length > 0) {
      $slider.find('.sliderfield-value-field').val(ui.values[0]);
      $slider.find('.sliderfield-value2-field').val(ui.values[1]);
      $values = ui.values;

    } else {
      $slider.find('.sliderfield-value-field').val(ui.value);
      $values.push(ui.value);
    }
    for(var i = 0; i < $values.length; i++) {
      $values[i] = setting.display_values_format.replace('%{value}%', $values[i]);
      // Update handler bubble
      if (setting.display_bubble) {
        var bubble_value = setting.display_bubble_format.replace('%{value}%', $values[i]);
        $('#' + $slider_id + ' .ui-slider-handle:eq(' + i + ') .sliderfield-bubble').html(bubble_value);
      }
    }
    $slider.find('.sliderfield-display-values-field').html($values.join(' - '));
  }

  var sliderfieldsSlideChange = function(event, ui) {
    // Setup values
    var $slider = $(this).parents('.sliderfield');
    sliderfieldsSlideUpdateFields($slider, ui);

    $slider_id = $slider.attr('id');
    var setting = Drupal.settings['sliderfield_' + $slider_id];
    // Sync other sliders in the same group
    if (setting.group) {
      var $group_sliders = $('.sliderfield:[id!="' + $slider_id + '"].sliderfield-group-' + setting.group);
      if ($('.sliderfield:[id!="' + $slider_id + '"].sliderfield-group-master.sliderfield-group-' + setting.group).length < 1) {
        var $group_slider;
        var $group_slider_settings;
        var $group_ui;
        for(var i = 0; i < $group_sliders.length; i++) {
          $group_slider = $($group_sliders[i]);
          $group_ui = $group_slider.find('.sliderfield-container');
          $group_slider_settings = Drupal.settings['sliderfield_' + $group_slider.attr('id')];

          sliderfieldsSlideUpdateFields($group_slider, {value:$group_ui.slider('value'), values: $group_ui.slider('values')});

          $group_slider_settings.value = $group_ui.slider('value');
        }
      }
    }

    if (ui.value) {
      setting.value = ui.value;
    }

    //Manually trigger element change event for compatibility with Drupal's ajax system
    $slider.find('.sliderfield-value-field').trigger('change');
  }

  var sliderfieldsSlideCreate = function(event, ui) {
    var $slider = $(this).parents('.sliderfield');
    $slider_id = $slider.attr('id');
    var setting = Drupal.settings['sliderfield_' + $slider_id];

    // Add bubble to each handler
    if (setting.display_bubble) {
      var handle = $(this).find('.ui-slider-handle');
      var bubble_value = '';//setting.display_bubble_format.replace('%{value}%', ui.value);
      var bubble = $('<div class="sliderfield-bubble">' + bubble_value + '</div>');
      handle.append(bubble);
    }
  }

  // Slider processor
  var sliderfieldsSlideProcess = function(event, ui) {
    // Setup values
    var $slider = $(this).parents('.sliderfield');
    sliderfieldsSlideUpdateFields($slider, ui);

    $slider_id = $slider.attr('id');
    var setting = Drupal.settings['sliderfield_' + $slider_id];

    // Sync other sliders in the same group
    if (setting.group) {
      var $value_diff_orig = ui.value - setting.value;
      //var value_diff = ui.value - setting.current_value;

      var $group_sliders = $('.sliderfield:[id!="' + $slider_id + '"].sliderfield-group-' + setting.group);
      if ($('.sliderfield:[id!="' + $slider_id + '"].sliderfield-group-master.sliderfield-group-' + setting.group).length < 1) {
        var $group_slider;
        var $group_slider_settings;
        var $group_ui;
        var $items = new Array();
        var $total_diff = $value_diff_orig;
        var $total_diff_items_no = $group_sliders.length;
        var $val;

        for(var i = 0; i < $group_sliders.length; i++) {
          $group_slider = $($group_sliders[i]);
          $group_slider_settings = Drupal.settings['sliderfield_' + $group_slider.attr('id')];
          $items[i] = {value: $group_slider_settings.value, index: i};
        }
        var sortFunc = function(data_A, data_B)
        {
          return (data_A.value - data_B.value);
        }
        $items.sort(sortFunc);

        for(var i = 0; i < $group_sliders.length; i++) {
          var n = $items[i].index;
          $group_slider = $($group_sliders[n]);
          $group_ui = $group_slider.find('.sliderfield-container');
          $group_slider_settings = Drupal.settings['sliderfield_' + $group_slider.attr('id')];

          $group_ui.slider({slide: function() {}, change: function() {}});

          if (setting.group_type == 'same') {
            $group_ui.slider('value', ui.value);
          }
          if (setting.group_type == 'lock') {
            $group_ui.slider('value', $group_slider_settings.value + $value_diff_orig);
          }
          if (setting.group_type == 'total') {
            $val = $group_slider_settings.value - ($total_diff / $total_diff_items_no);
            $total_diff = $total_diff - ($total_diff / $total_diff_items_no);
            $total_diff_items_no = $total_diff_items_no - 1;
            if ($val < 0) {
              $total_diff = $total_diff + (-1 * $val);
              $val = 0;
            }

            $group_ui.slider('value', $val);
          }

          $group_ui.slider({slide: sliderfieldsSlideProcess, change: sliderfieldsSlideChange});

          sliderfieldsSlideUpdateFields($group_slider, {value:$group_ui.slider('value'), values: $group_ui.slider('values')});
        }
      }
    }
  }

})(jQuery, Drupal);
