<?php 

	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
    
    if (isset($_POST['login_btn'])) {
        login($data);
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
		<h2 class="tag">Login Page</h2>
		<p>To access the form, you have to be logged in as a user first.</p>
		<p>To create another admin/modify the database, you have to be logged in as an admin first.</p>
	</div>
		
	
	<form method="POST" action="login" enctype="multipart/form-data">

		<?php echo display_error(); ?>

        <h2 class="tag">Login</h2>

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
			<button type="submit" name="login_btn">Login</button>
		</p>
		<p>
			Not yet a member? <a class="button" href="register">Sign up</a>
		</p>
	</form>
</div>

</body>
</html>