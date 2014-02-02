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

  user-profile.tpl.php

  <header class="user-profile-header">

    <div class="wrapper">

      <section class="content">
        
        <section class="status-info">
          <h6>Schemer</h6>
        </section>
        <h1 class="title" id="page-title">
          <?php
          
          if ($civi_contact['first_name']) {
            print render($civi_contact['first_name']);
            print " ";
            print render($civi_contact['last_name']);
          } else {
            print render($account->name);
          }
          ?>
        </h1>
      </section>

      <aside class="user-meta">
          <section class="location">
            <h6>Where</h6>
            <div>
              <?php
              if ($civi_contact['country']) {
                print render($civi_contact['country']);
              }
              ?> 
              <?php
              if ($civi_contact['state_province_name']) {
                echo ", ";
                print render($civi_contact['state_province_name']);
              }
              ?>
              <?php
              if ($civi_contact['city']) {
                echo ", ";
                print render($civi_contact['city']);
              }
               ?>
            </div>
          </section>

          <section class="issues">
            <?php if ($user_profile['field_issue_reference']) { ?>
            <h6>Interests</h6>
            <ul class="tags">
              <?php print render($user_profile['field_issue_reference']); ?>
            </ul>
            <?php } ?>
          </section>

          <section class="skills">
            <?php if ($civi_contact['skills']) { ?>
            <h6>Skills</h6>
            <ul class="tags">
            	<?php
            	foreach ($civi_contact['skills'] as $skill) {
            		echo '<li class="skill ' . $skill . '">' . $skill . '</li>';
            	}
            	?>
            </ul>
          <?php } ?>
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
              <a class="icon user-contact" href="http://asb.mayfirst.org/messages/new/<?php print render($account->uid); ?>"><span>Contact Me</span></a>
            </li>
            <li class="facebook ui-button">
              <a class="icon facebook" href=""><span>Facebook</span></a>
            </li>
            <li class="twitter ui-button">
              <a class="icon twitter"  href=""><span>Twitter</span></a>
            </li>
            <!-- should we do linked in? does it make sense here? -->
            <li class="linkedin ui-button">
              <a class="icon linkedin" href=""><span>Linked In</span></a>
            </li>
          </ul>
        </aside>

        <div class="user-bio">
          <?php if (isset($user_profile['field_user_bio'])) { ?>
          <h2>About Me</h2>
          <?php print render($user_profile['field_user_bio']); ?>
          <?php } ?>
        </div>

    </div>

    </section>

  </div>

</article>

<?php

echo '<pre>';
var_dump($civi_contact);
echo '</pre>';

// echo '<pre>';
// var_dump($account);
// echo '</pre>';

// echo '<pre>';
// var_dump($user_profile);
// echo '</pre>';

?>

