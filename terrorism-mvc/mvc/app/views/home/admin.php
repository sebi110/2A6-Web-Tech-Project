<?php 
    include('functions.php');

    if (!isAdmin()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login');
	}
	

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['user']);
        header("location: login");
	}
	if (isset($_GET['cleanup'])) {
        
        //header("location: cleanup");
	}
	if (isset($_GET['setup'])) {
        
        //header("location: setup");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <link href="../../public/css/form.css" rel="stylesheet">

</head>
<body>
	<div class="header">
		<h2>Admin - Home Page</h2>
	</div>
	<div class="content">
		<!-- notification message -->
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

		<!-- logged in user information -->
		<div class="profile_info">
			
			<?php  if (isset($_SESSION['user'])) : ?>
			<strong><?php echo $_SESSION['user']; ?></strong>

			<small>
				<br>
				<a href="admin?logout='1'">logout</a>
                &nbsp; <a href="create_user"> + add user</a><br>
				<a href="admin?cleanup='1'">cleanup db</a><br>
				<a href="admin?setup='1'">setup db</a><br>
			</small>

			<?php endif ?>
			
		</div>
	</div>
</body>
</html>