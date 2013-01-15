<?php
	
function send_email($to, $subject, $body) {
	//talk to the aspx api and send the email
}

function array_sanitize(&$item) {
	$item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}	

function admin_protect() {
	global $user_data;
	//User acces level of 1 equals admin
	if (has_access($user_data['user_id'], 1) === false) {
		header('Location: index.php');
		exit();
	}
}

function protect_page() {
	if (logged_in() === false) {
		header('Location: protected.php');
		exit();
	}
}

function logged_in_redirect() {
	if(logged_in() === true) {
		header('Location: index.php');
		exit();
	}
}

function sanitize($data) {
	return htmlentities(strip_tags(mysql_escape_string($data)));
}

function output_errors($errors) {
	$output = array();
	foreach ( $errors as $error) {
		$output[] = '<li>' . $error .'</li>';
	}	
	return '<ul>' . implode('', $output) . '</ul>';
}

?>