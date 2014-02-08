<?php

/**
 * Modal callback for og views
 */
function asb_modal_og_modal_callback($js = false, $type = 'admin', $gid = NULL) {
  if ($js) {
    // Required includes for ctools to work:
    ctools_include('modal');
    ctools_include('ajax');
  }
  // Add scheme_members_modals display
  $view_name = 'scheme_members_modals';
  $display_name = 'block_1';
  $view = views_get_view($view_name);
  if ( is_object($view) ) {
    $view->set_display($display_name);
    $view->set_arguments(array($gid));
    $view->pre_execute();
    $contents = $view->render($display_name);
  }
  return ctools_modal_render('Manage Members', $contents);

} 

function asb_modal_modal_callback($js = false, $type = 'update', $gid = NULL) {
  // If the user doesn't have javascript, redirect them to the normal node/add/node-type page
  $js = true;
  if (!$js) {
    drupal_goto('node/add/' .$type);
  }
  else {
    // Javascript is on, prepare ctools modals.
    ctools_include('ajax');
    ctools_include('modal');

    // Pull in the global user, and prepare a blank node to pass to the node
    // add form.
    global $user;
    $node = (object) array('uid' => $user->uid, 'name' => (isset($user->name) ? $user->name : ''), 'type' => $type, 'language' => LANGUAGE_NONE);
    $node->title = NULL;
    node_object_prepare($node);

    // Add the node.pages.inc so that functions from the form can be used.
    module_load_include('inc', 'node', 'node.pages');

    // Prepare the form state, ctools reqruies ajax / title.  The node add form
    // requires node.
    $form_state = array(
      'ajax' => true,
      'title' => t('Add '.ucfirst($type)),
      'node' => $node,
      'og_context' => $gid,
    );

    // Do the ctools_modal_form_wrapping of the node form.  Returns a set of
    // ajax commands in output.
    $output = ctools_modal_form_wrapper( $type .'_node_form', $form_state);

    if (!empty($form_state['executed'])) {
      ctools_include('ajax');
      // Add the responder javascript, required by ctools
      ctools_add_js('ajax-responder');

      // Create ajax command array, dismiss the modal window.
      $output = array();
      $output[] = ctools_modal_command_dismiss();

      $html = views_embed_view('scheme_content', 'page', $gid);
      $output[] = ajax_command_html('#scheme-content', $html);

    }
    print ajax_render($output);

    exit;
  }
} 


/**
 * A modal comment callback.
 */
function asb_modal_comment_reply($js = NULL, $node, $pid = NULL) {
  $output = array();
  $comment = array(
    'pid' => $pid,
    'nid' => $node->nid,
  );

  if (!$js) {
    return drupal_get_form('comment_node_' . $node->type . '_form', (object) $comment);
  }

  ctools_include('modal');
  ctools_include('ajax');

  $form_state = array(
    'build_info' => array(
      'args' => array(
        (object) $comment,
      ),
    ),
    // 'title' => t('Comment'),
    'ajax' => TRUE,
    're_render' => FALSE,
    'no_redirect' => TRUE,
  );

  // Should we show the reply box?
  if ($node->comment != COMMENT_NODE_OPEN) {
    drupal_set_message(t('This discussion is closed: you can\'t post new comments.'), 'error');
    drupal_goto('node/' . $node->nid);
  }
  else {
    $output = drupal_build_form('comment_node_' . $node->type . '_form', $form_state);
    // Remove output bellow the comment.
    unset($output['comment_output_below']);
  }

  if (!$form_state['executed'] || $form_state['rebuild']) {
    $output = ctools_modal_form_render($form_state, $output);
  }
  else {
    // We'll just overwrite the form output if it was successful.
    $output = array();
    // @todo: Uncomment once http://drupal.org/node/1587916 is fixed.
    //if (is_array($form_state['redirect'])) {
    //  list($path, $options) = $form_state['redirect'];
    //  $output[] = ctools_ajax_command_redirect($path, 0, $options);
    //}
    $commands[] = array(
            // The command will be used in our JavaScript file (see next section)
            'command' => 'afterAjaxCallbackAsb',
    );

    if (isset($_GET['destination'])) {
      $output[] = ctools_ajax_command_redirect($_GET['destination']);
    }
    else {
      $output[] = ctools_ajax_command_reload();
    }
  }

  print ajax_render($output);
  // return array('#type' => 'ajax', '#commands' => $commands);
}
