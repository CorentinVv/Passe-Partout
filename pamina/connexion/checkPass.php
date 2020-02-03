<?php 

	require("PassHash.php");

	$oldPass = htmlspecialchars($_POST['oldPass']);
	$checkOld = htmlspecialchars($_POST['checkOld']);

	if(PassHash::check_password($oldPass, $checkOld)){
		$state = true;
	}else{
		$state = false;
	}

	echo json_encode($state);


?>