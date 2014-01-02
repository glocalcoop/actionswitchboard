<?php
/**
 * @file
 * Implements the block display for users.
 */
?>
<nav id="asb-scheme-user-message" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if($logged_in): global $user;?>
    <span class="title">Hello,</span>
    <span class="username"><a href="<?php print url('user'); ?>"><?php print $user->name;?></a></span>
    <a class="logout" href="<?php print url('user/logout'); ?>">Logout</a>
  <?php else:?>
    <a class="login" href="<?php print url('user'); ?>">Login</a>
    or<br/>
    <a class="register" href="<?php print url('user/register'); ?>">Register</a>

  <?php endif;?>

</nav>
