<?php
	$connect_error = 'Sorry we seem to having a connection issue!!! Be Back Shortly!!';
    mysql_connect('localhost', 'loginUser', 'ergoeL@nce71') or die ($connect_error);
	mysql_select_db('loginusers');
	
?>