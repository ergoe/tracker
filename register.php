<?php 
include 'model/init.php';
include 'includes/overall/overallHeader.php'; 

if (empty($_POST) === false) {
	$required_fields = array("username", "password", "password_again", "first_name", "email");
		
	foreach($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Fields marked with an * are required';
			break;
		}
	}
	/*Validates all the fields */
	if (empty($errors) === true) {
		if (user_exists($_POST['username']) === true)  {
			$errors[] = 'Sorry the username \''. htmlentities($_POST['username']). '\' is already taken.';
		}
		
		if (preg_match("/\\s/", $_POST['username']) == true) {
			$errors[] = 'Your username must not contain any spaces.';
		}
		
		if (strlen($_POST['password']) < 6) {
			$errors[] = 'Sorry your password is not at least 6 characters long.';
		}
				
		if ($_POST['password'] != $_POST['password_again']) {
			$errors[] = 'The entered passwords do not match';
		}
		
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL === false)) {
			$errors[] = 'Please Enter a valid email address.';
		}
		
		if (email_exists($_POST['email']) === true)  {
			$errors[] = 'Sorry the email \''. htmlentities($_POST['email']). '\' is already taken.';
		}
	}	
}

?>
		
<h1>Register</h1>

<?php
logged_in_redirect();

// checks to see of the success is at the end of the url and is empty
if (isset($_GET['success']) && empty($_GET['success'])) {
	echo 'You\'ve been registered successfully!  Please check your email to activate your account';
} else {

	if (empty($_POST) === false && empty($errors) === true) {
		$register_data = array(
			'username'	=> $_POST['username'],
			'password'	=> $_POST['password'],
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'user_email' => $_POST['email'],
			'email_code' => md5($_POST['username'] + microtime())
		);
				
		register_user($register_data);
		
		?>
		<script type="text/javascript">
			$(function() {
				$.post("http://www.ergoesdomain.com/emailsender/sendEmail.aspx",
				{
					email_type: "register",
					email: "<?php echo $_POST['email']; ?>",
					email_code: "<?php echo $register_data['email_code']; ?>"
				},
				function(data, textStatus)
				{
					var response = data;
					window.location = "register.php?success"
				});
			});	
		</script>
		
		<?php
		//need to add redirect from aspx page
		//sleep(5);
		//redirecting the user in the jquery post
		//header('Location: register.php?success');
		exit();
	} else if (empty($errors) === false){
		echo output_errors($errors);
	}

?>

	<form action="" method="post">
		<!--<form action="" method="post"></form>-->
		<ul>
			<li>
				Username*:<br>
				<input type="text" name="username"
			</li>
			<li>
				Password*:<br>
				<input type="password" name="password">
			</li>
			<li>
				Password Again*:<br>
				<input type="password" name="password_again"
			</li>
			<li>
				First Name*:<br>
				<input type="text" name="first_name">
			</li>
			<li>
				Last Name:<br>
				<input type="text" name="last_name">
			</li>
			<li>
				Email*:<br>
				<input type="text" name="email"
			</li>
			<li>
				<input type="submit" value="Register"
			</li>
		</ul>
	</form>
		

<?php
} // end of else 
	include 'includes/overall/overallFooter.php'; 
?>