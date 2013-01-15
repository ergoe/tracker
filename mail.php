<?php 
include 'model/init.php';
include 'includes/overall/overallHeader.php';
protect_page();
admin_protect();
 ?>
		
<h1>Email all users</h1>

<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
?>
	<p>Email has been sent</p>
<?php
	
} else {
	if (empty($_POST) === false) {
		if (empty($_POST['subject']) === true) {
			$errors[] = 'Subject is required';
		}
		
		if (empty($_POST['body']) === true) {
			$errors[] = 'Body is required';
		}
		
		if (empty($errors) === false) {
			echo output_errors($errors);
		} else {
			//send email
			//mail_users($_POST['subject'], $_POST['body']);
			header('Location: mail.php?success');
			exit();
		}
		
	}
	
?>		

<form action="" method="post">
	<ul>
		<l1>
			Subject*:<br />
			<input type="text" name="subject">
		</l1>
		<li>
			Body*:<br />
			<textarea name="body"></textarea>
		</li>
		<li>
			<input type="submit" value="Send">
		</li>
	</ul>
</form>

<?php 
}
include 'includes/overall/overallFooter.php'; 
?>