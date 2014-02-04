<?php
/**
 * @file
 * Implements the block display for users.
 */
global $user;
?>
<nav id="asb-scheme-user-message" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if($logged_in): ?>
	<div class="title">Hello,</div>
	<div class="username"><a href="/user"><?php print $user->name;?></a></div>

	<div class="userdashboard"><a href="/dashboard/"><span class="icon tools dashboard-link"></span>Dashboard</a>
    <?php if($messages != "0" ): ?>
      <span class="counter badge"><a href="/dashboard/"><?php print $messages; ?></a></span>
      <!-- Rendered in module asb_scheme/theme -->
    <?php endif;?>
	</div>

	<div class="logout"><a class="logout-link" href="/user/logout">Logout</a></div>
  <?php endif; ?>

  <?php if(!$logged_in): ?>
    <div class="login login-normal"><a class="login-link ctools-use-modal" style="display:inherit" href="/user">Login</a></div>
    <div class="login login-modal" style="display:none;">
      <a class="login-link ctools-use-modal ctools-modal-modal-popup-small" style="display:inherit" href="/modal_forms/nojs/login">Login</a>
    </div>
    or
    <div class="register">
      <a class="register-link" href="/user/register">Register</a>
    </div>
  <?php endif;?>
 
</nav>
