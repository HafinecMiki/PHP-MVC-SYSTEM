<!DOCTYPE html>
<?php
require('db/User.php');

$user_object = new User;

$user_id = '';

foreach ($_SESSION['user_data'] as $key => $value) {
    $user_id = $value['id'];
}

$user_object->setUserId($user_id);

$user_data = $user_object->get_user_data_by_id();

$today = date("Y-m-d");
$diff = date_diff(date_create($user_data['user_birth_date']), date_create($today));

$message = '';

if (isset($_POST['edit'])) {
    $user_object->setUserName($_POST['user_name']);

    $user_object->setUserEmail($_POST['user_email']);

    $user_object->setUserPassword($_POST['user_password']);

    $user_object->setUserBirthDate($_POST['user_birth_date']);

    $user_object->setUserId($user_id);

    if ($user_object->update_data()) {
        $message = '<div class="alert alert-success">Profile Details Updated</div>';
        $user_data = $user_object->get_user_data_by_id();

        $today = date("Y-m-d");
        $diff = date_diff(date_create($user_data['user_birth_date']), date_create($today));
    } else {
        $message = '<div class="alert alert-danger">Profile Details Not Updated</div>';
    }
}


?>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

<body>
    <div class="">
        <h3 class="text-primary">Profile</h3>
        <hr style="border-top:1px dotted #ccc;" />

        <div class="card-body">
            <form method="post" id="profile_form" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="user_name" id="user_name" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required value="<?php echo $user_data['user_name']; ?>" />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="user_email" id="user_email" class="form-control" data-parsley-type="email" required value="<?php echo $user_data['user_email']; ?>" />
                </div>
                <div class="form-group">
                    <label>Birth day (<?php echo $diff->format('%y') ?>)</label>
                    <input type="date" id="user_birth_date" name="user_birth_date" value="<?php echo $user_data['user_birth_date']; ?>" min="1915-01-01" max="2015-12-31">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="user_password" id="user_password" class="form-control" data-parsley-minlength="6" data-parsley-maxlength="12" data-parsley-pattern="^[a-zA-Z]+$" required value="<?php echo $user_data['user_password']; ?>" />
                </div>
                <div class="form-group text-center">
                    <input type="submit" name="edit" class="btn btn-primary" value="Edit" />
                </div>
            </form>
            <?php echo $message; ?>
        </div>
    </div>
</body>

</html>