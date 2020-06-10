<?php 
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        register($data);

    }


?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Terrorism</title>
	<meta charset="utf-8">
    <link href="../../public/css/styles.css" rel="stylesheet">
</head>
<body>
	<div class="page-wrapper">

	<div class="container">
        <h2 class="tag">Admin -Create User Page</h2>
        <p>As an admin, you can create an account for another admin or another user.</p>
    </div>

	<form method="POST" action="create_user" enctype="multipart/form-data">

		<?php echo display_error(); ?>

        <h2 class="tag">Create User</h2>

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
			<button type="submit" name="register_btn"> + Create user</button>
		</p>
	</form>
</body>
</html>