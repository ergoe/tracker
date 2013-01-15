<?php 
include 'model/init.php';
include 'includes/overall/overallHeader.php';
protect_page();

if (isset($_GET['username']) === true && empty($_GET['username']) === false) {
		
	$username = 	$_GET['username'];
	if (user_exists($username) === true) {
		$user_id = 		user_id_from_username($username);
		$profile_data = user_data($user_id, 'first_name', 'last_name', 'user_email');
	?>
		<h1><?php echo $profile_data['first_name']; ?>'s Profile</h1>	
		<div id='profile-List_box'>
			<ul id='profile_list' class='profile_list'>
				<li>First Name: <?php echo $profile_data['first_name']; ?></li>
				<li>Last Name: <?php echo $profile_data['last_name']; ?></li>
				<li>Email Address: <?php echo $profile_data['user_email']; ?></li>
			</ul>
		</div>
	<?php
	} else {
		echo 'Sorry, that username does not exist..';
	}
	
} else {
	header('Location: index.php');
	exit();
}		
 
include 'includes/overall/overallFooter.php'; 
?>