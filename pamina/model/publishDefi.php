<?php

	include("../connexion/logs.php");
	// update Défi état
	require_once("../connexion/SQLconnect.php");

	$id = $_POST['id_defi'];
	$type = $_POST['type_defi'];
	$idCrea = $_POST['id_creator'];

	$points = 0;

	switch ($type) {
		case 'qcm':
			if (!($req = $con->prepare("UPDATE QCM SET etat='publier' WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			$points = 200;
			break;
		case 'trou':
			if (!($req = $con->prepare("UPDATE TexteTrous SET etat='publier' WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			$points = 200;
			break;
		case 'vocal':
			if (!($req = $con->prepare("UPDATE VocalTexte SET etat='publier' WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			$points = 200;
			break;
		case 'frise':
			if (!($req = $con->prepare("UPDATE FriseChrono SET etat='publier' WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			$points = 350;
			break;
		case 'classement':
			if (!($req = $con->prepare("UPDATE DefiClassement SET etat='publier' WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			$points = 350;
			break;
	}

	if (!$req->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}else{
		// On donne les points à l'utilisateur
		$req->prepare("UPDATE Utilisateur SET score = score + ? WHERE id = ?");
		$req->bind_param("ii", $points,$idCrea);
		if (!$req->execute()) {
		     echo "Echec lors de l'exécution de la requête : (" . $con->errno . ") " . $con->error;
		}
	}

	mysqli_close($con);

?> 