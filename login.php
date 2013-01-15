<?php
	include 'model/init.php';
	logged_in_redirect();
	
		
	if (empty($_POST) === false) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if (empty($username) === true || empty($password) === true) {
			$errors[] = "You need to enter a username and password.";
		} else if ( user_exists($username) === false ) {
			$errors[] = "Cannot find username... Have you registered?";
		} else if (user_active($username) === false) {
			$errors[] = "This user is not active!";
		} else {
		 					
		 	$login = login($username, $password);
			if ($login === false ){
				$errors[] = "That username/password combination are incorrect!";
			} else {
				//die($login);
				//set the user session
				// redirect user to home
				$_SESSION['user_id'] = $login;
				header('Location: index.php');
				exit();
			}
		}
		
		
	} else {
		$errors[] = 'We did not receive any data';
		
	}
	
include 'includes/overall/overallHeader.php';
if (empty($errors) === false) {
		
	echo '<h2>We tried to log you in, but...</h2>';
	echo output_errors($errors);
}

include 'includes/overall/overallFooter.php';
?>
	
