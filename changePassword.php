<?php
   
include 'model/init.php';
protect_page();

if (empty($_POST) === false) {
	$required_fields = array("current_password", "password", "password_again");
	
	foreach($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Fields marked with an * are required';
			break;
		}
	}
	
	if (md5($_POST['current_password']) === $user_data['password']) {
		if (trim($_POST['password']) != trim($_POST['password_again'])) {
			$errors[] = "Your new passwords do not match!!";
		} else if (strlen($_POST['password']) < 6) {
			$errors[] = 'Sorry your password is not at least 6 characters long.';
		}
		
	} else {
		$errors[] = 'Sorry you did not enter the correct password.';
	}
	
}

include 'includes/overall/overallHeader.php';


?>
		
<h1>Change Password</h1>

<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	echo 'Your password has been changed.';
} else {
	if (isset($_GET['force']) === true && empty($_GET['force']) === true) {
	?>
	<p>You must change your password now that you've requested a new password?</p>	
	<?php
	}
	
	if (empty($_POST) === false && empty($errors) === true) {
		//posted the form and no errors
		echo $session_user_id, $_POST['password'];
		change_password($session_user_id, $_POST['password']);
		header('Location: changePassword.php?success');
	} else if (empty($errors) === false) {
		//output errors
		echo output_errors($errors);
	}
?>

	
	<form action="" method="post">
		<ul>
			<li>
				Current Password*:<br>
				<input type="password" name="current_password">
			</li>
			<li>
				New Password*:<br>
				<input type="password" name="password">
			</li>
			<li>
				New Password Again*:<br>
				<input type="password" name="password_again">
			</li>
			<li>
				<input type="submit" value="Change Password">
			</li>
		</ul>
	</form>

<?php 
}
include 'includes/overall/overallFooter.php'; 
?>
