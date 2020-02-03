<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	if (!($req = $con->prepare("SELECT SUM(nb_visite) FROM stats_visites"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	$req->bind_result($nbVisites);
	$req->fetch();
	$req->close();

	if (!($req2 = $con->prepare("SELECT COUNT(ip) FROM stats_visites"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}
			
	if (!$req2->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req2->errno . ") " . $req2->error;
	}
	
	$req2->bind_result($nbIp);
	$req2->fetch();
	$req2->close();

	$res = array('nbVisites' => "$nbVisites", 'nbIp' => "$nbIp");

	echo json_encode($res);

	mysqli_close($con);

?> 