<?php
hide($content['field_issues_goals']);
hide($content['issues']);
hide($content['goals']);
hide($content['format_created']);
hide($content['group_group']);
hide($content['field_people_needs']);
hide($content['field_material_needs']);
hide($content['field_funding_needs']);
hide($content['field_leader']);
hide($content['field_location']);
hide($content['body']);
hide($content['field_progress']);
global $user;

?>
<?php print render($content['field_image']); ?>
<?php if ($title): ?>
  <h3 class="scheme-name">
    <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
  </h3>
<?php endif; ?>
<?php print render($content); ?>
<div class="scheme-description">
  <?php print render($content['field_leader']); ?>
  <?php print render($content['field_location']); ?>
  <?php print render($content['body']); ?>
</div>

<?php if($node->workflow != 5): ?>
<?php print render($content['field_progress']); ?>
<div class="scheme-info">
  <h4>Needs</h4>
  <ul class="scheme-needs">
    <li class="needed-skills"><?php print render($content['field_people_needs']); ?></li>
    <li class="needed-supplies"><?php print render($content['field_material_needs']); ?></li>
    <li class="needed-funds"><?php print "$" .render($content['field_funding_needs']); ?></li>
  </ul>
</div>
<?php else: ?>
<div class="scheme-info"><h4>About</h4>
  <ul class="scheme-needs sc-complete">
    <li class="sc-fans"><label>Fans:</label><?php print $fans; ?> </li>
    <li class="sc-people"><label>People:</label><?php print $people_count; ?></li>
    <li class="sc-issue"><label>Issue:</label><div class="field-issues-goals"><?php print render($content['issues']); ?></div></li>
  </ul>
</div>
<!-- Added in node--scheme--search-teaser.tpl.php TODO: Replace place_holder_{fans,people} with real values -->
<?php endif; ?>
