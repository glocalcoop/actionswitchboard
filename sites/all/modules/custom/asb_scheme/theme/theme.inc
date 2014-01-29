<?php

/**
 * Create variables for the group statistics block.
 */
function asb_scheme_preprocess_asb_scheme_group_info(&$variables) {
  $group = og_context();

  $variables['group_node_links'] = array();
  $variables['gid'] = NULL;
  $variables['group_type'] = NULL;
  $variables['group_node'] = NULL;
  $variables['created'] = NULL;
  $variables['subscribe_link'] = NULL;
  $variables['subscriber_count'] = NULL;
  $variables['subscriber_link'] = NULL;
  $variables['manager_uids'] = array();
  $variables['managers'] = array();

  if (empty($group)) {
    return NULL;
  }

  $variables['group_node_links'] = og_extras_node_links();
  $variables['gid'] = $group['gid'];
  $variables['group_type'] = $group['group_type'];
  $variables['group_node'] = node_load($group['gid']);

  $variables['subscribe_link'] = og_extras_subscribe('node', $variables['group_node']);

  $variables['created'] = format_date($variables['group_node']->created, 'custom', 'M d Y');

  $variables['subscriber_count'] = og_extras_subscriber_count($variables['gid']);
  $variables['subscriber_link'] = l(t("!count members", array('!count' => $variables['subscriber_count'])), 'node/ ' . $variables['gid'] . '/members');

  // @TODO Add a configuration form to select the 'manager' roles for the group.
  $roles = og_extras_get_roles($variables['gid']);
  foreach ($roles as $role) {
    if($role->name == 'Scheme Leader') {
      $role_rids[] = $role->rid;
    }
  }

  $variables['manager_uids'] = array($variables['group_node']->uid);
  foreach (og_extras_get_users_by_roles($variables['gid'], $role_rids) as $item) {
    $variables['manager_uids'][] = $item->uid;
  }
  $variables['manager_uids'] = array_unique($variables['manager_uids']);
  $first = TRUE;
  $filepath = '';
  foreach ($variables['manager_uids'] as $i => $manager_id) {
    $variables['managers'][$i] = '<div class="scheme-leader">';
    $account = user_load($manager_id);
    if ($first) {
      if (!empty($account->picture->uri)) {
        $filepath = $account->picture->uri;
      }
      elseif (variable_get('user_picture_default', '')) {
        $file = explode('/',variable_get('user_picture_default', ''));
        $filepath = 'public://pictures/' .array_pop($file);
      }
      $alt = t("@user's picture", array('@user' => format_username($account)));
      // If the image does not have a valid Drupal scheme (for eg. HTTP),
      // don't load image styles.
      if (module_exists('image') && file_valid_uri($filepath) && $style = variable_get('user_picture_style', '')) {
        $variables['managers'][$i] .= '<div class="scheme-leader-thumb">';
        $variables['managers'][$i] .= theme('image_style', array('style_name' => 'asb_scheme_leader_thumb', 'path' => $filepath, 'alt' => $alt, 'title' => $alt));
        $variables['managers'][$i] .= '</div>';
      }
      $variables['managers'][$i] .= '<div class="scheme-leader-name">';
      $variables['managers'][$i] .= theme('username', array('account' => $account));
      $variables['managers'][$i] .= '</div>';
      $contact = 'messages/new/' .$manager_id;
      $variables['managers'][$i] .= '<div class="scheme-leader-contact">';
      $variables['managers'][$i] .=  l(t('Contact Me'), $contact, array('attributes' => array('class' => array('contact-me'))));
      $variables['managers'][$i] .= '</div>';
      $first = FALSE;
    }else{
      $variables['managers'][$i] .= '<div class="scheme-leader-name">';
      $variables['managers'][$i] .= theme('username', array('account' => $account));
      $variables['managers'][$i] .= '</div>';
    }
    $variables['managers'][$i] .= '</div>';
  }
}


/**
 * Create variables for the group links block.
 */
function asb_scheme_preprocess_asb_scheme_group_links(&$variables) {
  $group = og_context();

  $variables['group_node_links'] = array();
  $variables['gid'] = NULL;
  $variables['group_type'] = NULL;
  $variables['group_node'] = NULL;

  if (empty($group)) {
    return NULL;
  }
  $variables['group_node_links'] = asb_scheme_node_links();
  $variables['gid'] = $group['gid'];
  $variables['group_type'] = $group['group_type'];
  $variables['group_node'] = node_load($group['gid']);
}
