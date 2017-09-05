<?php
	$myfile = htmlspecialchars(file_get_contents("http://10.10.10.20/auth.php"));
	echo $myfile;
?>
