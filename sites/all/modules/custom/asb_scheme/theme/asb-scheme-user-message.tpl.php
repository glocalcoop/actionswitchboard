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

	<div class="userdashboard"><a href="/dashboard/"><span class="icon tools dashboard-link"></span>Dashboard</a>
		<span class="counter badge"><a href="/dashboard/">12</a><!-- Placeholder number - replace with actual number of new messages --></span>
	</div>

	<div class="logout"><a class="logout-link" href="<?php print url('user/logout'); ?>">Logout</a></div>
  <?php else:?>
    <div class="login login-normal"><a class="login-link ctools-use-modal" style="display:inherit" href="<?php print url('user'); ?>">Login</a></div>
    <div class="login login-modal" style="display:none;">
      <a class="login-link ctools-use-modal ctools-modal-modal-popup-small" style="display:inherit" href="/modal_forms/nojs/login">Login</a>
    </div>
    or
    <div class="register">
      <a class="register-link" href="<?php print url('user/register'); ?>">Register</a>
    </div>
  <?php endif;?>

</nav>
