<?php 

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $_SESSION['user'] = array();
        $_SESSION['errors'] = array();
    }
    //$_SESSION['errors'] = array(); 
    //$_SESSION['user'] = array();

    /*if (isset($_POST['register_btn'])){
        
        register($data);
    }*/

    if (isset($_GET['signin'])) {
        session_destroy();
        unset($_SESSION['user']);
        $this->response->redirect('/terrorism-api/api/home/login');
        //header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&','', ''), '/terrorism-api/api/home/login'), true, 302);
        //header("location: login");
	}

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <link href="../css/styles.css" rel="stylesheet">
	<title>Terrorism</title>
</head>
<body>
    <div class="page-wrapper">

        <div class="container">
            <h2 class="tag">Register Page</h2>
            <p>In order to login, you must create an account first.</p>
        </div>

        <form method="POST" action="/terrorism-api/api/user/create">
            
            <?php echo display_error(); ?>

            <h2 class="tag">Register</h2>

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
                Already a member? <a class="button" href="register?signin=1">Sign in</a>
            </p>
        </form>
    </div>
</body>
</html>