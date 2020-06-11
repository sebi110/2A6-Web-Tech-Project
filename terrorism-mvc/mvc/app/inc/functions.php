<?php 
    session_start();

	$_SESSION['errors'] = array(); 

	// REGISTER USER
	function register($data){

        $username = "";
        $email    = "";       
        $user = $data['user'];
        $userDao = $data['userDao'];
    
        $username    =  e($_POST['username']);
        $email       =  filter_var(e($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password_1  =  e($_POST['password_1']);
        $password_2  =  e($_POST['password_2']);
    
        if ($password_1 != $password_2) {
            array_push($_SESSION['errors'], "The two passwords do not match!");
        }

        if(!empty($userDao->findByUsername($username))){
            array_push($_SESSION['errors'], "There is another user with the same username! Please choose another username!");
        }
    
        // register user if there are no errors in the form
        if (empty($_SESSION['errors'])) {
            $password = md5($password_1);//encrypt the password before saving in the database
    
            if (isset($_POST['user_type'])) {
                $user_type = e($_POST['user_type']);
                               
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
        
        $username = e($_POST['username']);
        $password = e($_POST['password']);

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
    
    function fromJson($object, $field){
        return json_decode($object)->{$field};
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

        $_SESSION['attack_form'] = array(
            'correctForm' => 0,
        );
        foreach($_GET as $key=>$value)
        {
            if($key=="submit" || $key=="url")continue;
            if(empty(e($_GET[$key])))
            {
                if($key=='mode')
                    $_SESSION['attack_form'][$key]='PieChart';
                else
                    $_SESSION['attack_form'][$key]='all';
            }
            else $_SESSION['attack_form'][$key]=$value;
        }

        if(!in_array(e($_GET['targtype']), $data['targets']) && !empty(e($_GET['targtype'])) ){

            array_push($_SESSION['errors'], "Choose a target from the list or no target at all!");
        }

        if (empty($_SESSION['errors'])) {

            (empty(e($_GET['targtype'])) == true) ? $target = 'all' : $target = e($_GET['targtype']);

            // for Airports & Aircraft goddamn
            $target = str_replace("&", "and", $target);

            $_SESSION['attack_form']['targtype'] = $target;
            $_SESSION['attack_form']['correctForm']=1;
        }

        $query = http_build_query($_SESSION['attack_form']);
        header("location: form?" . $query);
 
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

    function e($x){
        return htmlEntities($x, ENT_QUOTES);
    }


?>