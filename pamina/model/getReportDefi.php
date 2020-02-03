<?php

include("../connexion/logs.php");
require_once("../connexion/SQLconnect.php");

	$array = [];
	
	$result = $con->query("SELECT * FROM Reporting");
	while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
		$array[] = $row;
	}

	$result->close();

	mysqli_close($con);

	// $array[0]['test'] = "test";
echo json_encode($array);
?>