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
// function asb_preprocess_html(&$variables, $hook) {
// }

/**
 * Override or insert variables into the user_profile templates.
 *
 * @param $variables
 *  An array of variables to pass to the theme template.
 */
function asb_preprocess_user_profile(&$variables) {
  $civi_contact = asb_scheme_civicrm_api('contact', arg(1));
  $variables['civi_contact'] = $civi_contact['values'][0];
  $variables['civi_contact']['skills'] = $civi_contact['skills'];
  $variables['tabs'] = menu_local_tabs();
}

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

  $variables['global_donate'] = '<div id="donate-positioning-wrapper"><a href="http://yeslab.org/donate-to-asb" id="global-donate" title="Help keep the action switchboard running!">Donate</a></div>';

  if(arg(2) == 'edit' && isset($variables['node'])) {
    /* $suggests = &$variables['theme_hook_suggestions']; */
    /* $args = array(); */
    $edit = "page__edit_{$variables['node']->type}";
    // $edit = "page__edit";
    $variables['theme_hook_suggestion'] = $edit;
    /* $suggests = array_merge( */
    /*   $suggests, */
    /*   array($edit), */
    /*   theme_get_suggestions($args, $edit) */
    /* ); */
  }
  if (isset($variables['node'])) {
    // Ref suggestions cuz it's stupid long.
    $suggests = &$variables['theme_hook_suggestions'];

    // Get path arguments.
    $args = arg();
    // Remove first argument of "node".
    unset($args[0]);

    // Set type.
    $type = "page__type_{$variables['node']->type}";

    // Bring it all together.
    $suggests = array_merge(
      $suggests,
      array($type),
      theme_get_suggestions($args, $type)
    );

    // if the url is: 'http://domain.com/node/123/edit'
    // and node type is 'blog'..
    //
    // This will be the suggestions:
    //
    // - page__node
    // - page__node__%
    // - page__node__123
    // - page__node__edit
    // - page__type_blog
    // - page__type_blog__%
    // - page__type_blog__123
    // - page__type_blog__edit
    //
    // Which connects to these templates:
    //
    // - page--node.tpl.php
    // - page--node--%.tpl.php
    // - page--node--123.tpl.php
    // - page--node--edit.tpl.php
    // - page--type-blog.tpl.php          << this is what you want.
    // - page--type-blog--%.tpl.php
    // - page--type-blog--123.tpl.php
    // - page--type-blog--edit.tpl.php
    //
    // Latter items take precedence.

    if($variables['node']->type == 'issue') {
      // dsm($variables);
      // dsm($variables['node']);
      if(isset($variables['page']['content']['system_main']['nodes'])) {
        foreach($variables['page']['content']['system_main']['nodes'] as $key => $value) {
          if(is_numeric($key)) {
            $variables['node_classes'] = 'view-mode-' .$variables['page']['content']['system_main']['nodes'][$key]['#view_mode'];
          }
        }
        $variables['node_classes'] .= ' node ' .'node-' .$variables['node']->type;
      }else{
        $variables['node_classes'] = 'node node-edit';
      }
    }

  }

  // add updates tab
  if(arg(0) == 'scheme' && arg(2) == 'updates') {
    $scheme_id = arg(1);
    $variables['updates_tabs'] = "<ul id='updates-tabs' class=' tabs-primary tabs primary'><li class='scheme'><a href='/node/${scheme_id}'>Scheme</a></li><li class='members'><a href='/node/${scheme_id}/members'>Members</a></li><li class='active update-tab'><a href='#'>Updates</a></li></ul>";
  }

  if(arg(2) != 'edit') {
    if(isset($variables['page']['content']['system_main']['#form_id'] ) && $variables['page']['content']['system_main']['#form_id'] == 'scheme_node_form') {
      if( $variables['page']['content']['system_main']['title']['#value'] ){
        $scheme_title = $variables['page']['content']['system_main']['title']['#value'];
        $step_description = $variables['page']['content']['system_main']['#steps']['step_add_title_and_description']->label;
        $variables['full_title'] = $scheme_title . "&mdash;" . $step_description;
      }else{
        $variables['full_title'] = t("Create a Scheme!");
      }
    }
  }
}


