<form class="form-signin class-forms" role="form" method="post" action="<?php echo site_url('login/register'); ?>">
		<h2 class="form-signin-heading">Create an Account</h2>
		<input type="email" name="email" class="form-control required" placeholder="Email address">
		<input type="text" name="firstname" class="form-control required" placeholder="John">
		<input type="text" name="lastname" class="form-control required" placeholder="Doe">
		<input type="password" name="password" class="form-control required" placeholder="Password">
		<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
		<a href="<?php echo site_url('/'); ?>" class="btn btn-default btn-block btn-lg">Back to Login</a>
</form>
