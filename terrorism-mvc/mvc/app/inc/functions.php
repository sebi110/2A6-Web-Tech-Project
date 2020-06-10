<?php 
    session_start();
    
    //this should be moved from views

	$_SESSION['errors'] = array(); 

	// REGISTER USER
	function register($data){

        $username = "";
        $email    = "";       
        $user = $data['user'];
        $userDao = $data['userDao'];
    
        $username    =  htmlEntities($_POST['username'], ENT_QUOTES);
        $email       =  htmlEntities($_POST['email'], ENT_QUOTES);
        $password_1  =  htmlEntities($_POST['password_1'], ENT_QUOTES);
        $password_2  =  htmlEntities($_POST['password_2'], ENT_QUOTES);
    
        if ($password_1 != $password_2) {
            array_push($_SESSION['errors'], "The two passwords do not match");
        }
    
        // register user if there are no errors in the form
        if (empty($_SESSION['errors'])) {
            $password = md5($password_1);//encrypt the password before saving in the database
    
            if (isset($_POST['user_type'])) {
                $user_type = htmlEntities($_POST['user_type'], ENT_QUOTES);
                               
                $user->set(array(
                    '_id' => 0,
                    'username' => $username, 
                    'email' => $email, 
                    'user_type' => $user_type, 
                    'password' => $password
                ));
    
                $userDao->insert($user);
                $_SESSION['success']  = "New user successfully created!!";
                header('location: admin');
            }else{

                $user->set(array(
                    '_id' => 0,
                    'username' => $username, 
                    'email' => $email, 
                    'user_type' => 'user', 
                    'password' => $password
                ));
                $userDao->insert($user);
                
                $_SESSION['user'] = $user->toJson();
                $_SESSION['success']  = "You are now logged in";
                header('location: index');				
            }
        }
    }
		
	// LOGIN USER

	function login($data){
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $data['user'];
        $userDao = $data['userDao'];

        // attempt login if no errors on form
        if (empty($_SESSION['errors'])) {
            $password = md5($password);

            $user = $userDao->findLog($username, $password);
        
            if (!empty($user)) { // user found
                // check if user is admin or user
                
                if ($user->get()->user_type == 'admin') {

                    $_SESSION['user'] = $user->toJson();
                    $_SESSION['success']  = "You are now logged in";
                    header('location: admin');		  
                }else{
                    $_SESSION['user'] = $user->toJson();
                    $_SESSION['success']  = "You are now logged in";

                    header('location: index');
                }
            }else {
                array_push($_SESSION['errors'], "Wrong username/password combination");
            }
        }
    }

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin() {
        if (isset($_SESSION['user']) && json_decode($_SESSION['user'])->{'user_type'} == 'admin')
            return true;
		else
		    return false;
        
	}

	function display_error() {

		if (!empty($_SESSION['errors'])){
			echo '<div class="error">';
				foreach ($_SESSION['errors'] as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
    }

    // FORM
    
    function attack_form($data){

        if(!in_array($_GET['targtype'], $data['targets']) && !empty($_GET['targtype']) ){

            array_push($_SESSION['errors'], "Choose a target from the list or no target at all!");
        }

        if (empty($_SESSION['errors'])) {

            (empty($_GET['targtype']) == true) ? $target = 'all' : $target = $_GET['targtype'];

            // for Airports & Aircraft goddamn
            $target = str_replace("&", "and", $target);
                
            $_SESSION['attack_form'] = array(
                'iyear' => $_GET['iyear'],
                'targtype' => $target,
                'count' => $_GET['count']
            );

            $query = http_build_query($_SESSION['attack_form']);
            
            header("location: form?" . $query);

        }
 
    }

    // DB

    function cleanup(){
        require_once '../app/models/AttackDao.php';

        (new AttackDao())->cleanup();
        
        echo "Cleanup successful";
    }

    function setup(){

        require_once '../app/models/AttackDao.php';

        (new AttackDao())->setup();
        
        echo "Setup successful";
    }


?>