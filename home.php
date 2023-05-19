<!DOCTYPE html>
<?php
//starting the session
session_start();

$file = 'index.php';

if (isset($_POST['logout'])) {
	$_SESSION['user_data'] = null;
	$_SESSION['error'] = null;
}

if (!isset($_SESSION['user_data'])) {
	header('location:index.php');
}

$linkName = 'profile.php';

if (isset($_GET['profile'])) {
	$linkName = 'profile.php';
}

if (isset($_GET['elemzes'])) {
	$linkName = 'elemzes.php';
}

if (isset($_GET['chat'])) {
	$linkName = 'chat.php';
}

$user_name = '';

foreach ($_SESSION['user_data'] as $key => $value) {
    $user_name = $value['name'];
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
		<div class="w-full flex items-center justify-between">
			<div>
				<h3 class="text-primary">Hello <?php echo $user_name ?></h3>
			</div>
			<div>
				<form method="post">
					<input type="submit" name="logout" value="Logout" />
				</form>
			</div>
		</div>
		<hr style="border-top:1px dotted #ccc;" />
		<div class="row">
			<div class="col-md-4">
				<ul class="nav-link-ul">
					<li class="nav-link-li"><a href="home.php?profile=true" class="<?php if ($linkName === 'profile.php') {
																	echo 'active';
																} ?>">Profile</a></li>
					<li class="nav-link-li"><a href="home.php?elemzes=true" class="<?php if ($linkName === 'elemzes.php') {
																	echo 'active';
																} ?>">Elemzes</a></li>
					<li class="nav-link-li"><a href="home.php?chat=true" class="<?php if ($linkName === 'chat.php') {
																echo 'active';
															} ?>">Chat</a></li>
				</ul>
			</div>
			<div class="col-md-8 padding-right-none">
				<div>
					<?php include $linkName; ?>
				</div>
			</div>
		</div>



	</div>
</body>

</html>