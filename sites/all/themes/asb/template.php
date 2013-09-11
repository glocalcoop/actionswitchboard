<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * A QUICK OVERVIEW OF DRUPAL THEMING
 *
 *   The default HTML for all of Drupal's markup is specified by its modules.
 *   For example, the comment.module provides the default HTML markup and CSS
 *   styling that is wrapped around each comment. Fortunately, each piece of
 *   markup can optionally be overridden by the theme.
 *
 *   Drupal deals with each chunk of content using a "theme hook". The raw
 *   content is placed in PHP variables and passed through the theme hook, which
 *   can either be a template file (which you should already be familiary with)
 *   or a theme function. For example, the "comment" theme hook is implemented
 *   with a comment.tpl.php template file, but the "breadcrumb" theme hooks is
 *   implemented with a theme_breadcrumb() theme function. Regardless if the
 *   theme hook uses a template file or theme function, the template or function
 *   does the same kind of work; it takes the PHP variables passed to it and
 *   wraps the raw content with the desired HTML markup.
 *
 *   Most theme hooks are implemented with template files. Theme hooks that use
 *   theme functions do so for performance reasons - theme_field() is faster
 *   than a field.tpl.php - or for legacy reasons - theme_breadcrumb() has "been
 *   that way forever."
 *
 *   The variables used by theme functions or template files come from a handful
 *   of sources:
 *   - the contents of other theme hooks that have already been rendered into
 *     HTML. For example, the HTML from theme_breadcrumb() is put into the
 *     $breadcrumb variable of the page.tpl.php template file.
 *   - raw data provided directly by a module (often pulled from a database)
 *   - a "render element" provided directly by a module. A render element is a
 *     nested PHP array which contains both content and meta data with hints on
 *     how the content should be rendered. If a variable in a template file is a
 *     render element, it needs to be rendered with the render() function and
 *     then printed using:
 *       <?php print render($variable); ?>
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. With this file you can do three things:
 *   - Modify any theme hooks variables or add your own variables, using
 *     preprocess or process functions.
 *   - Override any theme function. That is, replace a module's default theme
 *     function with one you write.
 *   - Call hook_*_alter() functions which allow you to alter various parts of
 *     Drupal's internals, including the render elements in forms. The most
 *     useful of which include hook_form_alter(), hook_form_FORM_ID_alter(),
 *     and hook_page_alter(). See api.drupal.org for more information about
 *     _alter functions.
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   If a theme hook uses a theme function, Drupal will use the default theme
 *   function unless your theme overrides it. To override a theme function, you
 *   have to first find the theme function that generates the output. (The
 *   api.drupal.org website is a good place to find which file contains which
 *   function.) Then you can copy the original function in its entirety and
 *   paste it in this template.php file, changing the prefix from theme_ to
 *   asb_. For example:
 *
 *     original, found in modules/field/field.module: theme_field()
 *     theme override, found in template.php: asb_field()
 *
 *   where asb is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_field() function.
 *
 *   Note that base themes can also override theme functions. And those
 *   overrides will be used by sub-themes unless the sub-theme chooses to
 *   override again.
 *
 *   Zen core only overrides one theme function. If you wish to override it, you
 *   should first look at how Zen core implements this function:
 *     theme_breadcrumbs()      in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called theme hook suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node--forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and theme hook suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440 and http://drupal.org/node/1089656
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function asb_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  asb_preprocess_html($variables, $hook);
  asb_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function asb_preprocess_html(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  //$variables['classes_array'] = array_diff($variables['classes_array'], array('class-to-remove'));
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function asb_preprocess_page(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */
function asb_preprocess_page(&$variables, $hook) {
  if ( isset( $variables['page']['content']['system_main']['#form_id'] ) && $variables['page']['content']['system_main']['#form_id'] == 'scheme_node_form') {
    if( $variables['page']['content']['system_main']['title']['#value'] ){
      $scheme_title = $variables['page']['content']['system_main']['title']['#value'];
      $step_description = $variables['page']['content']['system_main']['#steps']['step_add_title_and_description']->label;    
      $variables['full_title'] = $scheme_title . "&mdash;" . $step_description; 
    }else{
      $variables['full_title'] = t("Create a Scheme!");
    }
  }
}


function asb_local_tasks_alter(&$data, $router_item, $root_path) {
  // dsm($data);
  // dsm($router_item);
  // dsm($root_path);
  // Add a tab linking to node/add to all pages.
  $data['tabs'][0]['output'][] = array(
    '#theme' => 'menu_local_task',
    '#link' => array(
      'title' => t('Example tab'),
      'href' => 'node/add',
      'localized_options' => array(
        'attributes' => array(
          'title' => t('Add new content'),
        ),
      ),
    ),
    
    // Define whether this link is active. This can be omitted for
    // implementations that add links to pages outside of the current page
    // context.
    '#active' => ($router_item['path'] == $root_path),
  );
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function asb_preprocess_node(&$variables, $hook) {

  $variables['sample_variable'] = t('Lorem ipsum.');
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
  // dsm(block_get_blocks_by_region('sidebar_second'));
  if ($blocks = block_get_blocks_by_region('sidebar_second')) {
      $variables['sidebar_second'] = $blocks;
  }
  if ($blocks = block_get_blocks_by_region('highlighted')) {
      $variables['highlighted'] = $blocks;
  }
  $variables['action_links'] = menu_local_actions();
  $variables['feed_icons'] = drupal_get_feeds();
  $variables['tabs'] = menu_local_tabs();
  // dsm($variables['tabs']);
  if (!node_access('update', $variables['node'])) {
    $variables['edit_me'] = "";
  }else{
    $variables['edit_me'] = l(t('Edit'), 'node/'.$variables['nid'] .'/edit',
                            array('attributes' => array('class' =>'icon edit') ));
  }
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function asb_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function asb_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */

function asb_preprocess_block(&$variables, $hook) {
  if(strpos($variables['block']->delta, 'scheme_overview') !== false) {
    $variables['classes_array'][] = 'scheme-collection-view';
    $variables['theme_hook_suggestions'][] = 'block__views__scheme_overview';
  }
  // asb_scheme_check_block($variables);
  //dsm($variables);
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  //if ($variables['block_html_id'] == 'block-system-main') {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('block__no_wrapper'));
  //}
}

function asb_scheme_preprocess_views_view_field(&$vars) {
  // Get scheme owner for individual scheme displays
  if($vars['view']->name == 'scheme_overview') {
    foreach($vars['view']->result as $scheme) {
      // dsm(array_keys((array)$scheme));
      // dsm(array_keys((array)$vars['row']));

      $gid = $scheme->nid;
      $sql = "SELECT u.uid, name FROM users u 
              INNER JOIN og_membership ogm ON u.uid = ogm.etid 
              INNER JOIN og_users_roles our ON ogm.etid = our.uid 
              WHERE ogm.gid = '$gid'
              AND ogm.entity_type = 'user' 
              AND our.rid = 3 AND our.gid = '$gid'";

      $user_list = db_query($sql)->fetchAll();
      $vars['leader'][$gid] = array('name' => $user_list[0]->name, 
                              'uid' => $user_list[0]->uid);
    }

    if(isset($vars['row']->field_data_field_progress_field_progress_value)) {
      $progress = $vars['row']->field_data_field_progress_field_progress_value;
    }else{
      $progress = 0;
    }
    // generate markup for the leader
    $vars['leader_markup'] = '<div class="scheme-leader"><a href="/user/' .$vars['leader'][$gid]['uid'] .'">';
    $vars['leader_markup'] .= $vars['leader'][$gid]['name'] .'</a></div>';
    
    // dsm($vars['row']->field_field_location[0]['rendered']);
    $vars['location'] = $vars['row']->field_field_location[0]['rendered'];
    if(isset($vars['row']->field_field_issues_goals)) {

      // Here we add markup for completed scheme fans, people, issue ('.scheme-info).

      // dsm($vars['row']->field_field_issues_goals);
      $place_holder_fans = '1005';
      $place_holder_people = '69';

      $vars['completed'] = '<div class="scheme-info"><h4>About</h4><ul class="scheme-needs">';
      $vars['completed'] .= '<li class="sc-fans"><label>Fans:</label>' .$place_holder_fans .'</li>';
      $vars['completed'] .= '<li class="sc-people"><label>People:</label>' .$place_holder_people .'</li>';
      $vars['completed'] .= '<li class="sc-issue"><label>Issue:</label>' .$vars['row']->field_field_issues_goals[0]['rendered'] .'</li>';
      $vars['completed'] .= '</ul></div>';
      $vars['completed'] .= '<!-- Added in template.php preprocess_views_view_field() TODO: Replace place_holder_{fans,people} with real values -->';
    }
    // $vars['row']->field_body[0]['rendered'] = '<div class="scheme-collection-wrapper">' .$vars['row']->field_body[0]['rendered'] ."</div>";
    $progress_decimal = asb_scheme_val_to_dec($progress);
    $vars['progress'] = '<div class="progress-bar scheme-overview" data-progress="' .$progress_decimal[1]; 
    $vars['progress'] .= '"><div class="progress" style="width:'.$progress_decimal[0] .'%;background-color:red;">&nbsp;</div></div>';
    $vars['progress'] .= '<div class="scheme-major-ticks"><div class="scheme-minor-ticks"></div></div>';
    $vars['progress'] .= '<!-- Progress bar code built in template.php preprecess_views_view_field';
    $vars['progress'] .= ' variable used in views-view-field--scheme-overview.tpl.php -->';
    // foreach($vars['leader'] as $key
    //$vars['progress'] .= $vars['leader']
  }
}

function asb_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';
  $element['#localized_options']['html'] = TRUE;

  /* Even/odd class on menu items */
  static $count = 0;
  $zebra = ($count % 2) ? 'even' : 'odd';
  $count++;
  $element['#attributes']['class'][] = $zebra;
  
  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  /**
   * Add menu item's description below the menu title
   * Source: fusiondrupalthemes.com/forum/using-fusion/descriptions-under-main-menu
   */
  if ($element['#original_link']['menu_name'] == "main-menu" && isset($element['#localized_options']['attributes']['title'])){
    $element['#title'] = "<span class='title'>" . $element['#title'] . "</span>";
    $element['#title'] .= '<span class="description">' . $element['#localized_options']['attributes']['title'] . '</span>';
  }
  
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}


/**
 * Implements HOOK_page_alter
*/
function asb_util_page_alter(&$variables) {
  drupal_add_js('sites/all/themes/asb/js/script.js');
}
