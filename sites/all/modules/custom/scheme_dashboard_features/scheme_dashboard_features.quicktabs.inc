<?php
/**
 * @file
 * scheme_dashboard_features.quicktabs.inc
 */

/**
 * Implements hook_quicktabs_default_quicktabs().
 */
function scheme_dashboard_features_quicktabs_default_quicktabs() {
  $export = array();

  $quicktabs = new stdClass();
  $quicktabs->disabled = FALSE; /* Edit this to true to make a default quicktabs disabled initially */
  $quicktabs->api_version = 1;
  $quicktabs->machine_name = 'schemes';
  $quicktabs->ajax = 0;
  $quicktabs->hide_empty_tabs = FALSE;
  $quicktabs->default_tab = 0;
  $quicktabs->title = 'Schemes';
  $quicktabs->tabs = array(
    0 => array(
      'bid' => 'views_delta_scheme_list_for_users-block',
      'hide_title' => 1,
      'title' => 'All',
      'weight' => '-100',
      'type' => 'block',
    ),
    1 => array(
      'bid' => 'views_delta_scheme_list_for_users-block_1',
      'hide_title' => 1,
      'title' => 'I\'ve Adopted',
      'weight' => '-98',
      'type' => 'block',
    ),
    2 => array(
      'bid' => 'views_delta_scheme_user_groups-block_2',
      'hide_title' => 1,
      'title' => 'I\'m Running',
      'weight' => '-97',
      'type' => 'block',
    ),
    3 => array(
      'bid' => 'views_delta_scheme_user_groups-block_1',
      'hide_title' => 1,
      'title' => 'I\'m a Member',
      'weight' => '-96',
      'type' => 'block',
    ),
  );
  $quicktabs->renderer = 'quicktabs';
  $quicktabs->style = 'Navlist';
  $quicktabs->options = array();

  // Translatables
  // Included for use with string extractors like potx.
  t('All');
  t('I\'m Running');
  t('I\'m a Member');
  t('I\'ve Adopted');
  t('Schemes');

  $export['schemes'] = $quicktabs;

  return $export;
}
