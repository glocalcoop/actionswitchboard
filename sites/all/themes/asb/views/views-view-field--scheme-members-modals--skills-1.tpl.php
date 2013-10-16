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
?>
<?php $skills = explode(',', $output); ?>
<?php 
if(!empty($skills[0])) {
    $output = '<ul class="people-skills">';
    foreach($skills as $key => $value) {
        $output .= '<li class="skill">' .$value .'</li>';
    }
    $output .= '</ul>';
}
?>
<?php print $output; ?>
<?php print render($field->remove_button); ?>
<?php print '<!-- added in views-view-field--scheme-members-modal--skills-1.tpl.php using 
template.php function asb_scheme_preprocess_views_view_field -->';