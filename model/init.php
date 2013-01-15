<?php
    session_start();
	//error_reporting(0);
	
	require 'database/connect.php';
	require 'functions/general.php';
	require 'functions/users.php';
	
	//end() takes gets the last element in the array
	$current_file = end(explode('/', $_SERVER['SCRIPT_NAME']));
	
	if (logged_in() === true) {
		$session_user_id = $_SESSION['user_id'];
		$user_data = user_data($session_user_id, 'user_id', 'first_name', 'last_name', 'user_email', 'username', 'password', 'password_recover', 'user_type', 'allow_email');
		if (user_active($user_data['username']) === false) {
			session_destroy();
			header('Location: index.php');
			exit();
		}
		if ( $current_file !== 'changePassword.php' && $current_file !== 'logout.php' && $user_data['password_recover'] == 1) {
			header('Location: changePassword.php?force');
			exit();
		}
		
	}
	
	$errors = array();
	//added to handle header redirects
	// because redirects do not work after print/echo or html this  all of this
	// is written to a buffer to be output to the page 
	ob_start();
?>