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
// dsm(array_keys((array)$field->view));
//dsm(array_keys((array)$field));
// dsm($field->field);
?>
<?php $count = 0; ?>
<?php 
foreach($field as $key => $value) {
  if($key = 'field_info') {
    if(is_array($value)) {
      if(!empty($value['field_name'])) {
        if($value['field_name'] == 'field_location' && $count < 1) {
          // TODO: Clean up this template file, want to make sure nothing unexpected breaks first.
          // $leader_markup = '<div class="scheme-leader"><a href="/user/' .$leader[$row->nid]['uid'] .'">';
          // $leader_markup .= $leader[$row->nid]['name'] .'</a></div>';
          // $leader_markup .= '<!-- Added in views-view-field--scheme-overview.tpl.php -->'; */
            // $output = $leader_markup .$output;
            $output = "";
          $count += 1;
        }elseif($value['field_name'] == 'field_progress') {
          $output = $progress;
        }
      }
    }
  }
}
?>
<?php 
if($field->field == 'body' && $field->view->current_display != 'block_3') { 
   $output = '<div class="scheme-overview-body-wrap">' .$leader_markup .$location .$output .'</div>'; 
} 
?>
<?php if($field->field == 'field_issues_goals') { $output = $completed; } ?>
<?php print $output; ?>

