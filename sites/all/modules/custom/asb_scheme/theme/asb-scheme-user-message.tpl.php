<?php
/**
 * @file
 * Implements the block display for users.
 */
?>
<nav id="asb-scheme-user-message" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if($logged_in): global $user;?>
	<div class="title">Hello,</div>
	<div class="username"><a href="<?php print url('user'); ?>"><?php print $user->name;?></a></div>
	<div class="logout"><a class="logout" href="<?php print url('user/logout'); ?>">Logout</a></div>
	<div class="userdashboard"><a href="/dashboard/"><span class="icon tools dashboard"></span>Dashboard</a>
		<span class="counter badge"><a href="/dashboard/">12</a><!-- Placeholder number - replace with actual number of new messages --></span>
	</div>
  <?php else:?>
    <div class="login"><a class="login" href="<?php print url('user'); ?>">Login</a></div>
    or<br/>
    <div class="register"><a class="register" href="<?php print url('user/register'); ?>">Register</a></div>

  <?php endif;?>

</nav>
