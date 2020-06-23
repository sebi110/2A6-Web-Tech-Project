<?php 

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $_SESSION['user'] = array();
        $_SESSION['errors'] = array();
    }


    if (isset($_GET['signup'])) {
        session_destroy();
        unset($_SESSION['user']);
        $this->response->redirect('/terrorism-api/api/home/register');
	}

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Terrorism</title>
	<meta charset="utf-8">
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
	<div class="page-wrapper">

	<div class="container">
		<h2 class="tag">Login Page</h2>
		<p>To access the form, you have to be logged in as a user first.</p>
	</div>
		
	
	<form method="POST" action="/terrorism-api/api/user/find">
	
		<input type="hidden" id="form" name="form" value="1">

		<p><?php echo display_error(); ?></p>
		<p><?php echo display_msg(); ?></p>

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
			Not yet a member? <a class="button" href="login?signup=1">Sign up</a>
		</p>
	</form>
</div>

</body>
</html>