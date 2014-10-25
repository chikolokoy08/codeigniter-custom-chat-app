<form class="form-signin class-forms" role="form" method="post" action="<?php echo site_url('login/auth'); ?>">
	<h2 class="form-signin-heading">Please sign in</h2>
		<input type="email" name="email" class="form-control required" placeholder="Email address">
		<input type="password" name="password" class="form-control required" placeholder="Password">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	<a href="<?php echo site_url('login/signup'); ?>" class="btn btn-default btn-block btn-lg">Create Account</a>
</form>
