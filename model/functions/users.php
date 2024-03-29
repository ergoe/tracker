<?php

function has_access($user_id, $type) {
	$user_id 	= (int)$user_id;
	$type 		= (int)$type;
	
	$query = mysql_query("SELECT COUNT('user_id') FROM users WHERE user_id = '$user_id' AND user_type = '$type'");
	if (mysql_result($query, 0) == 1) {
		return true;
	} else {
		return false;
	}
}

function recover($mode, $email) {
	$mode = sanitize($mode);
	$email = sanitize($email);
	
	$user_data = user_data(user_id_from_email($email), 'user_id', 'first_name', 'username', 'user_email');
	if ($mode ==  'username') {
		?>	
		<script type="text/javascript">
			$(function() {
				
				$.post("http://www.ergoesdomain.com/emailsender/sendEmail.aspx",
				{
					username: "<?php echo $user_data['username'];?>",
					first_name: "<?php echo $user_data['first_name'];?>",
					email: "<?php echo $user_data['user_email']; ?>",
					email_type: "username"
				},
				function(data, textStatus)
				{
					var response = data;
					window.location = "recover.php?success"
				});
			});	
		</script>
		<?php
		// body:
		// Hello $user_data['first_name'], \n\nYour username is $user_data['username']\n\n-phpacademy
	} else if ($mode == 'password') {
		//recover password
		$generated_password =  substr(md5(rand(999, 999999)), 0, 8);
		change_password($user_data['user_id'], $generated_password);
		
		update_user($user_data['user_id'], array('password_recover' => '1'));
		?>	
		<script type="text/javascript">
			$(function() {
				alert('entered into password');
				$.post("http://www.ergoesdomain.com/emailsender/sendEmail.aspx",
				{
					username: "<?php echo $user_data['username'];?>",
					first_name: "<?php echo $user_data['first_name'];?>",
					password: "<?php echo $generated_password; ?>",
					email: "<?php echo $user_data['user_email']; ?>",
					email_type: "password"
				},
				function(data, textStatus)
				{
					var response = data;
					window.location = "recover.php?success"
				});
			});	
		</script>
		<?php
		
	}
}


function update_user($user_id, $update_data) {
	
	$update = array();
	array_walk($update_data, 'array_sanitize');
	$register_data['password'] = md5($register_data['password']);	
	foreach ($update_data as $field=>$data) {
		$update[] = '`' . $field . '` = \'' . $data . '\''; 
	}
		
	mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id") or die(mysql_error());
}

function activate($email, $email_code) {
	$email = mysql_real_escape_string($email);
	$email_code = mysql_real_escape_string($email_code);
	//if there is a user with matching email address and email code
	$query = mysql_query("SELECT COUNT('user_id') FROM users WHERE user_email = '$email' AND email_code = '$email_code' AND active = 0");
	if (mysql_result($query, 0) == 1) {
		//query to update user active status
		mysql_query("UPDATE users SET active = 1 WHERE user_email = '$email'");
		return true;
	} else {
		return false;
	}	
}


function change_password($user_id, $password) {
	$user_id = (int)$user_id;
	$password = md5($password);
		
	mysql_query("UPDATE users SET password = '$password', password_recover = 0 WHERE user_id = $user_id");
}

function register_user($register_data) {
	array_walk($register_data, 'array_sanitize');
	$register_data['password'] = md5($register_data['password']);	
		
	$fields = '`' . implode('`, `', array_keys($register_data)). '`';
	$data = '\'' . implode('\', \'',  $register_data). '\'';
	
	mysql_query("INSERT INTO users ($fields) VALUES ($data)");
	
}



function user_count() {
	$query = mysql_query("SELECT COUNT('user_id') FROM users WHERE active = 1");
	return mysql_result($query, 0);
}

function user_data($user_id) {
	$data = array();
	$user_id = (int)$user_id;
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1) {
		unset($func_get_args[0]);
		
		//$fields = '`' . implode('`, `', $func_get_args). '`';
		$fields = implode(', ', $func_get_args);
		
		$result = mysql_query("SELECT $fields FROM users WHERE user_id = $user_id");
		$data = mysql_fetch_assoc($result);
							
		return $data;
	}
}

function logged_in() {
	return (isset($_SESSION['user_id'])) ? true : false;
}

function user_exists($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT('user_id') FROM users WHERE username = '$username'");
	
	return (mysql_result($query, 0) == 1) ? true : false;
}

function email_exists($email) {
	$user_email = sanitize($email);
	$query = mysql_query("SELECT COUNT('user_id') FROM users WHERE user_email = '$user_email'");
	
	return (mysql_result($query, 0) == 1) ? true : false;
}

function user_active($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT('user_id') FROM users WHERE username = '$username' AND active = 1");
	
	return (mysql_result($query, 0) == 1) ? true : false;
}

function user_id_from_username($username) {
	$username = sanitize($username);
	$result = mysql_result(mysql_query("SELECT user_id FROM users WHERE username = '$username'"), 0, 'user_id'); 
	
	return $result;
	
}

function user_id_from_email($email) {
	$email = sanitize($email);
	$result = mysql_result(mysql_query("SELECT user_id FROM users WHERE user_email = '$email'"), 0, 'user_id'); 
	
	return $result;
	
}

function login($username, $password) {
	$user_id = user_id_from_username($username);
	
	$username = sanitize($username);
	$password = md5($password);
	$password = $password;
	
	$result = (mysql_result(mysql_query("SELECT COUNT('user_id') FROM users WHERE username = '$username' AND password = '$password'"), 0) == 1) ? $user_id : false;
	return $result;
}


?>