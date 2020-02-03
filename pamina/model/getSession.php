<?php
session_start();

include("../connexion/logs.php");
require_once("../connexion/SQLconnect.php");

$login = $_SESSION['user']["login"];
	
	$result = $con->query("SELECT * FROM Utilisateur WHERE login='".$login."'");
	while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
		$array[] = $row;
	}  

	$_SESSION['user'] = $array[0];

echo json_encode($_SESSION['user']);
?>