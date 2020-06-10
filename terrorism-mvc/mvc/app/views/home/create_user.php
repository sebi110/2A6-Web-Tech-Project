<?php 

    include('functions.php');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        register($data, $errors);

    }


?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Registration - Create user</title>
	<meta charset="utf-8">
    <link href="../../public/css/form.css" rel="stylesheet">
</head>
<body>

	<form method="POST" action="create_user" enctype="multipart/form-data">

		<?php echo display_error(); ?>

        <h2>Admin - create user</h2>

		<p>
			<label>Username</label>
			<input type="text" name="username" required>
            <span></span>
		</p>
		<p>
			<label>Email</label>
			<input type="email" name="email" required>
            <span></span>
		</p>
		<p>
			<label>User type</label>
			<select name="user_type" id="user_type" required>
				<option value=""></option>
				<option value="admin">Admin</option>
				<option value="user">User</option>
			</select>
            <span></span>
		</p>
		<p>
			<label>Password</label>
			<input type="password" name="password_1" required>
            <span></span>
		</p>
		<p>
			<label>Confirm password</label>
			<input type="password" name="password_2" required>
            <span></span>
		</p>
		<p>
			<button type="submit" class="btn" name="register_btn"> + Create user</button>
		</p>
	</form>
</body>
</html>