<?php

	include("../connexion/logs.php");
	// update moyenne
	require_once("../connexion/SQLconnect.php");

	$idClass = $_POST['idClass'];
	$total = $_POST['total'];

	if (!($req = $con->prepare("UPDATE Classe SET moyenne=? WHERE id=?"))) {
		echo "Echec de la préparation : (" . $con->errno . ") " . $con->error;
	}

	if (!$req->bind_param("ii", $total,$idClass)) {
		echo "Echec lors du liage des paramètres : (" . $req->errno . ") " . $req->error;
	}
			
	if (!$req->execute()) {
		echo "Echec lors de l'exécution de la requête : (" . $req->errno . ") " . $req->error;
	}

	mysqli_close($con);

?> 