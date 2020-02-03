<?php

	include("../connexion/logs.php");
	require_once("../connexion/SQLconnect.php");

	$id = htmlspecialchars($_POST['idUser']);

	if (!($req = $con->prepare("SELECT score FROM Utilisateur WHERE id=?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("i", $id)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	// compare les code secret prof
	$req->bind_result($score);
	$req->fetch();

	echo json_encode($score);

	mysqli_close($con);

?> 