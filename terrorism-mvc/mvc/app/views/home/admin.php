<?php 


    if (!isAdmin()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login');
	}
	

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['user']);
        header("location: login");
	}

	// pls do not remove the comment! not yet at least
	if (isset($_GET['cleanup'])) {
		//cleanup();
	}
	if (isset($_GET['setup'])) {
        //setup();
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
		<h2 class="tag">Admin - Home Page</h2>
		<p>Now that you are logged in as an admin, you can create new users or modify your database.</p>
	</div>
	<!--
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>
		-->

		<div class="container">
		<h2 class="tag">User Profile</h2>
		<?php  if (isset($_SESSION['user'])) : ?>
			
			<p>Username: <?php echo json_decode($_SESSION['user'])->{'username'}; ?></p>
			<p>Email: <?php echo json_decode($_SESSION['user'])->{'email'}; ?></p>
			<p>User type: <?php echo json_decode($_SESSION['user'])->{'user_type'}; ?></p>
			<p>Password: <?php echo json_decode($_SESSION['user'])->{'password'}; ?></p>
				
	        <p><a class="button" href="admin?logout='1'">Logout</a>
            <p><a class="button" href="create_user"> + Add user</a></p>
			<p><a class="button" href="admin?cleanup='1'">Cleanup database</a></p>
			<p><a class="button" href="admin?setup='1'">Setup database</a></p>

		<?php endif ?>
		
		</div>
	</div>
</body>
</html>