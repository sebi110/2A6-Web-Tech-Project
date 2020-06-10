<?php 
	include('functions.php');
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login');
    }

    // log user out if logout button clicked
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['user']);
        header("location: login");
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
		<h2>Home Page</h2>
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

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']; ?></strong>

					<small>
						<a href="index?logout='1'">logout</a>
					<small>
					<small>
						<a href="form">form</a>
					<small>

				<?php endif ?>
			</div>
		</div>
	</div>
</body>
</html>