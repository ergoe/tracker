<?php 
include 'model/init.php';
include 'includes/overall/overallHeader.php';
 ?>
		
<h1>Home</h1>
<p>Just a Template</p>		

<?php 

if (isset($_SESSION['user_id']) ) {
	echo "logged In";
} else {
	echo "Not logged in";
}
if (isset($_SESSION['user_id']) && has_access($_SESSION['user_id'], 1) === true) {
	?>
		<h1>Access Level Administrator</h1>
	<?php
} else if (isset($_SESSION['user_id']) && has_access($_SESSION['user_id'], 2) === true) {
	?>
		<h1>Access Level = 2</h1>
	<?php	
} else {
	?>
		<h1>General Access</h1>
	<?php
}



?>

<?php 
include 'includes/overall/overallFooter.php'; 
?>