 <?php
/**
 * @file
 * Zen theme's implementation to display a single Drupal page.

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
      <?php if(arg(0) == 'user' && arg(2) == 'edit'): ?>
        <?php print render($tabs); ?>
      <?php endif; ?>
      <?php print render($page['content']); ?>

    </div><!-- /#content -->

  </section><!-- /#main -->

  <?php print render($page['footer']); ?>


</div>

<?php print render($page['bottom']); ?>


