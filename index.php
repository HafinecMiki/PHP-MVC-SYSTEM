<!DOCTYPE html>
<?php 
//starting the session
session_start();

if(isset($_SESSION['user_data']))
{
    header('location:home.php');
}

if(isset($_POST['login']))
{
    require_once('db/User.php');

    $user_object = new User;

    $user_object->setUserEmail($_POST['user_email']);

    $user_data = $user_object->get_user_data_by_email();

    if($user_data['user_password'] == $_POST['user_password'])
    {
        $user_object->setUserId($user_data['user_id']);

        $user_token = md5(uniqid());

        $user_object->setUserToken($user_token);

        if($user_object->update_user_login_data())
        {
            $_SESSION['user_data'][$user_data['user_id']] = [
            	'id'    =>  $user_data['user_id'],
                'name'  =>  $user_data['user_name'],
                'token' =>  $user_token
            ];

            header('location:home.php');

            }
        }
         else
        {
			$_SESSION['error'] = "Wrong Password";
			header('location:index.php');
        }
    
}

?>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	</head>
<body>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">Login</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<!-- Link for redirecting page to Registration page -->
		<a href="registration.php">Not a member yet? Register here...</a>
		<br style="clear:both;"/><br />
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<!-- Login Form Starts -->
			<form method="POST">	
				<div class="form-group">
					<label>Email</label>
					<input type="text" name="user_email" class="form-control" required="required"/>
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="user_password" class="form-control" required="required"/>
				</div>
				<?php
					if(ISSET($_SESSION['error'])){
				?>
				<!-- Display Login Error message -->
					<div class="alert alert-danger"><?php echo $_SESSION['error']?></div>
				<?php
					}
				?>
				<button class="btn btn-primary btn-block" name="login" type="submit"><span class="glyphicon glyphicon-log-in"></span> Login</button>
			</form>	
			<!-- Login Form Ends -->
		</div>
	</div>
</body>
</html>