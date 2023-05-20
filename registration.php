<!DOCTYPE html>
<?php
//starting the session
session_start();

$error = '';

if (isset($_SESSION['user_data'])) {
	header('location:home.php');
}

if (isset($_POST['register'])) {

	require_once('db/User.php');

	$user_object = new User;

	$user_object->setUserName($_POST['user_name']);

	$user_object->setUserEmail($_POST['user_email']);

	$user_object->setUserPassword($_POST['user_password']);

	$user_object->setUserBirthDate($_POST['user_birth_date'] ?? null);

	$user_object->setUserWebsite($_POST['user_website'] ?? null);

	$user_data = $user_object->get_user_data_by_email();

	if (is_array($user_data) && count($user_data) > 0) {
		$error = 'This Email Already Register';
	} else {
		if ($user_object->save_data()) {
			header('location:index.php');
		} else {
			$error = 'Something went wrong try again';
		}
	}
}
?>
<html lang="en">

<head>
	<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

<body>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">Registration</h3>
		<hr style="border-top:1px dotted #ccc;" />
		<!-- Link for redirecting to Login Page -->
		<a href="index.php">Already a member? Log in here...</a>
		<br style="clear:both;" /><br />
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<!-- Registration Form start -->
			<form method="POST">
				<div class="form-group">
					<label>Username</label>
					<input type="text" id="user_name" name="user_name" class="form-control" required />
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" id="user_password" name="user_password" class="form-control" pattern=".{8,}" required />
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" id="user_email" name="user_email" class="form-control" required />
				</div>
				<div class="form-group">
					<label>Birth day</label>
					<input type="date" id="user_birth_date" name="user_birth_date" min="1915-01-01" max="2015-12-31" />
				</div>
				<div class="form-group">
					<label>Website</label>
					<input type="url" id="user_website" name="user_website" class="form-control" />
				</div>
				<?php
				//checking if the session 'success' is set. Success session is the message that the credetials are successfully saved.
				if (isset($_SESSION['success'])) {
				?>
					<!-- Display registration success message -->
					<div class="alert alert-success"><?php echo $_SESSION['success'] ?></div>
				<?php
					//Unsetting the 'success' session after displaying the message. 
					unset($_SESSION['success']);
				}
				?>
				<button class="btn btn-primary btn-block" name="register" id="register" type="submit"><span class="glyphicon glyphicon-save"></span> Register</button>
			</form>
			<!-- Registration Form end -->
			<?php
			if ($error != '') {
				echo '
                    <div class="alert alert-danger">' . $error . '</div>';
			}
			?>
		</div>
	</div>
</body>

</html>