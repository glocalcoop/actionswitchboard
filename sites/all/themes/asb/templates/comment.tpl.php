<?php
/**
 * @file
 * Returns the HTML for comments.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728216
 */
// dsm($content);
if(isset($content['comment_body']['#object']->ajax_header)) {
  print $content['comment_body']['#object']->ajax_header;
}
?>

<article class="<?php if($new) { echo 'new'; } ?> <?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php print $picture; ?>
  <div class="comment-content">
    <header>
      <p class="submitted">
        <?php print $submitted; ?>
        <?php print $permalink; ?>
      </p>

      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h3<?php print $title_attributes; ?>>
          <?php print $title; ?>
          <?php if ($new): ?>
            <mark class="new"><span><?php print $new; ?></span></mark>
          <?php endif; ?>
        </h3>
      <?php elseif ($new): ?>
        <mark class="new"><span><?php print $new; ?></span></mark>
      <?php endif; ?>
      <?php print render($title_suffix); ?>

      <?php if ($status == 'comment-unpublished'): ?>
        <mark class="unpublished"><span><?php print t('Unpublished'); ?></span></mark>
      <?php endif; ?>
    </header>

    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['links']);
      print render($content);
    ?>
  </div>

  <?php if ($signature): ?>
    <footer class="user-signature clearfix">
      <?php print $signature; ?>
    </footer>
  <?php endif; ?>
  <?php print render($content['links']); ?>
</article>
