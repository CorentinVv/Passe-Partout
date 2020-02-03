<?php

	include("../connexion/logs.php");
	// update scores
	require_once("../connexion/SQLconnect.php");

	$id = $_POST['idUser'];
	$posDeTop = $_POST['posDeTop'];
	$posDeLeft = $_POST['posDeLeft'];

	if (!($req = $con->prepare("UPDATE Utilisateur SET de_top=?, de_left=? WHERE id=?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("iii", $posDeTop,$posDeLeft,$id)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	mysqli_close($con);

?> 