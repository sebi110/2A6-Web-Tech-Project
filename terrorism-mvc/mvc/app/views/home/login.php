<?php 

    include('functions.php');
    
    if (isset($_POST['login_btn'])) {
        login($data);
    }

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Registration</title>
	<meta charset="utf-8">
    <link href="../../public/css/form.css" rel="stylesheet">
</head>
<body>
	
	<form method="POST" action="login" enctype="multipart/form-data">

		<?php echo display_error(); ?>

        <h2>Login</h2>

		<p>
			<label>Username</label>
			<input type="text" name="username" required>
            <span></span>
		</p>
		<p>
			<label>Password</label>
			<input type="password" name="password" required>
            <span></span>
		</p>
		<p>
			<button type="submit" class="btn" name="login_btn">Login</button>
		</p>
		<p>
			Not yet a member? <a href="register">Sign up</a>
		</p>
	</form>
</body>
</html>