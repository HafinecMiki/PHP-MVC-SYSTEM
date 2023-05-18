<?php
	session_start();
	

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