 <?php
/**
 * @file
 * Zen theme's implementation to display a single Drupal page.
 */

?>

<?php if(arg(2) == ''): ?>
<div id="page">
  <header id="header" role="banner">

    <div class="content">
  
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

    </div>

  </header>

  <section id="main">
  
  <?php print $messages; ?>
  <?php print render($page['help']); ?>


    <?php print render($page['search']); ?>


    <div id="content">
      <?php /* print render($tabs); */ ?>
      <?php print render($page['content']); ?>

    </div><!-- /#content -->

  </section><!-- /#main -->

  <?php print render($page['footer']); ?>


</div>

<?php print render($page['bottom']); ?>

<?php else: ?>
<div id="page">
  <header id="header" role="banner">
    <div class="content">
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
              <h2 id="site-slogan">
              <?php print $site_slogan; ?>
              </h2>
            <?php endif; ?>
          </section><!-- /#name-and-slogan -->
        <?php endif; ?>
        <section id="navigation"> 
          <?php print render($page['header']); ?>
        </section><!-- /#navigation -->
      </div>
  </header>
  <section id="main">
  <?php print $messages; ?>
  <?php print render($page['help']); ?>
    <?php print render($page['search']); ?>
    <div id="content">
        <header class="edit-header page-header">
          <div class="wrapper page-wrapper clearfix">
            <section class="content page-content">
              <?php if (isset($highlighted)): ?>
                <?php print $page['highlighted']; ?>
              <?php endif; ?>
              <?php print render($title_prefix); ?>
              <?php if ($title): ?>
                <h1 class="page__title title" id="page-title"><?php print $title; ?></h1>
              <?php endif; ?>
              <?php print render($title_suffix); ?>
            </section>
          </div>
        </header>
        <div class="wrapper page-wrapper">
          <section class="main-content page-main-content">
            <?php if($page['sidebar_second'] || $page['sidebar_first']): ?>
               <section class="content page-content">
            <?php endif; ?>
           <?php if( isset( $updates_tabs ) ):?>
              <?php print $updates_tabs; ?>
            <?php endif;?>
                <?php print render($tabs); ?>
              <?php print render($page['content']); ?>
            <?php if($page['sidebar_second'] || $page['sidebar_first']): ?>
              </section>
            <?php endif; ?>
            <?php if($page['sidebar_second']): ?>
              <aside id="sidebar" class="page-sidebar">
                <?php
                  // Render the sidebars to see if there's anything in them.
                  print render($page['sidebar_second']);
                ?>
              </aside><!-- /.sidebars -->
            <?php endif; ?>

          </section>
        </div>
    </div><!-- /#content -->
  </section><!-- /#main -->
  <?php print render($page['footer']); ?>
</div>
<?php print render($page['bottom']); ?>

<?php endif; ?>
