<?php
/**
 * @file
 * 
 * $civi_contact array
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see zen_preprocess_node()
 * @see template_process()
 */
global $user;
$account = menu_get_object('user');
?>
<article class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <header class="page-header user-profile-header">

    <div class="wrapper">

      <section class="content">
        
        <section class="status-info">
          <h6>Schemer</h6>
        </section>
        <h1 class="title" id="page-title">
          <?php if ($civi_contact['first_name']): ?>
            <?php print render($civi_contact['first_name']); print " "; print render($civi_contact['last_name']); ?>
          <?php else: ?>
            <?php print render($account->name); ?>
          <?php endif; ?>
        </h1>
      </section>

      <aside class="user-meta">
          <section class="location">
            <h6>Where</h6>
            <div>
              <?php if ($civi_contact['country']): ?>
                <?php print render($civi_contact['country']); ?>
              <?php endif; ?>
              <?php if ($civi_contact['state_province_name']): ?>
                <?php echo ", "; print render($civi_contact['state_province_name']); ?>
              <?php endif; ?>
              <?php if ($civi_contact['city']): ?>
                <?php echo ", "; print render($civi_contact['city']); ?>
              <?php endif; ?>
            </div>
          </section>

          <section class="issues">
            <?php if (isset($user_profile['field_issue_reference'])): ?>
            <h6>Interests</h6>
            <ul class="tags">
              <?php print render($user_profile['field_issue_reference']); ?>
            </ul>
            <?php endif; ?>
          </section>

          <section class="skills">
            <?php if ($civi_contact['skills']): ?>
            <h6>Skills</h6>
            <ul class="tags">
            	<?php
            	foreach ($civi_contact['skills'] as $skill) {
            		echo '<li class="skill ' . $skill . '">' . $skill . '</li>';
            	}
            	?>
            </ul>
          <?php endif; ?>
          </section>
      </aside> 

    </div>

  </header>

  <div class="wrapper">
    <section class="main-content">

      <?php print render($tabs); ?>

      <div id="user-content" class="content">
        <aside class="user-details">
          <div class="user-picture">
            <?php print render($user_profile['user_picture']); ?>
          </div>
          <ul id="ui-button" class="user-contact">
            <li class="user-contact ui-button">
              <a class="icon user-contact" href="/messages/new/<?php print render($account->uid); ?>"><span>Contact Me</span></a>
            </li>
            <?php print render($user_profile['social_links']['twitter']); ?>
            <?php print render($user_profile['social_links']['facebook']); ?>
            <?php print render($user_profile['social_links']['linkedin']); ?>
            <!-- social_links can be modified in asb_scheme.module using the function
            asb_scheme_user_view() -->
            <?php if(isset($user_profile['flag_abuse_user'])): ?>
              <li class="report-user">
                <?php print render($user_profile['flag_abuse_user']); ?>
              </li>
            <?php endif; ?>
            <?php if(isset($user_profile['flag_abuse_whitelist_user'])): ?>
              <li class="whitelist-user">
                <?php print render($user_profile['flag_abuse_whitelist_user']); ?>
              </li>
            <?php endif; ?>
          </ul>
        </aside>

        <div class="user-bio">
          <?php if (isset($user_profile['field_user_bio'])): ?>
          <h2>About Me</h2>
          <?php print render($user_profile['field_user_bio']); ?>
          <?php endif; ?>
        </div>

    </div>

    </section>

  </div>

</article>

