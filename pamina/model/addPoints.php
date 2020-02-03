<?php

	include("../connexion/logs.php");
	// update scores
	require_once("../connexion/SQLconnect.php");

	$id = $_POST['idUser'];
	$points = $_POST['points'];

	if ($points>=0) {
		if (!($req = $con->prepare("UPDATE Utilisateur SET score=score+? WHERE id=?"))) {
			echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}
	}elseif ($points<0) {
		$points = abs($points);
		if (!($req = $con->prepare("UPDATE Utilisateur SET score=score-? WHERE id=?"))) {
			echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
		}
	}

	if (!$req->bind_param("ii", $points,$id)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	mysqli_close($con);

?> 