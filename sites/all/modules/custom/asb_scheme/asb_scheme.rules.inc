<?php


/**
 * Implements hook_action_info()
 */
function asb_scheme_action_info() {
  return array(
    'asb_scheme_email_facilitator_action' => array(
      'type' => 'system',
      'label' => t('Email Facilitator on scheme creation'),
      'configurable' => TRUE,
      'triggers' => array('node_presave', 'node_insert', 'node_update'),
    ),
    'asb_scheme_remind_facilitator_action' => array(
      'type' => 'system',
      'label' => t('Email reminder to facilitator'),
      'configurable' => FALSE,
      'triggers' => array('any'),
    ),
  );
}

/**
 * Sends email to facilitator on scheme creation
 */
function asb_scheme_email_facilitator_action($node, $context) {
  $result = db_query('SELECT DISTINCT u.mail FROM {users} u INNER JOIN {users_roles} r ON u.uid = r.uid WHERE r.rid = 6');
  // Now, actually send the mails.
  $params = array(
    'subject' => $context['subject'],
    'message' => $context['message'],
  );

  $from = variable_get('site_mail', ini_get('sendmail_from'));
  $key = 'alert';
  $message = array('result' => TRUE);
  foreach ($result as $row) {
    $message = drupal_mail('asb_scheme', $key, $row->mail, language_default(), $params, $from);
    watchdog('action', 'Sent facilitator email to %email', array('%email' => $row->mail));
    if (!$message['result']) {
      break;
    }
  }
  // dsm($message['result']);
}

/**
 * Notifies facilitators of unchanged schemes.
 */
function asb_scheme_remind_facilitator_action(&$entity, $context = array()) {
  global $base_url;
  if(date("D h",time()) == "Mon 08") {
    $sql = "SELECT node.title, workflow_node.nid, field_facilitator_target_id AS fftid, users.mail 
          FROM {workflow_node} 
          LEFT JOIN {node} 
          ON node.nid = workflow_node.nid 
          JOIN {field_revision_field_facilitator}
          ON field_revision_field_facilitator.entity_id = node.nid 
          JOIN {users} 
          ON users.uid = field_facilitator_target_id 
          WHERE stamp < (UNIX_TIMESTAMP() - 604800) 
          AND sid = 2";
    $result = db_query($sql);
    //dsm($result);
    $facs = array();
    foreach($result as $row) {
      $scheme = '<a href="' .$base_url .'/node/' .$row->nid .'">' .$row->title .'</a>';
      $facs[$row->mail]['uid'] = $row->fftid;
      if(isset($facs[$row->mail]['scheme_link'])) {
        $facs[$row->mail]['scheme_link'] .= $scheme ."\n";
      }else{
        $facs[$row->mail]['scheme_link'] = $scheme ."\n";
      }
    }

    // Create message text for each facilitator
    foreach($facs as $key => $value) {
      $facs[$key]['message'] = "Hi ASB Facilitator,\n\nThese schemes seem neglected, could you check?\n\n";
      $facs[$key]['message'] .= $facs[$key]['scheme_link'];
      $facs[$key]['message'] .= "\n\nYour Action Switchboard Auto-bot!";

      // Now, actually send the mails.
      $params = array(
        'subject' => 'Schemers need you!',
        'message' => $facs[$key]['message'],
      );
      $from = variable_get('site_mail', ini_get('sendmail_from'));
      $mail_key = 'reminder';
      $message = array('result' => TRUE);
      $message = drupal_mail('asb_scheme', $mail_key, $key, language_default(), $params, $from);
      watchdog('action', 'Sent facilitator reminder to %email', array('%email' => $key));
      if (!$message['result']) {
        break;
      }
    }
  }
}


/**
 * Generates settings form for asb_scheme_email_facilitator().
 *
 * @param $context
 *   An array of options of this action (in case it is being edited)
 *
 * @return array $form
 *
 * @see asb_scheme_action_info()
 */
function asb_scheme_email_facilitator_action_form($context) {
  /*
  * We return a configuration form to set the requirements that will
  * match this action before being executed. This is a regular Drupal form and
  * may include any type of information you want, but all the fields of the
  * form will be saved into the $context variable.
  *
  * In this case we are emailing a programmatically chosen facilitator.
  *
  */
  $form['subject'] = array(
    '#title' => t('Subject'),
    '#type' => 'textfield',
    '#description' => t('Subject line of the email message.'),
    '#default_value' => isset($context['subject']) ? $context['subject'] : '',
  );
  $form['message'] = array(
    '#title' => t('Message'),
    '#type' => 'textarea',
    '#description' => t('Message to send to the facilitator.'),
    '#default_value' => isset($context['message']) ? $context['message'] : '',
  );
  $form['tokens'] = array(
    '#title' => t('Available Tokens'),
    '#theme' => 'token_tree',
    '#token_types' => array('node'), // The token types that have specific context. Can be multiple token types like 'term' and/or 'user'
    '#global_types' => TRUE, // A boolean TRUE or FALSE whether to include 'global' context tokens like [current-user:*] or [site:*]. Defaults to TRUE.
    '#click_insert' => TRUE, // A boolean whether to include the 'Click this token to insert in into the the focused textfield' JavaScript functionality. Defaults to TRUE.
  );
  // No more options, return the form.
  return $form;
}

/**
 * Validates settings form for asb_scheme_email_facilitator_action().
 * Verifies that a subject and message exist.
 */
function asb_scheme_email_facilitator_action_validate($form, $form_state) {
  if ($form_state['values']['subject'] == "" || $form_state['values']['message'] == "") {
    form_set_error(t('Please, provide a subject and message.'));
  }
}

/**
 * Submit handler for asb_scheme_email_facilitator_action.
 *
 * Returns an associative array of values which will be available in the
 * $context when an action is executed.
 */
function asb_scheme_email_facilitator_action_submit($form, $form_state) {
  return array(
    'subject' => $form_state['values']['subject'],
    'message' => $form_state['values']['message'],
  );
}