function asb_menu_local_tasks(&$variables) {
  $output = '';

  // Add theme hook suggestions for tab type.
  foreach (array('primary', 'secondary') as $type) {
    if (!empty($variables[$type])) {
      foreach (array_keys($variables[$type]) as $key) {
        if (isset($variables[$type][$key]['#theme']) && ($variables[$type][$key]['#theme'] == 'menu_local_task' || is_array($variables[$type][$key]['#theme']) && in_array('menu_local_task', $variables[$type][$key]['#theme']))) {
          $variables[$type][$key]['#theme'] = array('menu_local_task__' . $type, 'menu_local_task');
        }
      }
    }
  }

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs-primary tabs primary">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs-secondary tabs secondary">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
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
  global $user;
  // dsm($variables);
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
  // dsm(block_get_blocks_by_region('sidebar_second'));
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
  if($variables['view_mode'] != 'full') {
    unset($variables['tabs']);
  }
  if($variables['type'] == 'scheme') {
    $account = clone $user;
    $variables['join_link'] = 'asb-modal/group/node/' .$variables['nid'] .'/subscribe/og_user_node/nojs/join';
    if(isset($variables['elements']['group_group'][0]['#href'])) {
      if(strpos($variables['elements']['group_group'][0]['#href'], 'unsubscribe') === false) {
        $variables['member'] = 'request';
      }
      if(strpos($variables['elements']['group_group'][0]['#href'], 'unsubscribe') === true) {
        $variables['member'] = 'current';
      }
      if($variables['node']->workflow_state_name == 'Completed') {
        $variables['member'] = 'complete';
      }
    }
    if (node_access("update", $variables['node'], $account) === TRUE) {
      $variables['classes_array'][] = 'edit';
      $variables['issue_edit'] = '<a class="ctools-use-modal ctools-modal-mfe-modal" href="/mfe-single-modal-callback/nojs/' .arg(1) .'/scheme/field_issues_goals">Edit</a>';
      // This javascript is added in asb_scheme module, but was not
      // recognized by chromium on modal edit.
      // Adding it here resolves that problem.
      // drupal_add_js(drupal_get_path('module', 'asb_scheme') . '/js/scheme-issues.js', 'file');
    }
  }
}

