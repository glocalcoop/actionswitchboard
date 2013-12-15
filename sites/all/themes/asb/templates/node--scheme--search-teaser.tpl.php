<?php
hide($content['field_issues_goals']);
hide($content['issues']);
hide($content['goals']);
hide($content['format_created']);
hide($content['group_group']);
hide($content['field_people_skills']);
hide($content['field_material_needs']);
hide($content['field_funding_needs']);
hide($content['field_leader']);
hide($content['field_location']);
hide($content['body']);
hide($content['field_progress']);
global $user;

?>
<?php print render($content['field_image']); ?>
<?php print render($content); ?>
<header class="scheme-header">
  <h3 class="scheme-name">
    <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
  </h3>
  <?php print render($content['field_leader']); ?>
  <?php print render($content['field_location']); ?>
</header>

<?php if($node->workflow != 5):?>
<div class="scheme-description">
<?php else:?>
<div class="scheme-description completed">
<?php endif;?>
  <?php print render($content['body']); ?>
</div>


<?php 
  // if not a completed scheme
  if($node->workflow != 5):
?>
<div class="field-issues-goals">
  <span class="sc-issue">Issue: </span><?php print render($content['issues']); ?>
</div>
<?php print render($content['field_progress']); ?>

<footer class="scheme-info active-scheme">
  <h4 class="scheme-needs">Needs</h4>
  <ul class="scheme-meta scheme-needs">
    <li class="needed-skills"><?php print render($content['field_people_skills']); ?></li>
    <li class="needed-supplies"><?php print render($content['field_material_needs']); ?></li>
    <li class="needed-funds"><?php print "$" .render($content['field_funding_needs']); ?></li>
  </ul>
</footer>

<?php
  // completed scheme
  else:
?>
<footer class="scheme-info completed-scheme">
  <h4 class="about-scheme">About</h4>
  <ul class="scheme-meta sc-complete">
    <li class="sc-fans"><label>Fans:</label><?php print $fans; ?> </li>
    <li class="sc-people"><label>People:</label><?php print $people_count; ?></li>
    <li class="sc-issue"><label>Issue:</label><div class="field-issues-goals"><?php print render($content['issues']); ?></div></li>
  </ul>
</footer>
<!-- Added in node--scheme--search-teaser.tpl.php TODO: Replace place_holder_{fans,people} with real values -->
<?php endif; ?>
