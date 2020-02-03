<?php
	$con = mysqli_connect("to_complete","to_complete","to_complete", "to_complete");

	if(!$con) die('Could not connect: ' . mysql_error());
	
	mysqli_set_charset($con, "utf8");
?>