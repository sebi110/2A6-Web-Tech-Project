<?php 

    //session_start();
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        $this->response->redirect('/terrorism-api/api/home/login');
    }

    // log user out if logout button clicked
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['user']);
        $this->response->redirect('/terrorism-api/api/home/login');
        //header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&','', ''), '/terrorism-api/api/home/login'), true, 302);
        //header("location: login");
    }
    
    if (isset($_GET['form'])) {
        $this->response->redirect('/terrorism-api/api/home/form');
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
      <h2 class="tag">Home Page</h2>
      <p>Now that you are logged in, you may click the form to check out some attacks.</p>
      
      <p>session: <?php print_r($_SESSION['user']); ?></p>
    </div>
    <!--  
      <?php if (isset($_SESSION['success'])) : ?>
        <div class="container">
          <p>
            <?php 
              echo $_SESSION['success']; 
              unset($_SESSION['success']);
            ?>
          </p>
        </div>
      <?php endif ?>
      -->
    <div class="container">
      <h2 class="tag">User Profile</h2>
      <?php  if (isset($_SESSION['user'])) : ?>
        
        <p>Username: <?php echo $_SESSION['user']['username']; ?></p>
        <p>Email: <?php echo $_SESSION['user']['email']; ?></p>
        <p>User type: <?php echo $_SESSION['user']['user_type']; ?></p>
        <!--p>Password: <?php echo $_SESSION['password']['password']; ?></p-->
            
        <p>	<a class="button" href="index?logout='1'">Logout</a></p>
            
            
        <p><a class="button" href="index?form='1'">Form</a></p>

      <?php endif ?>
    </div>


	</div>
</body>
</html>

