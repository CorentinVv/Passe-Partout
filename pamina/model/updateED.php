<?php

	include("../connexion/logs.php");
	// update scores
	require_once("../connexion/SQLconnect.php");

	$id = $_POST['idUser'];
	$eurodistrict = $_POST['eurodistrict'];


	if (!($req = $con->prepare("UPDATE Utilisateur SET ed=? WHERE id=?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("si", $eurodistrict,$id)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	mysqli_close($con);

?> 