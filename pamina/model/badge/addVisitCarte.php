<?php

	include("../../connexion/logs.php");
	// update carte_visite
	require_once("../../connexion/SQLconnect.php");

	$id = $_POST['idUser'];
	$carteNum = $_POST['carteNum'];

	switch ($carteNum) {
		case 1:
			if (!($req = $con->prepare("UPDATE Utilisateur SET carte1_visite = 1 WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
		case 2:
			if (!($req = $con->prepare("UPDATE Utilisateur SET carte2_visite = 1 WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
		case 3:
			if (!($req = $con->prepare("UPDATE Utilisateur SET carte3_visite = 1 WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
		case 4:
			if (!($req = $con->prepare("UPDATE Utilisateur SET carte4_visite = 1 WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
		case 200:
			if (!($req = $con->prepare("UPDATE Utilisateur SET all_carte_visited = 1 WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
	}

	if (!$req->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	mysqli_close($con);

?> 