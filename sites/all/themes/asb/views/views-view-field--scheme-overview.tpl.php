<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */

// dsm($leader);
?>
<?php $count = 0; ?>
<?php foreach($field as $key => $value) {
if($key = 'field_info') {
//    dsm($key);
    if(is_array($value)) {
        if(!empty($value['field_name']) && $value['field_name'] == 'body' && $count < 1) {
            //dsm($value['field_name']);
            //dsm($leader);
          /* if($value->field_name == 'field_body') { */
              $leader_markup = '<div class="scheme-leader"><a href="/user/' .$leader[$row->nid]['uid'] .'">';
              $leader_markup .= $leader[$row->nid]['name'] .'</a></div>';
              $output .= $leader_markup;
              $count += 1;
          /* } */}
        
        }
      }
}
?>
<?php print $output; ?>

