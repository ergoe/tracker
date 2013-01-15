<div class="widget">
	<h2>Hello, <?php echo $user_data['first_name']; ?></h2>
	<div class = "inner">
		<ul>
			<li>
				<a href="logout.php">Logout</a>
			</li>
			<li>
				<!--<a href="<?php echo $user_data['username']; ?>">Profile</a>-->
				<a href="profile.php?username=<?php echo $user_data['username']; ?>">Profile</a>
			</li>
			<li>
				<a href="changePassword.php">Change Password</a>
			</li>
			<li>
				<a href="settings.php">Settings</a>
			</li>
		</ul>
		
		links
	</div> <!-- class widget-->
</div> <!-- class inner-->
 