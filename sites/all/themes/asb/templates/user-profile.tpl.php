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
<header class="user-profile-header">

  <section class="user-title">
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
            echo " &raquo; ";
            print render($civi_contact['state_province_name']);
          }
          ?>
          <?php
          if (isset($civi_contact['state'])) {
            echo " &raquo; ";
            print render($civi_contact['state']);
          }
           ?>
        </div>
      </section>

      <section class="issues">
        <h6>Interests</h6>
        <ul class="tags">
          <?php print render($content['issues']); ?>
        </ul>
      </section>

      <section class="skills">
        <h6>Skills</h6>
        <ul class="tags">
        	<?php
        	foreach ($civi_contact['skills'] as $key => $value) {
        		echo '<li class="skill ' . $value . '">' . $value . '</li>';
        	}
        	?>
        </ul>
      </section>
  </aside> 

</header>

<section class="main-content">

  <aside class="user-details">
    <div "user-picture">
      <?php print render($user_profile['user_picture']); ?>
    </div>
    <ul class="user-contact">
      <li class="user-email ui-button">
        <a href="">{user-contact}</a>
      </li>
      <li class="user-facebook ui-button">
        <a href="">{user-facebook}</a>
      </li>
      <li class="user-twitter ui-button">
        <a href="">{user-twitter}</a>
      </li>
      <li class="user-linkedin ui-button">
        <a href="">{user-linkedin}</a>
      </li>
    </ul>
  </aside>

  <div class="user-bio">
    <h2>About Me</h2>
    {user-bio}
  </div>

</section>

<?php
// echo '<pre>';
// var_dump($civi_contact);
// echo '</pre>';

// echo '<pre>';
// var_dump($user_profile);
// echo '</pre>';
?>

