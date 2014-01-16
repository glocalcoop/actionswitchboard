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
// dsm($field);

?>
<?php if ($field->field_alias == "nid" && isset($field->iid)):  ?>
    <span class="<?php print $field->target_classes; ?>  issue-<?php print $field->iid; ?>"><?php print $output; ?></span>
<?php else: ?>
<?php print $output;?>
<?php endif; ?>
