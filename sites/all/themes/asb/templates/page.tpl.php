 <?php
/**
 * @file
 * Zen theme's implementation to display a single Drupal page.
 *
 */
?>


<div id="page">

  <header id="header" role="banner">

    <?php if ($logo): ?>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
    <?php endif; ?>

    <?php if ($site_name || $site_slogan): ?>
      <section id="name-and-slogan">
        <?php if ($site_name): ?>
          <h1 id="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
          </h1>
        <?php endif; ?>

        <?php if ($site_slogan): ?>
          <h2 id="site-slogan"><?php print $site_slogan; ?></h2>
        <?php endif; ?>
      </section><!-- /#name-and-slogan -->

    <?php endif; ?>

    <section id="navigation"> 
      <?php print render($page['header']); ?>
    </section><!-- /#navigation -->

  </header>

  <section id="main">
  
  <?php print $messages; ?>
  <?php print render($page['help']); ?>

    <?php print render($page['search']); ?>

    <div id="content">

      <article class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

        <header class="edit-header">

          <div class="wrapper">

            <section class="content">
              <?php print render($title_prefix); ?>
              <?php if ($title): ?>
                <h1 class="page__title title" id="page-title"><?php print $title; ?></h1>
              <?php endif; ?>
              <?php print render($title_suffix); ?>
              <?php print $messages; ?>
            </section>

          </div>

        </header>

        <div class="wrapper">

          <section class="main-content">

          <?php if(arg(0) == 'user' && arg(2) == 'edit'): ?>
            <?php print render($tabs); ?>
          <?php endif; ?>
          <?php print render($page['content']); ?>

          </section>

        </div>

      </article>

    </div><!-- /#content -->
    
  </section><!-- /#main -->

  <?php print render($page['footer']); ?>

</div>

<?php print render($page['bottom']); ?>

