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
        if (isset($_SESSION['user']))
			if($_SESSION['user']['user_type'] == 'admin')
            	return true;
		
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

    function display_msg() {

		if (!empty($_SESSION['msg'])){
			echo '<div class="msg">';
				
			echo $_SESSION['msg'] .'<br>';
				
			echo '</div>';
		}
    }
