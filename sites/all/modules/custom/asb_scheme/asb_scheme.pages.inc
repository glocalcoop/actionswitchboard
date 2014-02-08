<?php

/**
 * Renders a view via ajax
 * @param $view_name
 *  The view name to render
 * @param $display_name
 *  The display name of the view to render
 * @param $gid
 *  The organic group id supplied as argument to the view
 *  and used to render og specific modal dialog forms
 */
function asb_scheme_display_view($js = NULL, $view_name, $display_name, $gid) {
  global $user;
  // display view via ajax depending on $view_name and $display name
  $view = views_get_view($view_name);
  $view->set_display($display_name);
  $view->set_arguments(array($gid));
  // Node types we want modals for.
  $node_types = array('update','event','announcement');
  // Determine user_access for node creation
  // If they fail access check remove the node type
  // from the array.
  foreach($node_types as $key => $value) {
    if(!og_user_access('node', $gid, "create $value content")) {
      unset($node_types[$key]);
    }
  }
  if(!empty($node_types)) {
    $header = asb_modal_settings($gid, $node_types);
  }else{
    $header = '<p class="scheme-updates-header"><strong>Read about this scheme\'s activities.</strong></p>';
  }
  $options = array(
     'id' => 'area',
     'table' => 'views',
     'field' => 'area',
     'empty' => TRUE,
     'content' => $header,
     'format' => 'full_html',
     'tokenize' => 0,
   );
   $view->display_handler->set_option('header', array('text' => $options));
   // dsm($view->page);
   $view->execute();
   $output = $view->render();
   // dsm($output);
   if($js) {
     ctools_include('ajax');
     $commands = array();
     $commands[] = ajax_command_html('#scheme-content', $output);
     print ajax_render($commands);

   }else{
     return $output;
   }
}
