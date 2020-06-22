<?php

    session_start();

    function clean($data) {
        return trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
    }

    function cleanUrl($url) {
        return filter_var($url, FILTER_SANITIZE_URL);
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

    // this will have to go
    function attack_form($data){

        $_SESSION['attack_form'] = array(
            'correctForm' => 0,
        );
        foreach($_GET as $key=>$value)
        {
            if($key=='submit' || $key=='url')continue;
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
    