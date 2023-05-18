<!DOCTYPE html>
<?php 
//starting the session
session_start();

if(isset($_SESSION['user_data']))
{
    header('location:home.php');
}

?>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	</head>
<body>
	<div class="col-md-3"></div>
    <!--<p><?php echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';?></p>-->
	<div class="col-md-6 well">
		<h3 class="text-primary">Login</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<!-- Link for redirecting page to Registration page -->
		<a href="index.php">Not a member yet? Register here...</a>
		<br style="clear:both;"/><br />
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<!-- Login Form Starts -->
			<form method="POST" action="login_query.php">	
				<div class="form-group">
					<label>Email</label>
					<input type="text" name="user_email" class="form-control" required="required"/>
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="user_password" class="form-control" required="required"/>
				</div>
				<?php
					//checking if the session 'error' is set. Erro session is the message if the 'Username' and 'Password' is not valid.
					if(ISSET($_SESSION['error'])){
				?>
				<!-- Display Login Error message -->
					<div class="alert alert-danger"><?php echo $_SESSION['error']?></div>
				<?php
					//Unsetting the 'error' session after displaying the message. 
					//session_unset($_SESSION['error']);
					}
				?>
				<button class="btn btn-primary btn-block" name="login"><span class="glyphicon glyphicon-log-in"></span> Login</button>
			</form>	
			<!-- Login Form Ends -->
		</div>
	</div>
</body>
</html>