function asb_preprocess_node_scheme(&$variables, $hook) {
  // Here we call context to control what blocks appear
  // in the sidebar.  Then we merge the standard block
  // callback to make sure all theming remains consistent
  if($variables['view_mode'] == 'full') {
    if($plugin = context_get_plugin('reaction', 'block')) {
      $blocks = block_get_blocks_by_region('sidebar_second');
      $variables['sidebar_second'] = array_merge($plugin->block_get_blocks_by_region('sidebar_second'), $blocks);
      drupal_static_reset('context_reaction_block_list');
    }
    // Here we set up a view for inclusion in the scheme-node template.
    // First we execute the view with the entity reference from
    // the node object.
    $view = views_get_view('scheme_overview_filtered');
    $view->set_display('block_6');
    if(isset($variables['node']->field_issues_goals['und'][0]['target_id'])) {
      $a = $variables['node']->field_issues_goals['und'][0]['target_id'];
      $view->set_arguments(array($a));
      $view->execute();
    }
    // Make sure the view has content.  We create a boolean
    // variable to validate against in the template and generate
    // the view to be passed to the template.
    if (count($view->result) > 0) {
      $variables['show_related'] = true;
      $variables['related_view'] = $view->preview('block_6',array($a));
    }else{
      $variables['show_related'] = false;
    }
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
/*
function asb_preprocess_comment(&$variables, $hook) {
  // dsm($variables);
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
  if($variables['block']->delta == '467d272784c6e1a84b15cc4f6b486792') {
    /* dsm($variables); */
    /* dsm($variables['block']->delta); */
    /* dsm($variables['classes_array']); */
  }
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

function asb_scheme_preprocess_views_view(&$vars) {
  if($vars['view']->name == 'scheme_overview_filtered') {
    // dsm($vars['view']);
  }
}

function asb_preprocess_views_view_field(&$vars) {
  // Allow field specific views processing
  // @see http://drupal.org/node/939462#comment-4476264
  if (isset($vars['view']->name)) {
    $function = 'asb_preprocess_views_view_field__' . $vars['view']->name . '__' . $vars['view']->current_display;

    if (function_exists($function)) {
      $function($vars);
      // we can return to only use the specific preprocess function (it matters if there are more codes below in this function)...
      return;
    }
  }
  // Get scheme owner for individual scheme displays
  // dsm($vars['field']->field);
  if($vars['view']->name == 'scheme_members_modals') {
    $vars['view']->remove_og_user = array();
    // Get user id from view results and ad remove button
    if($vars['field']->field_alias == 'civicrm_value_skills_1_skills_1') {
      foreach($vars['view']->result as $key => $value) {
        if($key == $vars['view']->row_index) {
          $gid = $vars['view']->args[0];
          $uid = $value->uid;
          $vars['view']->field['skills_1']->remove_button = asb_modal_remove_user($gid, $uid);
        }
      }
    }
    // dsm($vars['view']->field['skills_1']);
  }
  if($vars['view']->name == 'scheme_overview') {
    foreach($vars['view']->result as $scheme) {
      // dsm(array_keys((array)$scheme));
      // dsm(array_keys((array)$vars['row']));
      if($vars['field']->field == 'title') {
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
        $vars['leader_markup'] = '<div class="scheme-leader"><a href="/user/' .$vars['leader'][$gid]['uid'] .'">';
        $vars['leader_markup'] .= $vars['leader'][$gid]['name'] .'</a></div>';
        // dsm($vars['leader_markup']);
      }
    }
    // dsm($vars['leader']);
    if(isset($vars['row']->field_data_field_progress_field_progress_value)) {
      $progress = $vars['row']->field_data_field_progress_field_progress_value;
    }else{
      $progress = 0;
    }
    // generate markup for the leader
    // dsm($vars['field']->field);
    if($vars['field']->field == 'title') {
      $vars['leader_markup'] = '<div class="scheme-leader"><a href="/user/' .$vars['leader'][$gid]['uid'] .'">';
      $vars['leader_markup'] .= $vars['leader'][$gid]['name'] .'</a></div>';
      // dsm($vars['leader_markup']);
    }
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

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  /**
   * Add menu item's description below the menu title
   * Source: fusiondrupalthemes.com/forum/using-fusion/descriptions-under-main-menu
   */

  if (
    $element['#original_link']['menu_name'] == "main-menu" ||
    $element['#original_link']['menu_name'] == "menu-social-links" &&
    isset($element['#localized_options']['attributes']['title'])
  ){

    $titleSlug = 'nav-' . drupal_html_id($element['#title']);
    $element['#attributes']['id'] = $titleSlug;

    if( $titleSlug == "nav-join-newsletter" || $titleSlug == "nav-twitter" || $titleSlug == "nav-facebook") {
      $element['#attributes']['id'] = $titleSlug;
      $element['#title'] = "<span class=\"icon mail\"></span><div class='title'>" . $element['#localized_options']['attributes']['title'] . "</div>";
    } else {
      $element['#title'] = "<div class='title'>" . $element['#title'] . "</div>";
      $element['#title'] .= '<div class="description">' . $element['#localized_options']['attributes']['title'] . '</div>';
    }

  }

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";

}

function asb_views_post_render(&$view) {
  // dpm( $view->name );
  // dpm( $view->current_display );
  if( ( $view->name == 'scheme_overview' || $view->name == 'scheme_overview_filtered' )  && ($view->current_display == 'block_1' || $view->current_display == "page_1") ){
    //load this stuff before chosen
  }
}

function asb_js_alter( &$page ){
  $scripts = drupal_add_js();
  $chosen_path = drupal_get_path('module', 'chosen');
  $asb_theme_path = drupal_get_path('theme', 'asb');

  // remove chosen, we need it to come in after our js,
  // (which builds out some progressive enhancement form elements)
  unset( $scripts['sites/all/libraries/chosen/chosen.jquery.min.js'] );
  unset( $scripts[$chosen_path .'/chosen.js'] );
  // add our modified infite scroll
  // (we remove the original in the asb_scheme module asb_scheme_js_alter)
  drupal_add_js( $asb_theme_path . '/js/alter_infinitescroll.js' );
  // add our theme script (which builds out the infinite scroll pager)
  drupal_add_js( $asb_theme_path . '/js/scripts.js' );
  // then we load chosen back in
  drupal_add_js(libraries_get_path('chosen') . '/chosen.jquery.min.js');
  // drupal_add_js( "sites/all/libraries/chosen/chosen.jquery.min.js" );
  drupal_add_js( $chosen_path .'/chosen.js' );
  // and clamp.js
  drupal_add_js( $asb_theme_path .'/js/clamp.js' );
  // and autopager.js
  drupal_add_js(libraries_get_path('autopager') . '/jquery.autopager-1.0.0.js');
}

function asb_preprocess_region(&$variables, $hook) {
  // Add hidden class to search region if not schemes page
  // dsm($variables);
  if(arg(0) != 'schemes') {
    if ($variables['region'] == "search") {
      $variables['classes_array'][] = 'hidden';
    }
  }
}

function asb_date_combo_alter(&$variables) {
  // dsm($variables);
  $variables['element']['value2']['#title'] = 'Finish';
  $element = $variables['element'];
  $element['value2']['date']['#description'] = '(MM/DD/YYYY)';
  $field = field_info_field($element['#field_name']);
  $instance = field_info_instance($element['#entity_type'], $element['#field_name'], $element['#bundle']);

  // Group start/end items together in fieldset.
  $fieldset = array(
    '#title' => t($element['#title']) . ' ' . ($element['#delta'] > 0 ? intval($element['#delta'] + 1) : ''),
    '#value' => '',
    '#description' => !empty($element['#fieldset_description']) ? $element['#fieldset_description'] : '',
    '#attributes' => array(),
    '#children' => $element['#children'],
  );
  // dsm($element);
  return theme('fieldset', array('element' => $fieldset));
}
