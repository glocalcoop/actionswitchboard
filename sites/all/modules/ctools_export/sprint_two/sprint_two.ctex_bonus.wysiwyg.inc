<?php

/**
 * @file
 * Bulk export of wysiwyg generated by Drush Ctools Export Bonus.
 * Use drush cbrw modulename to rebuild wysiwyg.
 */

/**
 * Implements hook_drush_ctex_bonus_wysiwyg().
 */
function sprint_two_drush_ctex_bonus_wysiwyg() {
  $wysiwyg = array();

  $wysiwyg['filtered_html'] = array(
    'format' => 'filtered_html',
    'editor' => '',
    'settings' => NULL,
  );

  $wysiwyg['full_html'] = array(
    'format' => 'full_html',
    'editor' => '',
    'settings' => NULL,
  );

  $wysiwyg['php_code'] = array(
    'format' => 'php_code',
    'editor' => '',
    'settings' => NULL,
  );

  $wysiwyg['plain_text'] = array(
    'format' => 'plain_text',
    'editor' => '',
    'settings' => NULL,
  );

  return $wysiwyg;
}