<?php
	layout('layout.header');
?>

<div class="container">
	<div class="register-form">
		<form action="<?= url('user/add') ?>" method="POST" class="ajax-form" data-redirect="<?= url('/') ?>">
			<div class="row m-0">
				<div class="col-sm-12 form-group text-center">
					<h2 class="form-title">Sign Up</h2>
				</div>

				<!-- Error Message -->
				<div class="col-sm-12">
					<div class="alert alert-danger ajax-errors">
						<b><i class="fas fa-times-circle"></i> ERROR !!</b>
						<ul></ul>
					</div>
				</div>
				<!-- Error Message -->

				<div class="col-sm-12 form-group">
					<input type="text" class="form-control" name="username" placeholder="Username" />
				</div>
				<div class="col-sm-12 form-group">
					<input type="email" class="form-control" name="email" placeholder="Email" />
				</div>
				<div class="col-sm-12 form-group">
					<input type="password" class="form-control" name="password" placeholder="Password" />
				</div>
				<div class="col-sm-12 form-group">
					<input type="password" class="form-control" name="password_confirm" placeholder="Re-enter Password" />
				</div>
				<div class="col-sm-12 form-group">
					<small>
						Please access our Privacy Policy to learn what personal data collects and your choices about how it is used. All users of our service are also subject to our Terms of Service.
					</small>
				</div>
				<div class="col-sm-12 form-group">
					<button type="submit" class="btn btn-primary btn-block">Register</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php
	layout('layout.footer');
?>