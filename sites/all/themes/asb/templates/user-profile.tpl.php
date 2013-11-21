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
?>
<article class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <header class="user-profile-header">

    <div class="wrapper">

      <section class="content">
        <label>Schemer</label>
        <h1 class="title" id="page-title">
          <?php print render($civi_contact['first_name']); ?> <?php print render($civi_contact['last_name']); ?>
        </h1>
      </section>

      <aside class="user-meta">
          <section class="location">
            <h6>Where</h6>
            <div>
              <?php
              if (isset($civi_contact['country'])) {
                print render($civi_contact['country']);
              }
              ?> 
              <?php
              if (isset($civi_contact['state_province_name'])) {
                echo ", ";
                print render($civi_contact['state_province_name']);
              }
              ?>
              <?php
              if (isset($civi_contact['state'])) {
                echo ", ";
                print render($civi_contact['state']);
              }
               ?>
            </div>
          </section>

          <section class="issues">
            <?php if (isset($user_profile['field_issue_reference'])) { ?>
            <h6>Interests</h6>
            <ul class="tags">
              <?php print render($user_profile['field_issue_reference']); ?>
            </ul>
            <?php } ?>
          </section>

          <section class="skills">
            <?php if (isset($civi_contact['skills'])) { ?>
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
    <section class="content">

      <aside class="user-details">
        <div class="user-picture">
          <?php print render($user_profile['user_picture']); ?>
        </div>
        <ul id="ui-button" class="user-contact">
          <li class="user-contact ui-button">
            <a class="icon user-contact" href="">Contact Me</a>
          </li>
          <li class="facebook ui-button">
            <a class="icon facebook" href="">FB</a>
          </li>
          <li class="twitter ui-button">
            <a class="icon twitter"  href="">T</a>
          </li>
          <li class="linkedin ui-button">
            <a class="icon linkedin" href="">LI</a>
          </li>
        </ul>
      </aside>

      <div class="user-bio">
        <h2>About Me</h2>
        {user-bio}
      </div>

    </section>

  </div>

</article>

<?php
// echo '<pre>';
// var_dump($civi_contact);
// echo '</pre>';

// echo '<pre>';
// var_dump($user_profile);
// echo '</pre>';

?>

