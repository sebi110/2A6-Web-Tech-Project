<?php 

    if (!isAdmin()) {
        $_SESSION['msg'] = "You must log in first";
        $this->response->redirect('/terrorism-api/api/home/login');
    }
	

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['user']);
        $this->response->redirect('/terrorism-api/api/home/login');
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
		<h2 class="tag">Admin - Home Page</h2>
		<p>Now that you are logged in as an admin, you can read(get), create(post), delete(delete) or update(put) users.</p>
	</div>

		<div class="container">
        <?php echo session_id(); ?>
		<h2 class="tag">Admin Profile</h2>
		<?php  if (isset($_SESSION['user'])) : ?>
			
			<p>Username: <?php echo $_SESSION['user']['username']; ?></p>
            <p>Email: <?php echo $_SESSION['user']['email']; ?></p>
            <p>User type: <?php echo $_SESSION['user']['user_type']; ?></p>
            <!--p>Password: <?php echo $_SESSION['password']['password']; ?></p-->
                
            <p>	<a class="button" href="index?logout='1'">Logout</a></p>
                
                
            <!--p><a class="button" href="index?form='1'">Form</a></p-->
		<?php endif ?>
        </div>

        <form method="POST" action="/terrorism-api/api/user/form">

        <input type="hidden" name="REQUEST_METHOD" value="GET">

            <?php echo display_error(); ?>

            <h2 class="tag">Request method: GET</h2>
            <!--p>
                <label for="mode">Method</label>
                <input type="text" name="meth" id="meth" list="methList" required>
                <span></span>
                <datalist id="methList">
                <?php foreach($data['meth'] as $meth) : ?>
			        <option><?php echo $meth; ?></option>			
                <?php endforeach; ?>
                </datalist>
                
            </p-->

            <p>Query Params</p> 

            <p>
                <label for="key1">Key1</label>
                <input type="text" name="key1" id="key1" list="keyList">
                <span></span>
                <datalist id="keyList">
                <?php foreach($data['keys'] as $key) : ?>
			        <option><?php echo $key; ?></option>			
                <?php endforeach; ?>
                </datalist>
                
            </p>

            <p>
                <label for="val1">Value1</label>
                <input type="text" name="val1" id="val1">
                <span></span>
                
            </p>
            
            <p>
                <button type="submit" name="submit">SEND</button>
                <button type="reset" name="reset">RESET</button>
            </p>
    
        </form>

        <form method="POST" action="/terrorism-api/api/user/form">

        <input type="hidden" name="REQUEST_METHOD" value="POST">

            <h2 class="tag">Request method: POST</h2>

            <p>Query Params</p> 

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
                <label for="user_type">User type</label>
                <input type="text" name="user_type" id="user_type" list="utList" value="User" required>
                <span></span>
                <datalist id="utList">
                    <option>User</option>			
                    <option>Admin</option>
                </datalist>
                
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
                <button type="submit" name="submit">SEND</button>
                <button type="reset" name="reset">RESET</button>
            </p>
    
        </form>

        <form method="POST" action="/terrorism-api/api/user/form">

        <input type="hidden" name="REQUEST_METHOD" value="DELETE">

            <h2 class="tag">Request method: DELETE</h2>

            <p>Query Params</p> 

            <p>
                <label for="key1">Key1</label>
                <input type="text" name="key1" id="key1" list="keyList">
                <span></span>
                <datalist id="keyList">
                <?php foreach($data['keys'] as $key) : ?>
			        <option><?php echo $key; ?></option>			
                <?php endforeach; ?>
                </datalist>
                
            </p>

            <p>
                <label for="val1">Value1</label>
                <input type="text" name="val1" id="val1">
                <span></span>
                
            </p>
            
            <p>
                <button type="submit" name="submit">SEND</button>
                <button type="reset" name="reset">RESET</button>
            </p>
    
        </form>

        <form method="POST" action="/terrorism-api/api/user/form">

        <input type="hidden" name="REQUEST_METHOD" value="PUT">

            <h2 class="tag">Request method: PUT</h2>

            <p>Query Params(for whom I want to updadte)</p> 

            <p>
                <label for="key1">Key1</label>
                <input type="text" name="key1" id="key1" list="keyList">
                <span></span>
                <datalist id="keyList">
                <?php foreach($data['keys'] as $key) : ?>
			        <option><?php echo $key; ?></option>			
                <?php endforeach; ?>
                </datalist>
                
            </p>

            <p>
                <label for="val1">Value1</label>
                <input type="text" name="val1" id="val1">
                <span></span>
                
            </p>

            <p>Request Body(what I want to update)</p> 

            <p>
                <label>Email</label>
                <input type="email" name="email" id="email">
                <span></span>
            </p>
            <p>
                <label for="user_type">User type</label>
                <input type="text" name="user_type" id="user_type" list="utList" value="User">
                <span></span>
                <datalist id="utList">
                    <option>User</option>			
                    <option>Admin</option>
                </datalist>
                
            </p>
            <p>
                <label>Password</label>
                <input type="password" name="password" id="password">
                <span></span>
            </p>

            <p>
                <button type="submit" name="submit">SEND</button>
                <button type="reset" name="reset">RESET</button>
            </p>
    
        </form>

	</div>
</body>
</html>