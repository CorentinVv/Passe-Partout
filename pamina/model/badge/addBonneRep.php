<?php

	include("../../connexion/logs.php");
	// update nb_bonne_reponse
	require_once("../../connexion/SQLconnect.php");

	$id = $_POST['idUser'];
	$ed = strtolower($_POST['ed']);

	if (!($req = $con->prepare("UPDATE Utilisateur SET nb_bonne_reponse = nb_bonne_reponse + 1 WHERE id=?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	// Par ED
	$sql = "UPDATE Utilisateur SET nb_bonne_reponse_".$ed." = nb_bonne_reponse_".$ed." + 1 WHERE id=?";
	if (!($req1 = $con->prepare($sql))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req1->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req1->errno . ") " . $req1->error;
	}
			
	if (!$req1->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req1->errno . ") " . $req1->error;
	}

	mysqli_close($con);

?> 