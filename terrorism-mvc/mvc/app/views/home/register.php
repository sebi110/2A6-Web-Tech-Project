<?php 

    include('functions.php');

    if (isset($_POST['register_btn'])){
        
        register($data);
    }

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <link href="../../public/css/form.css" rel="stylesheet">
	<title>Registration</title>
</head>
<body>

    <form method="POST" action="register" enctype="multipart/form-data">
        
        <?php echo display_error(); ?>

        <h2>Register</h2>

        <p>
            <label>Username</label>
            <input type="text" name="username" id="username" required>
            <span></span>
        </p>
        <p>
            <label>Email</label>
            <input type="email" name="email" id="email" required>
            <span></span>
        </p>
        <p>
            <label>Password</label>
            <input type="password" name="password_1" id="password_1" required>
            <span></span>
        </p>
        <p>
            <label>Confirm password</label>
            <input type="password" name="password_2" id="password_2" required>
            <span></span>
        </p>
        <p>
            <button type="submit" name="register_btn">Register</button>
        </p>
        <p>
            Already a member? <a href="login">Sign in</a>
        </p>
    </form>
</body>
</html>