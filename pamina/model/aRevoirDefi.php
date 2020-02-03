<?php

	include("../connexion/logs.php");
	// update Défi état
	require_once("../connexion/SQLconnect.php");

	$id = $_POST['id_defi'];
	$type = $_POST['type_defi'];
	$remarque = $_POST['msg_defi'];

	switch ($type) {
		case 'qcm':
			if (!($req = $con->prepare("UPDATE QCM SET etat='revoir', remarque=? WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
		case 'trou':
			if (!($req = $con->prepare("UPDATE TexteTrous SET etat='revoir', remarque=? WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
		case 'vocal':
			if (!($req = $con->prepare("UPDATE VocalTexte SET etat='revoir', remarque=? WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
		case 'frise':
			if (!($req = $con->prepare("UPDATE FriseChrono SET etat='revoir', remarque=? WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
		case 'classement':
			if (!($req = $con->prepare("UPDATE DefiClassement SET etat='revoir', remarque=? WHERE id=?"))) {
				echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
			}
			break;
	}

	if (!$req->bind_param("si", $remarque,$id)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	mysqli_close($con);

?> 