<?php
/**
 * @file
 * Zen theme's implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   - view-mode-[mode]: The view mode, e.g. 'full', 'teaser'...
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 *   The following applies only to viewers who are registered users:
 *   - node-by-viewer: Node is authored by the user currently viewing the page.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $pubdate: Formatted date and time for when the node was published wrapped
 *   in a HTML5 time element.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content. Currently broken; see http://drupal.org/node/823380
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see zen_preprocess_node()
 * @see template_process()
 */
hide($content['field_issues_goals']);
hide($content['issues']);
hide($content['goals']);
hide($content['format_created']);
hide($content['group_group']);
hide($content['field_private_description']);
hide($content['flag_subscribe_og']);
global $user;
?>
<article class="node-<?php print $node->nid; ?> <?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <header class="page-header">
    <div class="wrapper clearfix">
      <section class="content">
        <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
        <?php if (isset($highlighted)): ?>
          <?php print render($highlighted); ?>
        <?php endif; ?>
        <?php //print $breadcrumb; ?>
        <?php print render($title_prefix); ?>
        <section class="status-info">
          <h6>Status:</h6>
          <span class="state"><?php print $node->workflow_state_name; ?></span>
        </section>
        <section class="methods">
          <ul id="ui-button">
            <?php $account = user_load($user->uid); ?>
            <?php if ($account->uid != 0): ?>
              <li class="ui-button"><?php print render($content['flag_subscribe_og']); ?></li>
              <!-- <li class="ui-button"><a class="ui-button" href="/new-feature-coming-soon">Follow Scheme</a></li> -->
              <li class="ui-button">
                <?php if(isset($member) && $member == 'request'): ?>
                  <div class="field-group-group">
                    <?php print ctools_modal_text_button('Request Membership', $join_link, t('Request Membership'), 'ctools-use_modal ctools-modal-asb-scheme-modal'); ?>
                <?php elseif(!isset($member) || $member == 'current'): ?>
                  <?php print render($content['group_group']); ?>
                <?php endif; ?>
              </li>
            <?php else: ?>
              <li class="ui-button"><a class="login-link ctools-use-modal ctools-modal-modal-popup-small" href="/modal_forms/nojs/login">Login To Join Scheme</a></li>
            <?php endif; ?>
        </section>
        <?php if ($title): ?>
          <h1 class="title" id="page-title"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
        <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
        <?php print $feed_icons; ?>
        <?php endif; ?>
      </section>
      <aside class="scheme-meta">
        <?php if(isset($issue_edit)): ?>
          <div class="modal-edit">
            <?php print $issue_edit; ?>
          </div>
        <?php endif; ?>
        <section class="created">
          <h6>Created</h6>
          <time><?php print render($content['format_created']); ?></time>
        </section>
        <section class="issues">
          <h6>Issue</h6>
          <ul class="tags">
            <?php print render($content['issues']); ?>
          </ul>
        </section>
        <section class="goals">
          <h6>Goals</h6>
          <ul class="tags">
            <?php print render($content['goals']); ?>
          </ul>
        </section>
      </aside>
    </div>
  </header>
  <div class="wrapper">
      <?php print render($tabs); ?>
    <section class='content'>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        print '<div id="scheme-content">';
        print render($content);
        $account = clone $user;
        // Show private description for group memebers and facilitator.
        if(og_is_member('node',$node->nid,'user',$account) == true) {
          print render($content['field_private_description']);
        }elseif(isset($user->roles[6]) || isset($user->roles[3])) {
        /* isset($node->field_facilitator['und']) && $node->field_facilitator['und'][0]['target_id'] == $user->uid */
        print render($content['field_private_description']);
        }
        print '</div>';
      ?>
      <?php print render($content['links']); ?>

        <section class="related-schemes">
            <?php if($show_related): ?>
              <h2 class="block__title block-title related-title">Related Schemes</h2>
              <?php print $related_view; ?>
            <?php endif; ?>
        </section>


        <div class="comments-wrapper">
          <?php print render($content['comments']); ?>
        </div>


    </section>
    <?php if($sidebar_second): ?>
      <aside id="sidebar">
        <?php
          // Render the sidebars to see if there's anything in them.
          print render($sidebar_second);
        ?>
      </aside><!-- /.sidebars -->
      <?php endif; ?>

  </div>
</article><!-- /.node -->
